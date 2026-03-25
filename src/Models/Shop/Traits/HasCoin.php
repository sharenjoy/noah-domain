<?php

namespace Sharenjoy\NoahDomain\Models\Shop\Traits;

use DateTimeInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Sharenjoy\NoahDomain\Models\Shop\CoinMutation;

trait HasCoin
{
    /*
     |--------------------------------------------------------------------------
     | Accessors
     |--------------------------------------------------------------------------
     */

    /**
     * Shoppingmoney coin accessor.
     *
     * @return int
     */
    public function getShoppingmoneyAttribute()
    {
        return $this->coin('shoppingmoney');
    }

    /**
     * Cancoin coin accessor.
     *
     * @return int
     */
    public function getPointAttribute()
    {
        return $this->coin('point');
    }

    /*
     |--------------------------------------------------------------------------
     | Methods
     |--------------------------------------------------------------------------
     */

    public function coin(string $type, $date = null)
    {
        $date = $date ?: Carbon::now();

        if (! $date instanceof DateTimeInterface) {
            $date = Carbon::create($date);
        }

        return (int) $this->coinMutations()
            ->where('type', $type)
            ->where('created_at', '<=', $date->format('Y-m-d H:i:s'))
            ->sum('amount');
    }

    public function increaseCoin(string $type, $amount = 1, $arguments = [])
    {
        return $this->createCoinMutation($type, $amount, $arguments);
    }

    public function decreaseCoin(string $type, $amount = 1, $arguments = [])
    {
        return $this->createCoinMutation($type, -1 * abs($amount), $arguments);
    }

    public function mutateCoin(string $type, $amount = 1, $arguments = [])
    {
        return $this->createCoinMutation($type, $amount, $arguments);
    }

    public function clearCoin(string $type, $newAmount = null, $arguments = [])
    {
        $this->coinMutations()->where('type', $type)->delete();

        if (! is_null($newAmount)) {
            $this->createCoinMutation($type, $newAmount, $arguments);
        }

        return true;
    }

    public function setCoin(string $type, $newAmount, $arguments = [])
    {
        $currentCoin = $this->$type;

        if ($deltaCoin = $newAmount - $currentCoin) {
            return $this->createCoinMutation($type, $deltaCoin, $arguments);
        }
    }

    public function inCoin(string $type, $amount = 1)
    {
        return $this->$type > 0 && $amount <= $this->$type;
    }

    public function outOfCoin(string $type)
    {
        return $this->$type <= 0;
    }

    /**
     * Function to handle mutations (increase, decrease).
     *
     * @param  int  $amount
     * @param  array  $arguments
     * @return bool
     */
    protected function createCoinMutation(string $type, $amount, $arguments = [])
    {
        $reference = Arr::get($arguments, 'reference');

        $createArguments = collect([
            'type' => $type,
            'amount' => $amount,
            'order_id' => Arr::get($arguments, 'order_id'),
            'description' => Arr::get($arguments, 'description'),
        ])->when($reference, function ($collection) use ($reference) {
            return $collection
                ->put('reference_type', $reference->getMorphClass())
                ->put('reference_id', $reference->getKey());
        })->toArray();

        return $this->coinMutations()->create($createArguments);
    }

    /*
     |--------------------------------------------------------------------------
     | Scopes
     |--------------------------------------------------------------------------
     */

    public function scopeWhereInCoin($query, $type)
    {
        return $query->where(function ($query) use ($type) {
            return $query->where('type', $type)->whereHas('coinMutations', function ($query) {
                return $query->select('coinable_id')
                    ->groupBy('coinable_id')
                    ->havingRaw('SUM(amount) > 0');
            });
        });
    }

    public function scopeWhereOutOfCoin($query, $type)
    {
        return $query->where(function ($query) use ($type) {
            return $query->where('type', $type)->whereHas('coinMutations', function ($query) {
                return $query->select('coinable_id')
                    ->groupBy('coinable_id')
                    ->havingRaw('SUM(amount) <= 0');
            })->orWhereDoesntHave('coinMutations');
        });
    }

    /*
     |--------------------------------------------------------------------------
     | Relations
     |--------------------------------------------------------------------------
     */

    /**
     * Relation with CoinMutation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\morphMany
     */
    public function coinMutations()
    {
        return $this->morphMany(CoinMutation::class, 'coinable');
    }

    public function pointCoinMutations()
    {
        return $this->morphMany(CoinMutation::class, 'coinable')->whereType('point');
    }

    public function shoppingmoneyCoinMutations()
    {
        return $this->morphMany(CoinMutation::class, 'coinable')->whereType('shoppingmoney');
    }
}

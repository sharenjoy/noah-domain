<?php

namespace Sharenjoy\NoahDomain\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Sharenjoy\NoahDomain\Enums\CoinType;
use Sharenjoy\NoahDomain\Models\Shop\Order;
use Sharenjoy\NoahDomain\Models\Shop\Promo;
use Sharenjoy\NoahDomain\Models\Cms\Traits\CommonModelTrait;

class CoinMutation extends Model
{
    use CommonModelTrait;

    protected $guarded = [];

    protected $casts = [
        'type' => CoinType::class,
    ];

    protected $fillable = [
        'promo_id',
        'order_id',
        'coinable_type',
        'coinable_id',
        'reference_type',
        'reference_id',
        'type',
        'amount',
        'description',
    ];

    /**
     * CoinMutation constructor.
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable('coin_mutations');
    }

    /**
     * Relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function coinable()
    {
        return $this->morphTo();
    }

    /**
     * Relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function reference()
    {
        return $this->morphTo();
    }

    public function promo(): BelongsTo
    {
        return $this->belongsTo(Promo::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}

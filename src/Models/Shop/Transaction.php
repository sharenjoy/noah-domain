<?php

namespace Sharenjoy\NoahDomain\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Sharenjoy\NoahDomain\Actions\GenerateSeriesNumber;
use Sharenjoy\NoahDomain\Models\Cms\Traits\CommonModelTrait;
use Sharenjoy\NoahDomain\Models\Shop\Invoice;
use Sharenjoy\NoahDomain\Models\Shop\Order;
use Sharenjoy\NoahShop\Actions\Shop\ChargeExpireDateSetting;
use Sharenjoy\NoahDomain\Enums\PaymentMethod;
use Sharenjoy\NoahDomain\Enums\PaymentProvider;
use Sharenjoy\NoahDomain\Enums\TransactionStatus;

class Transaction extends Model
{
    use CommonModelTrait;

    protected $casts = [
        'status' => TransactionStatus::class,
        'provider' => PaymentProvider::class,
        'payment_method' => PaymentMethod::class,
        'expired_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    protected array $sort = [
        'created_at' => 'desc',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->sn) {
                $model->sn = GenerateSeriesNumber::run(model: 'transaction', prefix: 'T', strLeng: 4);
            }

            if ($model->payment_method == PaymentMethod::ATM->value) {
                $model = ChargeExpireDateSetting::run(transaction: $model);
            }
        });
    }

    /** RELACTIONS */

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    /** SCOPES */

    /** EVENTS */

    /** OTHERS */
}

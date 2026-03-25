<?php

namespace Sharenjoy\NoahDomain\Models\Shop;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Sharenjoy\NoahDomain\Actions\GenerateSeriesNumber;
use Sharenjoy\NoahDomain\Models\Cms\Traits\CommonModelTrait;
use Sharenjoy\NoahDomain\Models\Shop\Invoice;
use Sharenjoy\NoahDomain\Models\Shop\InvoicePrice;
use Sharenjoy\NoahDomain\Models\Shop\OrderItem;
use Sharenjoy\NoahDomain\Models\Shop\OrderShipment;
use Sharenjoy\NoahDomain\Models\Shop\Transaction;
use Sharenjoy\NoahDomain\Models\Shop\User;
use Sharenjoy\NoahDomain\Enums\OrderShipmentStatus;
use Sharenjoy\NoahDomain\Enums\OrderStatus;
use Sharenjoy\NoahDomain\Enums\TransactionStatus;

class BaseOrder extends Model
{
    use CommonModelTrait;
    // use HasReactions;

    protected $casts = [
        'status' => OrderStatus::class,
    ];

    protected array $sort = [
        'created_at' => 'desc',
        'id' => 'desc',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->sn) {
                $model->sn = GenerateSeriesNumber::run('order');
            }
        });
    }

    /** RELACTIONS */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function shipments(): HasMany
    {
        return $this->hasMany(OrderShipment::class, 'order_id')->orderBy('created_at', 'desc');
    }

    public function shipment(): HasOne
    {
        return $this->hasOne(OrderShipment::class, 'order_id')->orderBy('created_at', 'desc');
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class, 'order_id');
    }

    public function invoicePrices(): HasMany
    {
        return $this->hasMany(InvoicePrice::class, 'order_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'order_id')->orderBy('created_at', 'desc');
    }

    public function transaction(): HasOne
    {
        return $this->hasOne(Transaction::class, 'order_id')->orderBy('created_at', 'desc');
    }

    /** SCOPES */

    // 非取消已成立的訂單
    public function scopeValidOrders($query): Builder
    {
        return $query->whereNotIn('status', [
            OrderStatus::Initial,
            OrderStatus::Cancelled
        ]);
    }

    // 已成立的訂單
    public function scopeEstablishedOrders($query): Builder
    {
        return $query->whereNotIn('status', [
            OrderStatus::Initial,
        ]);
    }

    public function scopeNew($query): Builder
    {
        return $query->whereIn('status', [
            OrderStatus::New,
        ]);
    }

    public function scopePending($query): Builder
    {
        return $query->whereIn('status', [
            OrderStatus::Pending,
        ]);
    }

    public function scopeCancelled($query): Builder
    {
        return $query->whereIn('status', [
            OrderStatus::Cancelled,
        ]);
    }

    public function scopeFinished($query): Builder
    {
        return $query->whereIn('status', [
            OrderStatus::Finished,
        ]);
    }

    // 可出貨訂單
    public function scopeShippable($query): Builder
    {
        return $query->whereIn('status', [
            OrderStatus::Processing,
        ])->whereHas('shipment', function ($query) {
            $query->whereIn('status', [OrderShipmentStatus::New]);
        })->whereHas('transaction', function ($query) {
            $query->where('status', TransactionStatus::Paid)->orWhere('total_price', 0);
        });
    }

    // 已出貨訂單
    public function scopeShipped($query): Builder
    {
        return $query->whereIn('status', [
            OrderStatus::Processing,
        ])->whereHas('shipment', function ($query) {
            $query->whereIn('status', [OrderShipmentStatus::Shipped]);
        });
    }

    // 已送達訂單
    public function scopeDelivered($query): Builder
    {
        return $query->whereIn('status', [
            OrderStatus::Processing,
        ])->whereHas('shipment', function ($query) {
            $query->whereIn('status', [OrderShipmentStatus::Delivered]);
        });
    }

    // 退貨/退款/取消中訂單
    public function scopeIssued($query): Builder
    {
        return $query->where('status', OrderStatus::Processing)
            ->where(function ($query) {
                $query->whereHas('shipment', function ($query) {
                    $query->whereIn('status', [
                        OrderShipmentStatus::Returning,
                        OrderShipmentStatus::Returned,
                    ]);
                })->orWhereHas('transaction', function ($query) {
                    $query->whereIn('status', [
                        TransactionStatus::Refunding,
                        TransactionStatus::Refunded,
                    ]);
                });
            });
    }

    public function getCurrentScope(): ?string
    {
        if ($this->status === OrderStatus::New) {
            return 'new';
        }

        if (
            $this->status === OrderStatus::Processing &&
            $this->shipment &&
            in_array($this->shipment->status, [OrderShipmentStatus::New]) &&
            ($this->transaction && ($this->transaction->status === TransactionStatus::Paid || $this->transaction->total_price == 0))
        ) {
            return 'shippable';
        }

        if (
            $this->status === OrderStatus::Processing &&
            $this->shipment &&
            in_array($this->shipment->status, [OrderShipmentStatus::Shipped])
        ) {
            return 'shipped';
        }

        if (
            $this->status === OrderStatus::Processing &&
            $this->shipment &&
            in_array($this->shipment->status, [OrderShipmentStatus::Delivered])
        ) {
            return 'delivered';
        }

        if (
            $this->status === OrderStatus::Processing &&
            (
                ($this->shipment && in_array($this->shipment->status, [
                    OrderShipmentStatus::Returning,
                    OrderShipmentStatus::Returned,
                ])) ||
                ($this->transaction && in_array($this->transaction->status, [
                    TransactionStatus::Refunding,
                    TransactionStatus::Refunded,
                ]))
            )
        ) {
            return 'issued';
        }

        if ($this->status === OrderStatus::Pending) {
            return 'pending';
        }

        if ($this->status === OrderStatus::Cancelled) {
            return 'cancelled';
        }

        if ($this->status === OrderStatus::Finished) {
            return 'finished';
        }

        return null;
    }

    /** EVENTS */

    /** OTHERS */

}

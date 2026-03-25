<?php

namespace Sharenjoy\NoahDomain\Models\Shop;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Sharenjoy\NoahDomain\Actions\GenerateSeriesNumber;
use Sharenjoy\NoahDomain\Models\Cms\Traits\CommonModelTrait;
use Sharenjoy\NoahDomain\Models\Shop\Order;
use Sharenjoy\NoahDomain\Enums\DeliveryProvider;
use Sharenjoy\NoahDomain\Enums\DeliveryType;
use Sharenjoy\NoahDomain\Enums\OrderShipmentStatus;

class OrderShipment extends Model
{
    use CommonModelTrait;

    protected $casts = [
        'status' => OrderShipmentStatus::class,
        'provider' => DeliveryProvider::class,
        'delivery_type' => DeliveryType::class,
    ];

    protected $appends = [
        'delivery_method',
        'call',
    ];

    protected array $sort = [
        'created_at' => 'desc',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->sn) {
                $model->sn = GenerateSeriesNumber::run(model: 'shipment', prefix: 'S', strLeng: 4);
            }
        });
    }

    /** RELACTIONS */

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /** SCOPES */

    /** EVENTS */

    /** OTHERS */

    protected function deliveryMethod(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => DeliveryProvider::getLabelFromOption($attributes['provider']) . ' ' . DeliveryType::getLabelFromOption($attributes['delivery_type']),
        );
    }

    protected function call(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => '+' . $attributes['calling_code'] . ' ' . $attributes['mobile']
        );
    }
}

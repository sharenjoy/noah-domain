<?php

namespace Sharenjoy\NoahDomain\Models\Shop;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Sharenjoy\NoahDomain\Enums\OrderItemType;
use Sharenjoy\NoahDomain\Models\Shop\Product;
use Sharenjoy\NoahDomain\Models\Shop\ProductSpecification;
use Sharenjoy\NoahDomain\Models\Cms\Traits\CommonModelTrait;
use Sharenjoy\NoahDomain\Models\Shop\Traits\HasPromos;

class OrderItem extends Model
{
    use CommonModelTrait;
    use HasPromos;

    protected $guarded = [];

    protected $casts = [
        'type' => OrderItemType::class,
        'preorder' => 'boolean',
        'quantity' => 'integer',
        'product_details' => 'json',
    ];

    protected $appends = [
        'price_discounted',
        'subtotal',
    ];

    protected array $sort = [
        'created_at' => 'asc',
    ];

    /** RELACTIONS */

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function productSpecification(): BelongsTo
    {
        return $this->belongsTo(ProductSpecification::class);
    }

    public function shipment(): BelongsTo
    {
        return $this->belongsTo(OrderShipment::class);
    }

    /** SCOPES */

    /** EVENTS */

    /** OTHERS */

    protected function priceDiscounted(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => $attributes['price'] + $attributes['discount']
        );
    }

    protected function subtotal(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => ($attributes['price'] + $attributes['discount']) * $attributes['quantity']
        );
    }
}

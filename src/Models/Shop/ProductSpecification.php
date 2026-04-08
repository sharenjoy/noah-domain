<?php

namespace Sharenjoy\NoahDomain\Models\Shop;

use Appstract\Stock\HasStock;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Sharenjoy\NoahDomain\Models\Shop\Product;
use Sharenjoy\NoahDomain\Models\Cms\Traits\CommonModelTrait;
use Sharenjoy\NoahDomain\Models\Cms\Traits\HasMediaLibrary;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Translatable\HasTranslations;

class ProductSpecification extends Model implements Sortable
{
    use CommonModelTrait;
    use SortableTrait;
    use HasTranslations;
    use HasMediaLibrary;
    use HasStock;

    protected $guarded = [];

    protected $casts = [
        'spec_detail_name' => 'json',
        'album' => 'array',
        'is_active' => 'boolean',
    ];

    protected $appends = [
        'spec',
    ];

    public $translatable = [
        'content',
    ];

    protected array $sort = [
        'order_column' => 'asc',
    ];

    /** RELACTIONS */

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /** SCOPES */

    /** EVENTS */

    /** OTHERS */

    protected function spec(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => join(',', json_decode($attributes['spec_detail_name'], true))
        );
    }

    public function getLabelAttribute()
    {
        return "{$this->no} {$this->product->title} ({$this->spec})";
    }
}

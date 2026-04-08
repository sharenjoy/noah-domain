<?php

namespace Sharenjoy\NoahDomain\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use RalphJSmit\Laravel\SEO\SchemaCollection;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use Sharenjoy\NoahDomain\Models\Shop\Brand;
use Sharenjoy\NoahDomain\Models\Shop\ProductSpecification;
use Sharenjoy\NoahDomain\Models\Cms\Traits\CommonModelTrait;
use Sharenjoy\NoahDomain\Models\Cms\Traits\HasCategoryTree;
use Sharenjoy\NoahDomain\Models\Cms\Traits\HasMediaLibrary;
use Sharenjoy\NoahDomain\Models\Cms\Traits\HasTags;
use Sharenjoy\NoahDomain\Utils\JsonLD;
use Sharenjoy\NoahDomain\Utils\Media;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Translatable\HasTranslations;

class Product extends Model implements Sortable
{
    use CommonModelTrait;
    use SoftDeletes;
    use SortableTrait;
    use HasTranslations;
    use HasMediaLibrary;
    use HasCategoryTree;
    use HasTags;
    use HasSEO;

    protected $guarded = [];

    protected $casts = [
        'album' => 'array',
        'categories' => 'array',
        'specs' => 'json',
        'stock_method' => 'json',
        'product_limit' => 'json',
        'is_single_spec' => 'boolean',
        'is_active' => 'boolean',
        'published_at' => 'datetime',
    ];

    public $translatable = [
        'title',
        'description',
        'content',
    ];

    protected array $sort = [
        'published_at' => 'desc',
    ];

    /** RELACTIONS */

    public function tags(): MorphToMany
    {
        return $this
            ->morphToMany(self::getTagClassName(), $this->getTaggableMorphName(), $this->getTaggableTableName())
            ->using($this->getPivotModelClassName())
            ->where('type', 'product')
            ->ordered();
    }

    public function specifications(): HasMany
    {
        return $this->hasMany(ProductSpecification::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /** SCOPES */

    /** EVENTS */

    /** SEO */

    public function getDynamicSEOData(): SEOData
    {
        // TODO
        $path = route('products.detail', ['product' => $this], false);

        return new SEOData(
            title: $this->seo->getTranslation('title', app()->currentLocale()) ?: $this->title,
            description: $this->seo->description ?: $this->description,
            author: $this->seo->author ?: config('app.name'),
            image: $this->seo->image ? Media::imgUrl($this->seo->image) : Media::imgUrl($this->img),
            enableTitleSuffix: false,
            alternates: $this->getAlternateTag($path),
            schema: SchemaCollection::make()->add(fn(SEOData $SEOData) => JsonLD::article($SEOData, $this)),
        );
    }

    /** OTHERS */

}

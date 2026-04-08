<?php

namespace Sharenjoy\NoahDomain\Models\Shop;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use Sharenjoy\NoahDomain\Models\Cms\Traits\CommonModelTrait;
use Sharenjoy\NoahDomain\Models\Cms\Traits\HasMediaLibrary;
use Sharenjoy\NoahDomain\Models\Cms\Traits\HasMenus;
use Sharenjoy\NoahDomain\Models\Cms\Traits\HasTags;
use Sharenjoy\NoahDomain\Models\Shop\Giftproduct;
use Sharenjoy\NoahDomain\Models\Shop\Objective;
use Sharenjoy\NoahDomain\Models\Shop\OrderItem;
use Sharenjoy\NoahDomain\Models\Shop\UserCoupon;
use Sharenjoy\NoahDomain\Utils\JsonLD;
use Sharenjoy\NoahDomain\Utils\Media;
use Sharenjoy\NoahDomain\Enums\ObjectiveType;
use Sharenjoy\NoahDomain\Enums\PromoAutoGenerateType;
use Sharenjoy\NoahDomain\Enums\PromoDiscountType;
use Sharenjoy\NoahDomain\Enums\PromoType;
use Spatie\Translatable\HasTranslations;

class BasePromo extends Model
{
    use CommonModelTrait;
    use SoftDeletes;
    use HasTranslations;
    use HasMediaLibrary;
    use HasMenus;
    use HasTags;
    use HasSEO;

    protected $guarded = [];

    protected $casts = [
        'type' => PromoType::class,
        'discount_type' => PromoDiscountType::class,
        'auto_generate_type' => PromoAutoGenerateType::class,
        'album' => 'array',
        'forever' => 'boolean',
        'combined' => 'boolean',
        'entire_order_discount_percent' => 'boolean',
        'auto_assign_to_user' => 'boolean',
        'is_active' => 'boolean',
        'started_at' => 'datetime',
        'expired_at' => 'datetime',
        'display_expired_at' => 'datetime',
        'published_at' => 'datetime',
    ];

    protected $appends = [
        'online',
        'show_up',
        'generatable',
    ];

    public $translatable = [
        'title',
        'description',
        'content',
    ];

    protected array $sort = [
        'published_at' => 'desc',
        'id' => 'desc',
    ];

    /** RELACTIONS */

    public function promoTags(): MorphToMany
    {
        return $this
            ->morphToMany(self::getTagClassName(), $this->getTaggableMorphName(), $this->getTaggableTableName())
            ->using($this->getPivotModelClassName())
            ->where('type', 'promo')
            ->ordered();
    }

    public function orderItems(): MorphToMany
    {
        return $this->morphedByMany(OrderItem::class, 'promoable', foreignPivotKey: 'promo_id', relatedPivotKey: 'promoable_id');
    }

    public function giftproducts(): MorphToMany
    {
        return $this->morphedByMany(Giftproduct::class, 'promoable', foreignPivotKey: 'promo_id', relatedPivotKey: 'promoable_id');
    }

    public function objectives(): MorphToMany
    {
        return $this->morphedByMany(Objective::class, 'promoable', foreignPivotKey: 'promo_id', relatedPivotKey: 'promoable_id');
    }

    public function userObjectives(): MorphToMany
    {
        return $this->morphedByMany(Objective::class, 'promoable', foreignPivotKey: 'promo_id', relatedPivotKey: 'promoable_id')
            ->whereType(ObjectiveType::User->value);
    }

    public function productObjectives(): MorphToMany
    {
        return $this->morphedByMany(Objective::class, 'promoable', foreignPivotKey: 'promo_id', relatedPivotKey: 'promoable_id')
            ->whereType(ObjectiveType::Product->value);
    }

    public function coupons(): HasMany
    {
        return $this->hasMany(UserCoupon::class);
    }

    /** SCOPES */

    /** EVENTS */

    /** SEO */

    public function getDynamicSEOData(): SEOData
    {
        // TODO
        $path = route('promos.detail', ['promo' => $this], false);

        return new SEOData(
            title: $this->seo->getTranslation('title', app()->currentLocale()) ?: $this->title,
            description: $this->seo->description ?: $this->description,
            author: $this->seo->author ?: config('app.name'),
            image: $this->seo->image ? Media::imgUrl($this->seo->image) : Media::imgUrl($this->img),
            enableTitleSuffix: false,
            alternates: $this->getAlternateTag($path),
            // schema: SchemaCollection::make()->add(fn(SEOData $SEOData) => JsonLD::article($SEOData, $this)),
        );
    }

    /** OTHERS */

    public function online(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (! $this->is_active) {
                    return false;
                }

                $now = now();

                // published_at 必須小於等於現在時間
                if ($this->published_at !== null && $this->published_at->gt($now)) {
                    return false;
                }

                if ($this->forever ?? false) {
                    return true;
                }

                return ($this->started_at === null || $this->started_at->lte($now)) &&
                    ($this->expired_at === null || $this->expired_at->gte($now));
            },
        );
    }

    public function showUp(): Attribute
    {
        return Attribute::make(
            get: function () {
                // published_at 必須小於等於現在時間
                if ($this->display_expired_at === null) {
                    return false;
                }

                return $this->display_expired_at->gt(now());
            },
        );
    }

    /**
     * 這個優惠券是否可以產生
     * @return Attribute
     */
    public function generatable(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (! $this->is_active) {
                    return false;
                }

                if (! $this->auto_assign_to_user) {
                    return false;
                }

                if ($this->forever ?? false) {
                    return true;
                }

                $now = now();

                return ($this->started_at === null || $this->started_at->lte($now)) &&
                    ($this->expired_at === null || $this->expired_at->gte($now));
            },
        );
    }
}

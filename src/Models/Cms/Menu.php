<?php

namespace Sharenjoy\NoahDomain\Models\Cms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use Sharenjoy\NoahDomain\Models\Cms\Category;
use Sharenjoy\NoahDomain\Models\Cms\Traits\CommonModelTrait;
use Sharenjoy\NoahDomain\Models\Cms\Traits\HasCategoryTree;
use Sharenjoy\NoahDomain\Models\Cms\Traits\HasMediaLibrary;
use Sharenjoy\NoahDomain\Utils\JsonLD;
use Sharenjoy\NoahDomain\Utils\Media;
// use SolutionForest\FilamentTree\Concern\ModelTree;
use Spatie\Translatable\HasTranslations;

class Menu extends Model
{
    use CommonModelTrait;
    use SoftDeletes;
    use HasTranslations;
    use HasMediaLibrary;
    // use ModelTree;
    use HasCategoryTree;
    // use HasPromos; //** NoahShop CAN OPEN
    use HasSEO;

    protected $guarded = [];

    protected $casts = [
        'parent_id' => 'int',
        'album' => 'array',
        'is_active' => 'boolean',
    ];

    public $translatable = [
        'title',
        'description',
        'content',
    ];

    protected array $sort = [
        'created_at' => 'desc',
    ];

    /** RELACTIONS */

    // public function promos(): MorphToMany
    // {
    //     return $this->morphedByMany(Promo::class, 'menuable');
    // }

    public function categories(): MorphToMany
    {
        return $this->morphedByMany(Category::class, 'menuable');
    }

    // public function surveys(): MorphToMany
    // {
    //     return $this->morphedByMany(Survey::class, 'menuable');
    // }

    /** SCOPES */

    /** EVENTS */

    /** SEO */

    public function getDynamicSEOData(): SEOData
    {
        // TODO
        $path = route('menus.detail', ['menu' => $this], false);

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

}

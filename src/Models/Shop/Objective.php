<?php

namespace Sharenjoy\NoahDomain\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sharenjoy\NoahDomain\Enums\ObjectiveStatus;
use Sharenjoy\NoahDomain\Enums\ObjectiveType;
use Sharenjoy\NoahDomain\Models\Shop\Product;
use Sharenjoy\NoahDomain\Models\Shop\Promo;
use Sharenjoy\NoahDomain\Models\Cms\Traits\CommonModelTrait;

class Objective extends Model
{
    use CommonModelTrait;
    use SoftDeletes;

    protected $casts = [
        'type' => ObjectiveType::class,
        'status' => ObjectiveStatus::class,
        'user' => 'array',
        'product' => 'array',
        'generated_at' => 'datetime',
    ];

    protected array $sort = [
        'created_at' => 'desc',
    ];

    /** RELACTIONS */

    public function users(): MorphToMany
    {
        return $this->morphedByMany(User::class, 'objectiveable')->with(['validOrders']);
    }

    public function products(): MorphToMany
    {
        return $this->morphedByMany(Product::class, 'objectiveable');
    }

    public function promos(): MorphToMany
    {
        return $this->morphToMany(Promo::class, 'promoable');
    }

    /** SCOPES */

    /** EVENTS */

    /** OTHERS */
}

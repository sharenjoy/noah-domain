<?php

namespace Sharenjoy\NoahDomain\Models\Cms\Traits;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Sharenjoy\NoahDomain\Models\Cms\Category;

trait HasCategoryTree
{
    public function categories(): MorphToMany
    {
        return $this->morphToMany(Category::class, 'categorizable');
    }
}

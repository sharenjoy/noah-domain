<?php

namespace Sharenjoy\NoahDomain\Models\Cms\Traits;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Sharenjoy\NoahDomain\Models\Cms\Menu;

trait HasMenus
{
    public function menus(): MorphToMany
    {
        return $this->morphToMany(Menu::class, 'menuable');
    }
}

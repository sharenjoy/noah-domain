<?php

namespace Sharenjoy\NoahDomain\Models\Shop\Traits;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Sharenjoy\NoahDomain\Models\Shop\Promo;

trait HasPromos
{
    public function promos(): MorphToMany
    {
        return $this->morphToMany(Promo::class, 'promoable');
    }
}

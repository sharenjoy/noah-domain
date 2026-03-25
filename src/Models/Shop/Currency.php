<?php

namespace Sharenjoy\NoahDomain\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Sharenjoy\NoahDomain\Models\Cms\Traits\CommonModelTrait;
use Sharenjoy\NoahDomain\Models\Cms\Traits\HasMediaLibrary;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Currency extends Model
{
    use CommonModelTrait;
    use SortableTrait;
    use HasMediaLibrary;

    protected $casts = [];

    public $translatable = [];

    protected array $sort = [
        'id' => 'asc',
    ];

    /** RELACTIONS */

    /** SCOPES */

    /** EVENTS */

    /** SEO */

    /** OTHERS */
}

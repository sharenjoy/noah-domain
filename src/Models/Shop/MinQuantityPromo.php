<?php

namespace Sharenjoy\NoahDomain\Models\Shop;

use Illuminate\Database\Eloquent\SoftDeletes;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use Sharenjoy\NoahDomain\Models\Shop\BasePromo;
use Sharenjoy\NoahDomain\Models\Cms\Traits\CommonModelTrait;
use Sharenjoy\NoahDomain\Models\Cms\Traits\HasMediaLibrary;
use Spatie\Translatable\HasTranslations;

class MinQuantityPromo extends BasePromo
{
    use CommonModelTrait;
    use SoftDeletes;
    use HasTranslations;
    use HasMediaLibrary;
    use HasSEO;

    protected $table = 'promos';
}

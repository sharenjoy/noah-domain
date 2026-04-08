<?php

namespace Sharenjoy\NoahDomain\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sharenjoy\NoahDomain\Models\Cms\Traits\CommonModelTrait;
use Sharenjoy\NoahDomain\Models\Shop\User;
use Sharenjoy\NoahDomain\Models\Shop\UserLevelStatus;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Translatable\HasTranslations;

class UserLevel extends Model implements Sortable
{
    use CommonModelTrait;
    use SortableTrait;
    use HasTranslations;
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'is_default' => 'boolean',
        'is_active' => 'boolean',
        'album' => 'array',
    ];

    public $translatable = [
        'title',
        'description',
        'content',
    ];

    protected array $sort = [
        'order_column' => 'asc',
    ];

    protected static function booted()
    {
        static::saved(function (UserLevel $userLevel) {
            // 如果 is_default 為 true，將同一 user 的其他地址的 is_default 設為 false
            if ($userLevel->is_default) {
                UserLevel::where('id', '!=', $userLevel->id) // 排除當前地址
                    ->update(['is_default' => false]);
            }
        });
    }

    /** RELACTIONS */

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function userLevelStatuses(): HasMany
    {
        return $this->hasMany(UserLevelStatus::class);
    }

    /** SCOPES */

    /** EVENTS */

    /** SEO */

    /** OTHERS */
}

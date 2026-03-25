<?php

namespace Sharenjoy\NoahDomain\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Sharenjoy\NoahDomain\Enums\UserLevelStatus as UserLevelStatusEnum;
use Sharenjoy\NoahDomain\Models\Cms\Traits\CommonModelTrait;
use Sharenjoy\NoahDomain\Models\Shop\User;
use Sharenjoy\NoahDomain\Models\Shop\UserLevel;

class UserLevelStatus extends Model
{
    use CommonModelTrait;

    protected $casts = [
        'status' => UserLevelStatusEnum::class,
        'started_at' => 'datetime',
        'expired_at' => 'datetime',
    ];

    public $translatable = [];

    protected array $sort = [
        'created_at' => 'desc',
        'id' => 'desc',
    ];

    protected static function boot()
    {
        parent::boot();

        // 用戶等級狀態更新以後，如果狀態是開啟的確保同一個使用者其他狀態狀態是關閉的
        static::saved(function (UserLevelStatus $userLevelStatus) {
            if ($userLevelStatus->status === UserLevelStatusEnum::On) {
                UserLevelStatus::where('id', '!=', $userLevelStatus->id)
                    ->where('user_id', $userLevelStatus->user_id)
                    ->update(['status' => UserLevelStatusEnum::Off]);
            }
        });
    }

    /** RELACTIONS */

    public function userLevel(): BelongsTo
    {
        return $this->belongsTo(UserLevel::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** SCOPES */

    /** EVENTS */

    /** SEO */
}

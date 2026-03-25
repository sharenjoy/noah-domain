<?php

namespace Sharenjoy\NoahDomain\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sharenjoy\NoahDomain\Models\Shop\Promo;
use Sharenjoy\NoahDomain\Models\Cms\Traits\CommonModelTrait;
use Sharenjoy\NoahDomain\Models\Shop\User;
use Sharenjoy\NoahDomain\Models\Shop\UserCouponStatus;

class UserCoupon extends Model
{
    use CommonModelTrait;
    use SoftDeletes;

    protected $casts = [
        'started_at' => 'datetime',
        'expired_at' => 'datetime',
    ];

    public function promo(): BelongsTo
    {
        return $this->belongsTo(Promo::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function userCouponStatuses(): HasMany
    {
        return $this->hasMany(UserCouponStatus::class);
    }
}

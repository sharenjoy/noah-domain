<?php

namespace Sharenjoy\NoahDomain\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Sharenjoy\NoahDomain\Enums\UserCouponStatus as UserCouponStatusEnum;
use Sharenjoy\NoahDomain\Models\Shop\Order;
use Sharenjoy\NoahDomain\Models\Cms\Traits\CommonModelTrait;
use Sharenjoy\NoahDomain\Models\Shop\User;
use Sharenjoy\NoahDomain\Models\Shop\UserCoupon;

class UserCouponStatus extends Model
{
    use CommonModelTrait;

    protected $guarded = [];

    protected $casts = [
        'status' => UserCouponStatusEnum::class,
    ];

    public $translatable = [];

    protected array $sort = [
        'created_at' => 'desc',
        'id' => 'desc',
    ];

    /** RELACTIONS */

    public function userCoupon(): BelongsTo
    {
        return $this->belongsTo(UserCoupon::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /** SCOPES */

    /** EVENTS */

    /** SEO */
}

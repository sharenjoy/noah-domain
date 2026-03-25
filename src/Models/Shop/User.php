<?php

namespace Sharenjoy\NoahDomain\Models\Shop;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Sharenjoy\NoahDomain\Actions\GenerateUserSeriesNumber;
use Sharenjoy\NoahDomain\Models\Cms\Role;
use Sharenjoy\NoahDomain\Models\Cms\Traits\CommonModelTrait;
use Sharenjoy\NoahDomain\Models\Cms\Traits\HasTags;
use Sharenjoy\NoahDomain\Enums\ObjectiveType;
use Sharenjoy\NoahDomain\Enums\UserLevelStatus as EnumsUserLevelStatus;
use Sharenjoy\NoahDomain\Models\Shop\Address;
use Sharenjoy\NoahDomain\Models\Shop\Objective;
use Sharenjoy\NoahDomain\Models\Shop\Order;
use Sharenjoy\NoahDomain\Models\Shop\Traits\HasCoin;
use Sharenjoy\NoahDomain\Models\Shop\UserCoupon;
use Sharenjoy\NoahDomain\Models\Shop\UserCouponStatus;
use Sharenjoy\NoahDomain\Models\Shop\UserLevel;
use Sharenjoy\NoahDomain\Models\Shop\UserLevelStatus;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use CommonModelTrait;
    use Notifiable;
    use SoftDeletes;
    use HasRoles;
    use HasTags;
    use HasCoin;

    protected $fillable = [
        'name',
        'email',
        'password',
        'sn',
        'calling_code',
        'mobile',
        'address',
        'birthday',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = [
        'age',
    ];

    public $translatable = [];

    protected array $sort = [
        'created_at' => 'desc',
        'id' => 'desc',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->sn) {
                $model->sn = GenerateUserSeriesNumber::run('M');
            }

            $userLevel = UserLevel::where('is_default', true)->first();
            if ($userLevel && !$model->user_level_id) {
                $model->user_level_id = $userLevel->id;
            }
        });

        // 用戶建立後將預設的會員等級指定給會員
        static::created(function ($model) {
            if ($model->user_level_id) {
                $userLevel = UserLevel::find($model->user_level_id);
                // 創建用戶等級狀態
                $model->userLevelStatuses()->create([
                    'user_level_id' => $userLevel->id,
                    'status' => EnumsUserLevelStatus::On->value,
                    'started_at' => now(),
                    'expired_at' => now()->addYears($userLevel->level_duration ?? 100)->endOfDay(), // 設置過期時間，且不設置過期時間的話，則預設為 100 年
                ]);
            }
        });

        // 當用戶更新時，如果會員等級資料有變更，則更新會員等級狀態
        static::updating(function ($model) {
            if ($model->isDirty('user_level_id')) {
                $userLevelStatus = $model->userLevelStatuses()->get();
                // 如果有會員等級狀態，則將其狀態設置為 Off
                foreach ($userLevelStatus as $status) {
                    $status->update([
                        'status' => EnumsUserLevelStatus::Off->value,
                    ]);
                }
                // 這裡的邏輯是將所有會員等級狀態設置為 Off，然後再創建一個新的會員等級狀態
                $model->userLevelStatuses()->create([
                    'user_level_id' => $model->user_level_id,
                    'status' => EnumsUserLevelStatus::On->value,
                    'started_at' => now(),
                    'expired_at' => now()->addYears($model->userLevel->level_duration ?? 100)->endOfDay(), // 設置過期時間，且不設置過期時間的話，則預設為 100 年
                ]);
            }
        });
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn(string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }

    public function tags(): MorphToMany
    {
        return $this
            ->morphToMany(self::getTagClassName(), $this->getTaggableMorphName(), $this->getTaggableTableName())
            ->using($this->getPivotModelClassName())
            ->where('type', 'user')
            ->ordered();
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class)->establishedOrders();
    }

    public function validOrders(): HasMany
    {
        return $this->hasMany(Order::class)->validOrders();
    }

    public function objectives(): MorphToMany
    {
        return $this->morphToMany(Objective::class, 'objectiveable')->whereType(ObjectiveType::User->value);
    }

    public function coupons(): HasMany
    {
        return $this->hasMany(UserCoupon::class);
    }

    public function userLevel(): BelongsTo
    {
        return $this->belongsTo(UserLevel::class)->orderBy('order_column', 'asc');
    }

    public function userLevelStatuses(): HasMany
    {
        return $this->hasMany(UserLevelStatus::class);
    }

    public function userCouponStatuses(): HasMany
    {
        return $this->hasMany(UserCouponStatus::class);
    }

    public function scopeSuperAdmin($query)
    {
        return $query->whereHas('roles', function ($query) {
            $query->where('name', 'super_admin');
        });
    }

    public function scopeWithRolesHavingPermissions($query, array $permissions): Builder
    {
        // 查詢同時擁有所有指定權限的角色名稱
        $roles = Role::whereHas('permissions', function ($q) use ($permissions) {
            $q->whereIn('name', $permissions);
        }, '=', count($permissions))->pluck('name');

        // 查詢擁有上述角色的使用者
        return $query->whereHas('roles', function ($q) use ($roles) {
            $q->whereIn('name', $roles);
        });
    }

    // 查詢擁有指定權限的使用者
    public static function getCanHandleShippableUsers()
    {
        return User::withRolesHavingPermissions([
            "view_any_shop::shippable::order",
            "view_shop::shippable::order"
        ])->get();
    }

    public function age(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => $attributes['birthday'] ? Carbon::parse($attributes['birthday'])->age : null,
        );
    }
}

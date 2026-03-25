<?php

namespace Sharenjoy\NoahDomain\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Sharenjoy\NoahDomain\Models\Cms\Traits\CommonModelTrait;

class Address extends Model
{
    use CommonModelTrait;

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public $translatable = [];

    protected array $sort = [
        'is_default' => 'desc',
        'created_at' => 'desc',
    ];

    protected static function booted()
    {
        static::saved(function (Address $address) {
            // 如果 is_default 為 true，將同一 user 的其他地址的 is_default 設為 false
            if ($address->is_default) {
                Address::where('user_id', $address->user_id)
                    ->where('id', '!=', $address->id) // 排除當前地址
                    ->update(['is_default' => false]);
            }
        });
    }

    /** RELACTIONS */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** SCOPES */

    /** EVENTS */

    /** SEO */

    /** OTHERS */

}

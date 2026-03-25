<?php

namespace Sharenjoy\NoahDomain\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Sharenjoy\NoahDomain\Enums\InvoiceHolderType;
use Sharenjoy\NoahDomain\Enums\InvoiceType;
use Sharenjoy\NoahDomain\Models\Shop\InvoicePrice;
use Sharenjoy\NoahDomain\Models\Shop\Order;
use Sharenjoy\NoahDomain\Models\Cms\Traits\CommonModelTrait;

class Invoice extends Model
{
    use CommonModelTrait;

    protected $casts = [
        'type' => InvoiceType::class,
        'holder_type' => InvoiceHolderType::class,
    ];

    protected array $sort = [
        'created_at' => 'desc',
    ];

    /** RELACTIONS */

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function prices(): HasMany
    {
        return $this->hasMany(InvoicePrice::class);
    }

    /** SCOPES */

    /** EVENTS */

    /** OTHERS */
}

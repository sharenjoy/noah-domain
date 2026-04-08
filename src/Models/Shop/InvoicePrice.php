<?php

namespace Sharenjoy\NoahDomain\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Sharenjoy\NoahDomain\Enums\InvoicePriceType;
use Sharenjoy\NoahDomain\Models\Shop\Invoice;
use Sharenjoy\NoahDomain\Models\Shop\Order;
use Sharenjoy\NoahDomain\Models\Shop\Promo;
use Sharenjoy\NoahDomain\Models\Cms\Traits\CommonModelTrait;
use Sharenjoy\NoahDomain\Models\Shop\User;

class InvoicePrice extends Model
{
    use CommonModelTrait;

    protected $guarded = [];

    protected $casts = [
        'type' => InvoicePriceType::class,
    ];

    protected array $sort = [
        'created_at' => 'desc',
    ];

    /** RELACTIONS */

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function promo(): BelongsTo
    {
        return $this->belongsTo(Promo::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /** SCOPES */

    /** EVENTS */

    /** OTHERS */
}

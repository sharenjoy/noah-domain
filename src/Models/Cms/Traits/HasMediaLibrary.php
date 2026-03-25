<?php

namespace Sharenjoy\NoahDomain\Models\Cms\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Sharenjoy\NoahDomain\Models\MediaLibraryItem;

trait HasMediaLibrary
{
    public function thumbnail(): BelongsTo
    {
        return $this->belongsTo(MediaLibraryItem::class, 'img');
    }
}

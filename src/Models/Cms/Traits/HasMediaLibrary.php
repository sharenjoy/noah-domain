<?php

namespace Sharenjoy\NoahDomain\Models\Cms\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

trait HasMediaLibrary
{
    public function thumbnail(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'img');
    }
}

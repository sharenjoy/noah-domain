<?php

namespace Sharenjoy\NoahDomain\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaLibraryItem extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $casts = [];

    protected $guarded = [];

    protected $table = 'filament_media_library';

    public function getMediaLibraryCollectionName(): string
    {
        return 'library';
    }

    public function getDiskVisibility(): string
    {
        return 'public';
    }

    public function getMorphClass(): string
    {
        return 'filament_media_library_item';
    }

    public function getItem(?string $collection = null): Media
    {
        return $this->getFirstMedia($collection ?? $this->getMediaLibraryCollectionName());
    }

    public function getUrl(string $conversionName = ''): string
    {
        $media = $this->getItem();

        return match ($this->getDiskVisibility()) {
            'public' => $media->getUrl($conversionName),
            'private' => $media->getTemporaryUrl(now()->addMinutes(30), $conversionName),
        };
    }
}

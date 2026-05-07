<?php

namespace Sharenjoy\NoahDomain\Utils;

use Spatie\MediaLibrary\MediaCollections\Models\Media as SpatieMedia;

class Media
{
    public static function mediaItem(?int $imageId = null)
    {
        if (! $imageId) return;

        return SpatieMedia::find($imageId)->getItem();
    }

    public static function imgUrl(int|array|null $imageId = null)
    {
        if (! $imageId) return;

        if (is_array($imageId)) {
            $images = [];

            foreach ($imageId as $imgId) {
                $mediaLibraryItem = SpatieMedia::find($imgId);
                $spatieMediaModel = $mediaLibraryItem->getItem();
                $images[] = $spatieMediaModel->getUrl();
            }

            return $images;
        }

        $mediaLibraryItem = SpatieMedia::find($imageId);
        $spatieMediaModel = $mediaLibraryItem->getItem();

        return $spatieMediaModel->getUrl();
    }
}

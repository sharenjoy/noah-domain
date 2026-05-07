<?php

namespace Sharenjoy\NoahDomain\Utils;

use Spatie\MediaLibrary\MediaCollections\Models\Media as SpatieMedia;

class Media
{
    public static function imgUrl(int|array|null $imageId = null)
    {
        if (! $imageId) return;

        if (is_array($imageId)) {
            $images = [];

            foreach ($imageId as $imgId) {
                $mediaLibraryItem = SpatieMedia::find($imgId);
                $images[] = $mediaLibraryItem->getUrl();
            }

            return $images;
        }

        $mediaLibraryItem = SpatieMedia::find($imageId);

        return $mediaLibraryItem->getUrl();
    }
}

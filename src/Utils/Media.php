<?php

namespace Sharenjoy\NoahDomain\Utils;

use Sharenjoy\NoahDomain\Models\MediaLibraryItem;

class Media
{
    public static function mediaItem(?int $imageId = null)
    {
        if (! $imageId) return;

        return MediaLibraryItem::find($imageId)->getItem();
    }

    public static function imgUrl(int|array|null $imageId = null)
    {
        if (! $imageId) return;

        if (is_array($imageId)) {
            $images = [];

            foreach ($imageId as $imgId) {
                $mediaLibraryItem = MediaLibraryItem::find($imgId);
                $spatieMediaModel = $mediaLibraryItem->getItem();
                $images[] = $spatieMediaModel->getUrl();
            }

            return $images;
        }

        $mediaLibraryItem = MediaLibraryItem::find($imageId);
        $spatieMediaModel = $mediaLibraryItem->getItem();

        return $spatieMediaModel->getUrl();
    }
}

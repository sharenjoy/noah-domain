<?php

namespace Sharenjoy\NoahDomain\Utils;

use Illuminate\Database\Eloquent\Model;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use Sharenjoy\NoahDomain\Utils\Media;

// https://developers.google.com/search/docs/appearance/structured-data/article?hl=zh-tw
class JsonLD
{
    public static function article(SEOData $SEOData, Model $model): array
    {
        $images = [];

        if ($model->seo->image) {
            $images[] = Media::imgUrl($model->seo->image);
        }

        if ($model->img) {
            $images[] = Media::imgUrl($model->img);
        }

        if ($model->album) {
            $images = array_merge($images, Media::imgUrl($model->album));
        }

        return [
            "@context" => "https://schema.org",
            "@type" => "NewsArticle",
            "headline" => $model->seo->title ?: $model->title,
            "image" => array_values(array_unique($images)),
            "datePublished" => $model->published_at,
            "dateModified" => $model->updated_at,
            "author" => [
                // [
                //     "@type" => "Person",
                //     "name" => "Jane Doe",
                //     "url" => "https://example.com/profile/janedoe123"
                // ]
            ]
        ];
    }
}

<?php

namespace Sharenjoy\NoahDomain\Models\Cms\Traits;

use Illuminate\Database\Eloquent\Builder;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use RalphJSmit\Laravel\SEO\Support\AlternateTag;

trait CommonModelTrait
{
    protected function getAlternateTag(string $path)
    {
        $items = [];
        $locales = array_keys(config('noah-cms.locale', [
            'zh_TW' => '中文（台灣）',
            'en' => 'English',
        ]));

        foreach ($locales as $locale) {
            $items[] = new AlternateTag(
                hreflang: $locale,
                href: LaravelLocalization::getLocalizedURL($locale, $path),
            );
        }

        return $items;
    }

    public function getSortColumn(): array
    {
        return $this->sort ?? [];
    }

    public function scopeSort($query): Builder
    {
        foreach ($this->sort ?? [] as $column => $direction) {
            $query->orderBy($column, $direction);
        }

        return $query;
    }
}

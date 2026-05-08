<?php

if (!function_exists('noah_setting')) {
    function noah_setting(string $key): mixed
    {
        $setting = setting($key);
        $locale = app()->getLocale();

        if (is_array($setting)) {
            if (isset($setting[$locale])) {
                return $setting[$locale];
            }
            return $setting;
        }

        return setting($key);
    }
}

if (!function_exists('media_url')) {
    function media_url($ids): mixed
    {
        return \Sharenjoy\NoahDomain\Utils\Media::imgUrl($ids);
    }
}

if (!function_exists('category_tree')) {
    function category_tree($ids): mixed
    {
        $categories = \Sharenjoy\NoahDomain\Models\Cms\Category::query()
            ->where('is_active', true)
            ->select('id', 'title', 'slug', 'parent_id')
            ->orderBy('order')
            ->get();

        $grouped = $categories->groupBy('parent_id');

        $buildTree = function ($parentId) use (&$buildTree, $grouped) {
            return $grouped->get($parentId, collect())
                ->map(fn ($category) => [
                    'id' => $category->id,
                    'title' => $category->title,
                    'slug' => $category->slug,
                    'children' => $buildTree($category->id),
                ])
                ->values();
        };

        return $buildTree(-1);
    }
}

if (!function_exists('menu_tree')) {
    function menu_tree($ids): mixed
    {
        $menus = \Sharenjoy\NoahDomain\Models\Cms\Menu::query()
            ->where('is_active', true)
            ->select('id', 'title', 'slug', 'parent_id')
            ->orderBy('order')
            ->get();

        $grouped = $menus->groupBy('parent_id');

        $buildTree = function ($parentId) use (&$buildTree, $grouped) {
            return $grouped->get($parentId, collect())
                ->map(fn ($menu) => [
                    'id' => $menu->id,
                    'title' => $menu->title,
                    'slug' => $menu->slug,
                    'children' => $buildTree($menu->id),
                ])
                ->values();
        };

        return $buildTree(-1);
    }
}

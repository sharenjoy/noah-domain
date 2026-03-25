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

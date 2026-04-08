<?php

namespace Sharenjoy\NoahDomain\Enums\Traits;

trait BaseEnum
{
    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($case) => [$case->value => $case->getLabel()])
            ->toArray();
    }

    public static function getLabelFromOption($value): string|null
    {
        $labels = self::options();

        return $labels[$value] ?? null;
    }

    public static function visibleCases(): array
    {
        $hidden = config('noah-cms.hidden.' . class_basename(self::class), []);

        return array_filter(self::cases(), fn($case) => !in_array($case->value, $hidden));
    }

    public static function visibleOptions(): array
    {
        return collect(self::visibleCases())
            ->mapWithKeys(fn($case) => [$case->value => $case->getLabel()])
            ->toArray();
    }
}

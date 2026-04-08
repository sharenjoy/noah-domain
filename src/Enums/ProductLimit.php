<?php

namespace Sharenjoy\NoahDomain\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Sharenjoy\NoahDomain\Enums\Traits\BaseEnum;

enum ProductLimit: string implements HasLabel, HasColor
{
    use BaseEnum;

    case International = 'international';
    case Point = 'point';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::International => __('noah.no_international'),
            self::Point => __('noah.no_point'),
        };
    }

    public function getColor(): array|string|null
    {
        return match ($this) {
            self::International => Color::Amber,
            self::Point => Color::Amber,
        };
    }
}

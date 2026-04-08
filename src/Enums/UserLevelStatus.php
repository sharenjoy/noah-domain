<?php

namespace Sharenjoy\NoahDomain\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasLabel;
use Sharenjoy\NoahDomain\Enums\Traits\BaseEnum;

enum UserLevelStatus: string implements HasLabel, HasDescription, HasColor
{
    use BaseEnum;

    case On = 'on';
    case Off = 'off';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::On => __('noah.shop.status.title.user_level_status.on'),
            self::Off => __('noah.shop.status.title.user_level_status.off'),
        };
    }

    public function getDescription(): ?string
    {
        return match ($this) {
            self::On => __('noah.shop.status.description.user_level_status.on'),
            self::Off => __('noah.shop.status.description.user_level_status.off'),
        };
    }

    public function getColor(): array|string|null
    {
        return match ($this) {
            self::On => Color::Green,
            self::Off => Color::Red,
        };
    }
}

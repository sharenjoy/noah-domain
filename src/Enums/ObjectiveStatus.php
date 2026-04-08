<?php

namespace Sharenjoy\NoahDomain\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Sharenjoy\NoahDomain\Enums\Traits\BaseEnum;

enum ObjectiveStatus: string implements HasLabel, HasDescription, HasColor
{
    use BaseEnum;

    case New = 'new';
    case Processing = 'processing';
    case Finished = 'finished';
    case Failed = 'failed';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::New => __('noah-shop::noah-shop.shop.status.title.objective.new'),
            self::Processing => __('noah-shop::noah-shop.shop.status.title.objective.processing'),
            self::Finished => __('noah-shop::noah-shop.shop.status.title.objective.finished'),
            self::Failed => __('noah-shop::noah-shop.shop.status.title.objective.failed'),
        };
    }

    public function getDescription(): ?string
    {
        return match ($this) {
            self::New => __('noah-shop::noah-shop.shop.status.description.objective.new'),
            self::Processing => __('noah-shop::noah-shop.shop.status.description.objective.processing'),
            self::Finished => __('noah-shop::noah-shop.shop.status.description.objective.finished'),
            self::Failed => __('noah-shop::noah-shop.shop.status.description.objective.failed'),
        };
    }

    public function getColor(): array|string|null
    {
        return match ($this) {
            self::New => Color::Blue,
            self::Processing => Color::Orange,
            self::Finished => Color::Green,
            self::Failed => Color::Red,
        };
    }
}

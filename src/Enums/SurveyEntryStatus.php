<?php

namespace Sharenjoy\NoahDomain\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasLabel;
use Sharenjoy\NoahDomain\Enums\Traits\BaseEnum;

enum SurveyEntryStatus: string implements HasLabel, HasDescription, HasColor
{
    use BaseEnum;

    case Established = 'established';
    case Completed = 'completed';
    case Cancelled = 'cancelled';
    case Rejected = 'rejected';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Established => __('noah-shop::noah-shop.survey.status.title.entry.established'),
            self::Completed => __('noah-shop::noah-shop.survey.status.title.entry.completed'),
            self::Cancelled => __('noah-shop::noah-shop.survey.status.title.entry.cancelled'),
            self::Rejected => __('noah-shop::noah-shop.survey.status.title.entry.rejected'),
        };
    }

    public function getDescription(): ?string
    {
        return match ($this) {
            self::Established => __('noah-shop::noah-shop.survey.status.description.entry.established'),
            self::Completed => __('noah-shop::noah-shop.survey.status.description.entry.completed'),
            self::Cancelled => __('noah-shop::noah-shop.survey.status.description.entry.cancelled'),
            self::Rejected => __('noah-shop::noah-shop.survey.status.description.entry.rejected'),
        };
    }

    public function getColor(): array|string|null
    {
        return match ($this) {
            self::Established => Color::Blue,
            self::Completed => Color::Orange,
            self::Cancelled => Color::Green,
            self::Rejected => Color::Red,
        };
    }
}

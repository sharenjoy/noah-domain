<?php

namespace Sharenjoy\NoahDomain\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Sharenjoy\NoahDomain\Enums\Traits\BaseEnum;

enum PromoDiscountType: string implements HasLabel, HasDescription, HasIcon, HasColor
{
    use BaseEnum;

    case Amount = 'amount';
    case Percent = 'percent';
    case Gift = 'gift';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Amount => __('noah.shop.type.title.promo_discount.amount'),
            self::Percent => __('noah.shop.type.title.promo_discount.percent'),
            self::Gift => __('noah.shop.type.title.promo_discount.gift'),
        };
    }

    public function getDescription(): ?string
    {
        return match ($this) {
            self::Amount => __('noah.shop.type.description.promo_discount.amount'),
            self::Percent => __('noah.shop.type.description.promo_discount.percent'),
            self::Gift => __('noah.shop.type.description.promo_discount.gift'),
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Amount => 'heroicon-o-currency-dollar',
            self::Percent => 'heroicon-o-percent-badge',
            self::Gift => 'heroicon-o-gift-top',
        };
    }

    public function getColor(): array|string|null
    {
        return match ($this) {
            self::Amount => Color::Blue,
            self::Percent => Color::Amber,
            self::Gift => Color::Amber,
        };
    }
}

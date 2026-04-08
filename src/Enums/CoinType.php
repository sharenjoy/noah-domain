<?php

namespace Sharenjoy\NoahDomain\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasLabel;
use Sharenjoy\NoahDomain\Enums\Traits\BaseEnum;

enum CoinType: string implements HasLabel, HasDescription, HasColor
{
    use BaseEnum;

    case Point = 'point';
    case ShoppingMoney = 'shoppingmoney';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Point => __('noah.shop.type.title.coin.point'),
            self::ShoppingMoney => __('noah.shop.type.title.coin.shoppingmoney'),
        };
    }

    public function getDescription(): ?string
    {
        return match ($this) {
            self::Point => __('noah.shop.type.description.coin.point'),
            self::ShoppingMoney => __('noah.shop.type.description.coin.shoppingmoney'),
        };
    }

    public function getColor(): array|string|null
    {
        return match ($this) {
            self::Point => Color::Blue,
            self::ShoppingMoney => Color::Amber,
        };
    }
}

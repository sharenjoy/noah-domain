<?php

namespace Sharenjoy\NoahDomain\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Sharenjoy\NoahCms\Enums\Traits\BaseEnum;

enum OrderItemType: string implements HasLabel, HasDescription, HasColor
{
    use BaseEnum;

    case Product = 'product';
    case Group = 'group';
    case GiftProduct = 'giftproduct';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Product => __('noah-shop::noah-shop.shop.type.title.order_item.product'),
            self::Group => __('noah-shop::noah-shop.shop.type.title.order_item.group'),
            self::GiftProduct => __('noah-shop::noah-shop.shop.type.title.order_item.giftproduct'),
        };
    }

    public function getDescription(): ?string
    {
        return match ($this) {
            self::Product => __('noah-shop::noah-shop.shop.type.description.order_item.product'),
            self::Group => __('noah-shop::noah-shop.shop.type.description.order_item.group'),
            self::GiftProduct => __('noah-shop::noah-shop.shop.type.description.order_item.giftproduct'),
        };
    }

    public function getColor(): array|string|null
    {
        return match ($this) {
            self::Product => Color::Blue,
            self::Group => Color::Amber,
            self::GiftProduct => Color::Orange,
        };
    }
}

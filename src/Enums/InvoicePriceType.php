<?php

namespace Sharenjoy\NoahDomain\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Sharenjoy\NoahDomain\Enums\Traits\BaseEnum;

enum InvoicePriceType: string implements HasLabel, HasDescription, HasColor
{
    use BaseEnum;

    case Product = 'product';
    case ProductDiscount = 'product_discount';
    case Delivery = 'delivery';
    case Shoppingmoney = 'shoppingmoney';
    case Point = 'point';
    case Promo = 'promo';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Product => __('noah-shop::noah-shop.shop.type.title.invoice_price.product'),
            self::ProductDiscount => __('noah-shop::noah-shop.shop.type.title.invoice_price.product_discount'),
            self::Delivery => __('noah-shop::noah-shop.shop.type.title.invoice_price.delivery'),
            self::Shoppingmoney => __('noah-shop::noah-shop.shop.type.title.invoice_price.shoppingmoney'),
            self::Point => __('noah-shop::noah-shop.shop.type.title.invoice_price.point'),
            self::Promo => __('noah-shop::noah-shop.shop.type.title.invoice_price.promo'),
        };
    }

    public function getDescription(): ?string
    {
        return match ($this) {
            self::Product => '描述.',
            self::ProductDiscount => '描述.',
            self::Delivery => '描述.',
            self::Shoppingmoney => '描述.',
            self::Point => '描述.',
            self::Promo => '描述.',
        };
    }

    public function getColor(): array|string|null
    {
        return match ($this) {
            self::Product => Color::Violet,
            self::ProductDiscount => Color::Orange,
            self::Delivery => Color::Violet,
            self::Shoppingmoney => Color::Orange,
            self::Point => Color::Orange,
            self::Promo => Color::Orange,
        };
    }
}

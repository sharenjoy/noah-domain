<?php

namespace Sharenjoy\NoahDomain\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Sharenjoy\NoahCms\Enums\Traits\BaseEnum;

enum PromoType: string implements HasLabel, HasDescription, HasIcon, HasColor
{
    use BaseEnum;

    case Coupon = 'coupon';
    case MinQuantity = 'minquantity';
    case MinSpend = 'minspend';
    case DeliveryFree = 'deliveryfree';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Coupon => __('noah-shop::noah-shop.shop.type.title.promo.coupon'),
            self::MinQuantity => __('noah-shop::noah-shop.shop.type.title.promo.minquantity'),
            self::MinSpend => __('noah-shop::noah-shop.shop.type.title.promo.minspend'),
            self::DeliveryFree => __('noah-shop::noah-shop.shop.type.title.promo.deliveryfree'),
        };
    }

    public function getDescription(): ?string
    {
        return match ($this) {
            self::Coupon => __('noah-shop::noah-shop.shop.type.description.promo.coupon'),
            self::MinQuantity => __('noah-shop::noah-shop.shop.type.description.promo.minquantity'),
            self::MinSpend => __('noah-shop::noah-shop.shop.type.description.promo.minspend'),
            self::DeliveryFree => __('noah-shop::noah-shop.shop.type.description.promo.deliveryfree'),
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Coupon => 'heroicon-o-newspaper',
            self::MinQuantity => 'heroicon-c-trophy',
            self::MinSpend => 'heroicon-c-trophy',
            self::DeliveryFree => 'heroicon-c-trophy',
        };
    }

    public function getColor(): array|string|null
    {
        return match ($this) {
            self::Coupon => Color::Blue,
            self::MinQuantity => Color::Amber,
            self::MinSpend => Color::Amber,
            self::DeliveryFree => Color::Amber,
        };
    }
}

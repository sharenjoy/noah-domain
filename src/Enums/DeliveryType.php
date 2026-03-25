<?php

namespace Sharenjoy\NoahDomain\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasLabel;
use Sharenjoy\NoahCms\Enums\Traits\BaseEnum;

enum DeliveryType: string implements HasLabel, HasDescription, HasColor
{
    use BaseEnum;

    case Address = 'address';
    case Pickinstore = 'pickinstore';
    case Pickinretail = 'pickinretail';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Address => __('noah-shop::noah-shop.shop.type.title.delivery.address'),
            self::Pickinstore => __('noah-shop::noah-shop.shop.type.title.delivery.pickinstore'),
            self::Pickinretail => __('noah-shop::noah-shop.shop.type.title.delivery.pickinretail'),
        };
    }

    public function getDescription(): ?string
    {
        return match ($this) {
            self::Address => __('noah-shop::noah-shop.shop.type.description.delivery.address'),
            self::Pickinstore => __('noah-shop::noah-shop.shop.type.description.delivery.pickinstore'),
            self::Pickinretail => __('noah-shop::noah-shop.shop.type.description.delivery.pickinretail'),
        };
    }

    public function getColor(): array|string|null
    {
        return match ($this) {
            self::Address => Color::Blue,
            self::Pickinstore => Color::Blue,
            self::Pickinretail => Color::Blue,
        };
    }
}

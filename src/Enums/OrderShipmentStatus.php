<?php

namespace Sharenjoy\NoahDomain\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasLabel;
use Sharenjoy\NoahDomain\Enums\Traits\BaseEnum;

enum OrderShipmentStatus: string implements HasLabel, HasDescription, HasColor
{
    use BaseEnum;

    case New = 'new';
    case Shipped = 'shipped';
    case Delivered = 'delivered';
    case Returning = 'returning';
    case Returned = 'returned';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::New => __('noah-shop::noah-shop.shop.status.title.shipment.new'),
            self::Shipped => __('noah-shop::noah-shop.shop.status.title.shipment.shipped'),
            self::Delivered => __('noah-shop::noah-shop.shop.status.title.shipment.delivered'),
            self::Returning => __('noah-shop::noah-shop.shop.status.title.shipment.returning'),
            self::Returned => __('noah-shop::noah-shop.shop.status.title.shipment.returned'),
        };
    }

    public function getDescription(): ?string
    {
        return match ($this) {
            self::New => '描述.',
            self::Shipped => '描述.',
            self::Delivered => '描述.',
            self::Returning => '描述.',
            self::Returned => '描述.',
        };
    }

    public function getColor(): array|string|null
    {
        return match ($this) {
            self::New => Color::Amber,
            self::Shipped => Color::Amber,
            self::Delivered => Color::Amber,
            self::Returning => Color::Amber,
            self::Returned => Color::Amber,
        };
    }
}

<?php

namespace Sharenjoy\NoahDomain\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasLabel;
use Sharenjoy\NoahDomain\Enums\Traits\BaseEnum;

enum StockMethod: string implements HasLabel, HasDescription, HasColor
{
    use BaseEnum;

    case Notification = 'notification';
    case Preorderable = 'preorderable';
    case OffLine = 'offline';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Notification => __('noah-shop::noah-shop.shop.method.title.stock.email_notification'),
            self::Preorderable => __('noah-shop::noah-shop.shop.method.title.stock.preorderable'),
            self::OffLine => __('noah-shop::noah-shop.shop.method.title.stock.offline'),
        };
    }

    public function getDescription(): ?string
    {
        return match ($this) {
            self::Notification => __('noah-shop::noah-shop.shop.method.description.stock.email_notification'),
            self::Preorderable => __('noah-shop::noah-shop.shop.method.description.stock.preorderable'),
            self::OffLine => __('noah-shop::noah-shop.shop.method.description.stock.offline'),
        };
    }

    public function getColor(): array|string|null
    {
        return match ($this) {
            self::Notification => Color::Blue,
            self::Preorderable => Color::Amber,
            self::OffLine => Color::Amber,
        };
    }
}

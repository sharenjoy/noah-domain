<?php

namespace Sharenjoy\NoahDomain\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Sharenjoy\NoahDomain\Enums\Traits\BaseEnum;

enum TransactionStatus: string implements HasLabel, HasDescription, HasColor
{
    use BaseEnum;

    case New = 'new';
    case Pending = 'pending';
    case Expired = 'expired';
    case Paid = 'paid';
    case Refunding = 'refunding';
    case Refunded = 'refunded';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::New => __('noah.shop.status.title.transaction.new'),
            self::Pending => __('noah.shop.status.title.transaction.pending'),
            self::Expired => __('noah.shop.status.title.transaction.expired'),
            self::Paid => __('noah.shop.status.title.transaction.paid'),
            self::Refunding => __('noah.shop.status.title.transaction.refunding'),
            self::Refunded => __('noah.shop.status.title.transaction.refunded'),
        };
    }

    public function getDescription(): ?string
    {
        return match ($this) {
            self::New => __('noah.shop.status.description.transaction.new'),
            self::Pending => __('noah.shop.status.description.transaction.pending'),
            self::Expired => __('noah.shop.status.description.transaction.expired'),
            self::Paid => __('noah.shop.status.description.transaction.paid'),
            self::Refunding => __('noah.shop.status.description.transaction.refunding'),
            self::Refunded => __('noah.shop.status.description.transaction.refunded'),
        };
    }

    public function getColor(): array|string|null
    {
        return match ($this) {
            self::New => Color::Blue,
            self::Pending => Color::Blue,
            self::Expired => Color::Blue,
            self::Paid => Color::Blue,
            self::Refunding => Color::Blue,
            self::Refunded => Color::Blue,
        };
    }
}

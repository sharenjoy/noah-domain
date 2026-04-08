<?php

namespace Sharenjoy\NoahDomain\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Sharenjoy\NoahDomain\Enums\Traits\BaseEnum;

enum InvoiceType: string implements HasLabel, HasDescription, HasIcon, HasColor
{
    use BaseEnum;

    case Persion = 'persion';
    case Donate = 'donate';
    case Holder = 'holder';
    case Company = 'company';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Persion => __('noah.shop.type.title.invoice.persion'),
            self::Donate => __('noah.shop.type.title.invoice.donate'),
            self::Holder => __('noah.shop.type.title.invoice.holder'),
            self::Company => __('noah.shop.type.title.invoice.company'),
        };
    }

    public function getDescription(): ?string
    {
        return match ($this) {
            self::Persion => __('noah.shop.type.description.invoice.persion'),
            self::Donate => __('noah.shop.type.description.invoice.donate'),
            self::Holder => __('noah.shop.type.description.invoice.holder'),
            self::Company => __('noah.shop.type.description.invoice.company'),
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Persion => 'heroicon-o-newspaper',
            self::Donate => 'heroicon-c-trophy',
            self::Holder => 'heroicon-c-trophy',
            self::Company => 'heroicon-c-trophy',
        };
    }

    public function getColor(): array|string|null
    {
        return match ($this) {
            self::Persion => Color::Blue,
            self::Donate => Color::Amber,
            self::Holder => Color::Amber,
            self::Company => Color::Amber,
        };
    }
}

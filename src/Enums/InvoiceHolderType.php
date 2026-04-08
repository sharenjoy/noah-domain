<?php

namespace Sharenjoy\NoahDomain\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Sharenjoy\NoahDomain\Enums\Traits\BaseEnum;

enum InvoiceHolderType: string implements HasLabel, HasDescription, HasIcon, HasColor
{
    use BaseEnum;

    case Mobile = 'mobile';
    case Certificate = 'certificate';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Mobile => __('noah.shop.type.title.invoice_holder.mobile'),
            self::Certificate => __('noah.shop.type.title.invoice_holder.certificate'),
        };
    }

    public function getDescription(): ?string
    {
        return match ($this) {
            self::Mobile => __('noah.shop.type.description.invoice_holder.mobile'),
            self::Certificate => __('noah.shop.type.description.invoice_holder.certificate'),
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Mobile => 'heroicon-o-newspaper',
            self::Certificate => 'heroicon-c-trophy',
        };
    }

    public function getColor(): array|string|null
    {
        return match ($this) {
            self::Mobile => Color::Blue,
            self::Certificate => Color::Amber,
        };
    }
}

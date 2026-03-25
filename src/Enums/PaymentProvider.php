<?php

namespace Sharenjoy\NoahDomain\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasLabel;
use Sharenjoy\NoahCms\Enums\Traits\BaseEnum;

enum PaymentProvider: string implements HasLabel, HasDescription, HasColor
{
    use BaseEnum;

    case TapPay = 'tappay';
    case LINEPay = 'linepay';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::TapPay => __('noah-shop::noah-shop.shop.provider.title.payment.tappay'),
            self::LINEPay => __('noah-shop::noah-shop.shop.provider.title.payment.linepay'),
        };
    }

    public function getDescription(): ?string
    {
        return match ($this) {
            self::TapPay => __('noah-shop::noah-shop.shop.provider.description.payment.tappay'),
            self::LINEPay => __('noah-shop::noah-shop.shop.provider.description.payment.linepay'),
        };
    }

    public function getColor(): array|string|null
    {
        return match ($this) {
            self::TapPay => Color::Blue,
            self::LINEPay => Color::Blue,
        };
    }
}

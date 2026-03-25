<?php

namespace Sharenjoy\NoahDomain\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasLabel;
use Sharenjoy\NoahCms\Enums\Traits\BaseEnum;

enum PromoAutoGenerateType: string implements HasLabel, HasDescription, HasColor
{
    use BaseEnum;

    case Never = 'never';
    case Yearly = 'yearly';
    case Monthly = 'monthly';
    case Everyday = 'everyday';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Never => __('noah-shop::noah-shop.shop.type.title.promo_auto_generate.never'),
            self::Yearly => __('noah-shop::noah-shop.shop.type.title.promo_auto_generate.yearly'),
            self::Monthly => __('noah-shop::noah-shop.shop.type.title.promo_auto_generate.monthly'),
            self::Everyday => __('noah-shop::noah-shop.shop.type.title.promo_auto_generate.everyday'),
        };
    }

    public function getDescription(): ?string
    {
        return match ($this) {
            self::Never => __('noah-shop::noah-shop.shop.type.description.promo_auto_generate.never'),
            self::Yearly => __('noah-shop::noah-shop.shop.type.description.promo_auto_generate.yearly'),
            self::Monthly => __('noah-shop::noah-shop.shop.type.description.promo_auto_generate.monthly'),
            self::Everyday => __('noah-shop::noah-shop.shop.type.description.promo_auto_generate.everyday'),
        };
    }

    public function getColor(): array|string|null
    {
        return match ($this) {
            self::Never => Color::Blue,
            self::Yearly => Color::Blue,
            self::Monthly => Color::Blue,
            self::Everyday => Color::Blue,
        };
    }
}

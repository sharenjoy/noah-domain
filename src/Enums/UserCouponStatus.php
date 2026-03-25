<?php

namespace Sharenjoy\NoahDomain\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasLabel;
use Sharenjoy\NoahCms\Enums\Traits\BaseEnum;

enum UserCouponStatus: string implements HasLabel, HasDescription, HasColor
{
    use BaseEnum;

    case Assigned = 'assigned';
    case Saved = 'saved';
    case Useing = 'useing';
    case Used = 'used';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Assigned => __('noah-shop::noah-shop.shop.status.title.user_coupon.assigned'),
            self::Saved => __('noah-shop::noah-shop.shop.status.title.user_coupon.saved'),
            self::Useing => __('noah-shop::noah-shop.shop.status.title.user_coupon.useing'),
            self::Used => __('noah-shop::noah-shop.shop.status.title.user_coupon.used'),
        };
    }

    public function getDescription(): ?string
    {
        return match ($this) {
            self::Assigned => __('noah-shop::noah-shop.shop.status.description.user_coupon.assigned'),
            self::Saved => __('noah-shop::noah-shop.shop.status.description.user_coupon.saved'),
            self::Useing => __('noah-shop::noah-shop.shop.status.description.user_coupon.useing'),
            self::Used => __('noah-shop::noah-shop.shop.status.description.user_coupon.used'),
        };
    }

    public function getColor(): array|string|null
    {
        return match ($this) {
            self::Assigned => Color::Blue,
            self::Saved => Color::Orange,
            self::Useing => Color::Green,
            self::Used => Color::Purple,
        };
    }
}

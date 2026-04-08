<?php

namespace Sharenjoy\NoahDomain\Enums;

use Sharenjoy\NoahDomain\Enums\Traits\BaseEnum;

enum OrderStatus: string
{
    use BaseEnum;

    case Initial = 'initial';
    case New = 'new';
    case Processing = 'processing';
    case Pending = 'pending';
    case Cancelled = 'cancelled';
    case Finished = 'finished';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Initial => __('noah.shop.status.title.order.initial'),
            self::New => __('noah.shop.status.title.order.new'),
            self::Processing => __('noah.shop.status.title.order.processing'),
            self::Pending => __('noah.shop.status.title.order.pending'),
            self::Cancelled => __('noah.shop.status.title.order.cancelled'),
            self::Finished => __('noah.shop.status.title.order.finished'),
        };
    }

    public function getDescription(): ?string
    {
        return match ($this) {
            self::Initial => __('noah.shop.status.description.order.initial'),
            self::New => __('noah.shop.status.description.order.new'),
            self::Processing => __('noah.shop.status.description.order.processing'),
            self::Pending => __('noah.shop.status.description.order.pending'),
            self::Cancelled => __('noah.shop.status.description.order.cancelled'),
            self::Finished => __('noah.shop.status.description.order.finished'),
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Initial => 'heroicon-o-exclamation-triangle',
            self::New => 'heroicon-o-shopping-cart',
            self::Processing => 'heroicon-c-play-circle',
            self::Pending => 'heroicon-c-play-pause',
            self::Cancelled => 'heroicon-c-x-circle',
            self::Finished => 'heroicon-c-trophy',
        };
    }

    public function getColor(): array|string|null
    {
        return match ($this) {
            self::Initial => 'yellow',
            self::New => 'sky',
            self::Processing => 'lime',
            self::Pending => 'zinc',
            self::Cancelled => 'orange',
            self::Finished => 'indigo',
        };
    }
}

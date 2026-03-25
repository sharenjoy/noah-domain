<?php

namespace Sharenjoy\NoahDomain\Exceptions;

use Exception;

class UserHasPromoCouponAlready extends Exception
{
    public function __construct($message = null)
    {
        $message = $message ?? __('noah-shop::noah-shop.shop.promo.title.has_coupon_already');
        parent::__construct($message);
    }

    public function render($request)
    {
        return response()->json([
            'error' => $this->getMessage(),
        ], 403);
    }
}

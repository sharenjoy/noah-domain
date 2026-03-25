<?php

namespace Sharenjoy\NoahDomain\Actions;

use Illuminate\Support\Facades\Redis;
use Lorisleiva\Actions\Concerns\AsAction;

class GenerateUserSeriesNumber
{
    use AsAction;

    public function handle(?string $prefix = null, $strLeng = 4)
    {
        $date = date('Ymd');
        $key = 'user_sn:' . $date;
        $increment = Redis::incr($key);

        if ($increment == 1) {
            Redis::expire($key, 86400); // 設定過期時間為 24 小時
        }

        return strtoupper($prefix) . $date . str_pad($increment, $strLeng, '0', STR_PAD_LEFT);
    }
}

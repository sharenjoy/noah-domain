<?php

namespace Sharenjoy\NoahDomain\Actions;

use Lorisleiva\Actions\Concerns\AsAction;

class FetchAddressRelatedSelectOptions
{
    use AsAction;

    public function handle(string $type, ?string $city = null): array
    {
        $options = [];

        if ($type == 'city') {
            $options = array_combine(config('twaddress.city'), config('twaddress.city'));
        } elseif ($type == 'district') {
            if ($key = array_search($city, config('twaddress.city'))) {
                $options = array_combine(config('twaddress.region.' . $key), config('twaddress.region.' . $key));
            }
        }

        return $options;
    }
}

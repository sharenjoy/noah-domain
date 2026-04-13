<?php

namespace Sharenjoy\NoahDomain\Livewire\Traits;

trait WithBase
{
    public $currency;

    public function bootWithBase()
    {
        $this->getCurrency();
    }

    public function getCurrency()
    {
        $this->currency = config('currency.default', 'TWD');

        $user = auth()->user();
        if ($user && $user->preferences && isset($user->preferences['currency'])) {
            $this->currency = $user->preferences['currency'];
        }

        if (session()->has('currency')) {
            $this->currency = session('currency');
        }
    }
}

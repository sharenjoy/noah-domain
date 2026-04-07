<?php

namespace Sharenjoy\NoahDomain;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class NoahDomainServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('noah-domain')
            ->hasConfigFile([
                'twaddress',
            ])
            ->hasViews()
            ->hasTranslations();
    }

    protected function bootPackageViews(): self
    {
        if (! $this->package->hasViews) {
            return $this;
        }

        $namespace = $this->package->viewNamespace;
        $vendorViews = $this->package->basePath('/../resources/views');
        $appViews = base_path("resources/views");

        $this->loadViewsFrom($vendorViews, $this->package->viewNamespace());

        if ($this->app->runningInConsole()) {
            $this->publishes([$vendorViews => $appViews], "{$this->packageView($namespace)}-views");
        }

        return $this;
    }

    protected function bootPackageTranslations(): self
    {
        if (! $this->package->hasTranslations) {
            return $this;
        }

        $vendorTranslations = $this->package->basePath('/../resources/lang');
        $appTranslations = base_path("/lang");

        $this->loadTranslationsFrom($vendorTranslations, $this->package->shortName());

        if ($this->app->runningInConsole()) {
            $this->publishes(
                [$vendorTranslations => $appTranslations],
                "{$this->package->shortName()}-translations"
            );
        }

        return $this;
    }
}

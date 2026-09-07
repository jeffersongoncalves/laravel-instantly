<?php

namespace JeffersonGoncalves\Instantly;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class InstantlyServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('instantly')
            ->hasConfigFile();
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(Instantly::class, function () {
            return new Instantly(
                (string) config('instantly.api_key'),
                (string) config('instantly.base_url'),
            );
        });
    }
}

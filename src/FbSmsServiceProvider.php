<?php

namespace Mortezamasumi\FbSms;

use Illuminate\Support\Facades\Notification;
use Livewire\Features\SupportTesting\Testable;
use Mortezamasumi\FbSms\Testing\TestsFbSms;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FbSmsServiceProvider extends PackageServiceProvider
{
    public static string $name = 'fb-sms';

    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            ->hasConfigFile();
    }

    public function packageRegistered(): void {}

    public function packageBooted(): void
    {
        Notification::extend('sms', fn () => new FbSms());

        Testable::mixin(new TestsFbSms);
    }
}

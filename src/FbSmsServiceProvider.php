<?php

namespace Mortezamasumi\FbSms;

use Illuminate\Support\Facades\Notification;
use Livewire\Features\SupportTesting\Testable;
use Mortezamasumi\FbSms\Exceptions\InvalidOperatorException;
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
        Notification::extend('sms', fn() => new FbSms());

        $this->registerOperator();

        Testable::mixin(new TestsFbSms);
    }

    protected function registerOperator(): void
    {
        $className = config('fb-sms.operator');

        $parentClass = '\Mortezamasumi\FbSms\Contracts\Operator';

        if (class_exists($className)) {
            if (is_subclass_of($className, $parentClass)) {
                $className::initialize($this);

                app()->singleton('SMSOperator', fn() => new ($className)());
            } else {
                throw new InvalidOperatorException("Class {$className} does not extend from {$parentClass}.");
            }
        } else {
            throw new InvalidOperatorException("Class {$className} does not exist.");
        }
    }
}

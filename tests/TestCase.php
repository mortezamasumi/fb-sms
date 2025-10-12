<?php

namespace Mortezamasumi\FbSms\Tests;

use Filament\Facades\Filament;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Mortezamasumi\FbSms\FbSmsServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    use \Illuminate\Foundation\Testing\RefreshDatabase;

    protected function defineEnvironment($app)
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });

        Filament::registerPanel(
            Panel::make()
                ->id('admin')
                ->path('/')
                ->login()
                ->default()
                ->pages([
                    Dashboard::class,
                ])
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            \Filament\FilamentServiceProvider::class,
            \Livewire\LivewireServiceProvider::class,
            FbSmsServiceProvider::class,
        ];
    }
}

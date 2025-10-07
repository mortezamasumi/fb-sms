<?php

namespace Mortezamasumi\FbSms\Tests\Services;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

#[UseFactory(UserFactory::class)]
class NoVerifyUser extends Authenticatable
{
    use HasFactory;

    protected $table = 'users';
}

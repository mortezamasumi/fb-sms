<?php

namespace Mortezamasumi\FbSms\Tests\Models;

use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Mortezamasumi\FbSms\Tests\database\factories\UserFactory;

#[UseFactory(UserFactory::class)]
class NoVerifyUser extends Authenticatable
{
    use HasFactory;

    protected $table = 'users';
}

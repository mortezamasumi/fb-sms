<?php

namespace Mortezamasumi\FbSms\Tests\Models;

use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Notification;
use Mortezamasumi\FbSms\Tests\database\factories\UserFactory;
use Mortezamasumi\FbSms\Traits\MobileNotifiable;

#[UseFactory(UserFactory::class)]
class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    public function hasVerifiedMobile()
    {
        return $this->hasVerifiedEmail();
    }

    public function markMobileAsVerified()
    {
        return $this->markEmailAsVerified();
    }

    public function getMobileForVerification()
    {
        return $this->mobile;
    }

    public function routeNotificationForSms(Notification $notification)
    {
        return $this->getMobileForVerification();
    }
}

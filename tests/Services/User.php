<?php

namespace Mortezamasumi\FbSms\Tests\Services;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;

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

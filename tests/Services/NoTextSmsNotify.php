<?php

namespace Mortezamasumi\FbSms\Tests\Services;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Cache;
use Exception;

class NoTextSmsNotify extends Notification implements ShouldQueue
{
    use Queueable;

    public function via(object $notifiable): array
    {
        return ['sms'];
    }

    public function failed(Exception $exception): void
    {
        Cache::forever('notification-result', 'failed');
    }
}

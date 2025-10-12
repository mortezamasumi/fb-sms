<?php

namespace Mortezamasumi\FbSms\Tests\Services;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Cache;

class SmsNotify extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public string $text
    ) {}

    public function via(object $notifiable): array
    {
        return ['sms'];
    }

    public function toSms(object $notifiable): string
    {
        return $this->text;
    }

    public function failed(): void
    {
        Cache::forever('notification-result', 'failed');
    }

    public function succeeded(): void
    {
        Cache::forever('notification-result', 'succeeded');
    }
}

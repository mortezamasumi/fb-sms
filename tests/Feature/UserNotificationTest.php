<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;
use Mortezamasumi\FbSms\Tests\Models\NoVerifyUser;
use Mortezamasumi\FbSms\Tests\Models\User;
use Mortezamasumi\FbSms\Tests\Services\SmsNotify;

return;

it('can send sms via user notify', function () {
    $text = fake()->sentence();

    User::factory()->create()->notify(new SmsNotify($text));

    $logFile = storage_path('logs/laravel.log');

    expect(File::exists($logFile))->toBeTrue();

    $logContent = File::get($logFile);

    expect($logContent)->toContain($text);
});

it('can notify user', function () {
    Notification::fake();

    $text = fake()->sentence();

    $user = User::factory()->create();

    $user->notify(new SmsNotify($text));

    Notification::assertSentTo(
        $user,
        SmsNotify::class,
        function ($notification, $channels, $notifiable) use ($text) {
            expect($notification->toSms($notifiable))->toBe($text);

            return in_array('sms', $channels);
        }
    );
});

it('should not notify user without MustVerifyMobile', function () {
    Notification::fake();

    $text = fake()->sentence();

    $user = NoVerifyUser::factory()->create();

    try {
        $user->notify(new SmsNotify($text));
    } catch (Exception $e) {
        expect($e instanceof BadMethodCallException)->toBeTrue();
    }

    Notification::assertNotSentTo(
        $user,
        SmsNotify::class
    );
});

<?php

use Illuminate\Support\Facades\Notification;
use Mortezamasumi\FbSms\Tests\Services\NoVerifyUser;
use Mortezamasumi\FbSms\Tests\Services\SmsNotify;
use Mortezamasumi\FbSms\Tests\Services\User;

it('can send sms via user notify', function () {
    Notification::fake();

    $user = User::factory()->create();

    $text = fake()->sentence();

    $user->notify(new SmsNotify($text));

    Notification::assertSentTo(
        $user,
        SmsNotify::class,
        function (SmsNotify $notification, array $channels, User $notifiable) use ($text) {
            expect($channels)->toContain('sms');
            expect($notification->toSms($notifiable))->toBe($text);

            return true;
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

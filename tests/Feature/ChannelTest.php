<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Notification;
use Mortezamasumi\FbSms\Facades\FbSms;
use Mortezamasumi\FbSms\Tests\Services\FailFake;
use Mortezamasumi\FbSms\Tests\Services\NoTextSmsNotify;
use Mortezamasumi\FbSms\Tests\Services\SmsNotify;

it('can get credit', function () {
    expect(FbSms::credit())->toBe('N/A');
});

it('can send sms by route', function (): void {
    Notification::fake();

    $text = fake()->sentence();
    $smsNumber = '1234567890';

    Notification::routes(['sms' => $smsNumber])->notify(new SmsNotify($text));

    Notification::assertSentOnDemand(
        SmsNotify::class,
        function (SmsNotify $notification, array $channels, object $notifiable) use ($text, $smsNumber) {
            expect($notifiable->routes['sms'])->toBe($smsNumber);
            expect($notification->toSms($notifiable))->toBe($text);

            return true;
        }
    );
});

it('should fail on operator failur', function (): void {
    app()->singleton('SMSOperator', fn () => new FailFake());

    Notification::routes(['sms' => '1234567890'])
        ->notify(new SmsNotify('this is text!'));

    expect(Cache::get('notification-result'))->toBe('failed');
});

it("should fail on not defined 'getText' method", function () {
    Notification::routes(['sms' => '1234567890'])
        ->notify(new NoTextSmsNotify());

    expect(Cache::get('notification-result'))->toBe('failed');
});

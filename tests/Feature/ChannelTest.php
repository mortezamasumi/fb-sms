<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;
use Mortezamasumi\FbSms\Facades\FbSms;
use Mortezamasumi\FbSms\Tests\Services\FailFake;
use Mortezamasumi\FbSms\Tests\Services\NoTextSmsNotify;
use Mortezamasumi\FbSms\Tests\Services\SmsNotify;

return;

it('can get credit', function () {
    expect(FbSms::credit())->toBe('N/A');
});

it('can send sms by route', function (): void {
    $text = fake()->sentence();

    Notification::routes(['sms' => '1234567890'])->notify(new SmsNotify($text));

    $logFile = storage_path('logs/laravel.log');

    expect(File::exists($logFile))->toBeTrue();

    $logContent = File::get($logFile);

    expect($logContent)->toContain($text);
});

it('should fail on operator failur', function (): void {
    app()->singleton('SMSOperator', fn () => new FailFake());

    Notification::routes(['sms' => '1234567890'])->notify(new SmsNotify('this is text!'));

    expect(Cache::get('notification-result'))->toBe('failed');
});

it("should fail on not defined 'getText' method", function () {
    Notification::routes(['sms' => '1234567890'])->notify(new NoTextSmsNotify());

    expect(Cache::get('notification-result'))->toBe('failed');
});

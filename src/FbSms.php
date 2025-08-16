<?php

namespace Mortezamasumi\FbSms;

use Exception;
use Illuminate\Notifications\Notification;
use Mortezamasumi\FbSms\Exceptions\InvalidOperatorException;
use Mortezamasumi\FbSms\Exceptions\UnknowTextMethodException;

class FbSms
{
    public function send(object $notifiable, Notification $notification): void
    {
        try {
            throw_unless(
                method_exists($notification, 'toSms'),
                new UnknowTextMethodException($notification)
            );

            $operator = app('SMSOperator');

            throw_unless($operator, new InvalidOperatorException);

            $operator->setText($notification->toSms($notifiable));

            $operator->setTo($notifiable?->mobile ?? $notifiable?->routes['sms']);

            $operator->beforSend();

            $operator->send();

            $operator->afterSend();

            if (method_exists($notification, 'succeeded')) {
                $notification->succeeded($operator);
            }
        } catch (Exception $exception) {
            if (method_exists($notification, 'failed')) {
                /** @disregard */
                $notification->failed($exception);
            }
        }
    }

    public function credit(): string
    {
        try {
            $operator = app('SMSOperator');

            throw_unless($operator, new InvalidOperatorException);

            return app('SMSOperator')->credit();
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }
}

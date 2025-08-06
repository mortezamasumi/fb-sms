<?php

namespace Mortezamasumi\FbSms\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void send(object $notifiable, Notification $notification)
 * @method static void credit()
 *
 * @see \Mortezamasumi\FbSms\FbSms
 */
class FbSms extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Mortezamasumi\FbSms\FbSms::class;
    }
}

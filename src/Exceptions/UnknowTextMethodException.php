<?php

namespace Mortezamasumi\FbSms\Exceptions;

use Illuminate\Support\Facades\Notification;
use Exception;

class UnknowTextMethodException extends Exception
{
    public function __construct(
        protected Notification $notification
    ) {
        $this->message = 'toSms method not found in Notification class '.get_class($notification);
    }
}

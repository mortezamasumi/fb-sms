<?php

namespace Mortezamasumi\FbSms\Exceptions;

use Exception;

class InvalidOperatorException extends Exception
{
    protected $message = 'Operator not defined!';
}

<?php

namespace Mortezamasumi\FbSms\Tests\Services;

use Mortezamasumi\FbSms\Contracts\Operator;
use Exception;

class FailFake extends Operator
{
    public function send(): void
    {
        throw new Exception('faild on operator send');
    }

    public function credit(): string
    {
        return 'N/A';
    }
}

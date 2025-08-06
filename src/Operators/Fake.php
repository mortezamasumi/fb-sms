<?php

namespace Mortezamasumi\FbSms\Operators;

use Illuminate\Support\Facades\Log;
use Mortezamasumi\FbSms\Contracts\Operator;

class Fake extends Operator
{
    public function send(): void
    {
        Log::info($this->getText());
    }

    public function credit(): string
    {
        return 'N/A';
    }
}

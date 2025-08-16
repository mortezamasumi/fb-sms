<?php

namespace Mortezamasumi\FbSms\Operators;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Number;
use Mortezamasumi\FbSms\Contracts\Operator;

class Sabanovin extends Operator
{
    public function send(): void
    {
        $key = config('fb-sms.api_key');
        $gw = $this->setGateway(config('fb-sms.gateway'));
        $to = config('fb-sms.receiver') ?? $this->getTo();
        $text = config('fb-sms.prepend_text').$this->getText().config('fb-sms.append_text');

        $response = Http::get("https://api.sabanovin.com/v1/$key/sms/send.json?gateway=$gw&to=$to&text=$text");

        $this->setCode(data_get($response->json(), 'status.code'));
        $this->setMessage(data_get($response->json(), 'status.message'));

        if ($this->getCode() !== '200') {
            throw new Exception($this->getMessage(), $this->getCode());
        }
    }

    public function credit(): string
    {
        try {
            $key = config('fb-sms.api_key');

            $response = Http::get("https://api.sabanovin.com/v1/$key/account/balance.json");

            return Number::format(data_get($response->json(), 'entry.balance', 0) * 10);
        } catch (Exception $e) {
            return 'N/A';
        }
    }
}

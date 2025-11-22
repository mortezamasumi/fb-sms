<?php

namespace Mortezamasumi\FbSms\Operators;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Number;
use Ipe\Sdk\Facades\SmsIr as ProviderSmsIr;
use Ipe\Sdk\SmsIrService;
use Mortezamasumi\FbSms\Contracts\Operator;
use Exception;

class Smsir extends Operator
{
    public static function initialize($provider): void
    {
        app()->forgetInstance(SmsIrService::class);

        app()->singleton(SmsIrService::class, function ($app) {
            return new SmsIrService(
                config('fb-sms.api_key'),
                'https://api.sms.ir/v1/'
            );
        });
    }

    public function send(): void
    {
        $result = ProviderSmsIr::bulkSend(
            $this->setGateway(config('fb-sms.gateway')),
            $this->getText(),
            // config('fb-sms.prepend_text') . $this->getText() . config('fb-sms.append_text'),
            explode(',', config('fb-sms.receiver') ?? $this->getTo()),
        );

        // dd($result);

        // $response = Http::get("https://api.sabanovin.com/v1/$key/sms/send.json?gateway=$gw&to=$to&text=$text");

        $this->setCode($result->status);
        $this->setMessage($result->message);

        if ($this->getCode() !== 1) {
            throw new Exception($this->getMessage(), $this->getCode());
        }
    }

    public function credit(): string
    {
        try {
            $result = ProviderSmsIr::getCredit();

            if ($result->status !== 1) {
                throw new Exception('not available');
            }

            return $result->data;
        } catch (Exception $e) {
            return 'N/A';
        }
    }
}

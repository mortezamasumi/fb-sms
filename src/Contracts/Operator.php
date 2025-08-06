<?php

namespace Mortezamasumi\FbSms\Contracts;

use Illuminate\Support\Arr;

abstract class Operator
{
    protected ?string $text;
    protected string|array|null $to;
    protected ?string $gateway;
    protected ?string $code;
    protected ?string $message;

    /**
     * send sms to one or many numbers in $to
     * return bool for success or not
     */
    public abstract function send(): void;

    /**
     * return the credit in formatted number
     */
    public abstract function credit(): string;

    /**
     * called befor send
     */
    public function beforSend(): void
    {
        //
    }

    /**
     * called after send
     */
    public function afterSend(): void
    {
        //
    }

    public function setText(?string $text): void
    {
        $this->text = $text;
    }

    public function getText(): string
    {
        return $this->text ?? '';
    }

    public function setTo(string|array|null $to): void
    {
        $this->to = $to;
    }

    public function getTo(): string
    {
        return implode(',', Arr::wrap($this->to));
    }

    public function setGateway(?string $gateway): string
    {
        return $this->gateway = $gateway;
    }

    public function getGateway(): string
    {
        return $this->gateway ?? '';
    }

    public function setMessage(?string $message): void
    {
        $this->message = $message;
    }

    public function getMessage(): string
    {
        return $this->message ?? '';
    }

    public function setCode(?string $code): string
    {
        return $this->code = $code;
    }

    public function getCode(): string
    {
        return $this->code ?? 0;
    }
}

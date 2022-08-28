<?php

namespace MoeenBasra\SendPk;

use MoeenBasra\SendPk\Exceptions\SendPkException;

class SmsMessage
{
    private SendPk $service;

    private string $to;
    private array $params = [];

    public function __construct()
    {
        $this->service = app('send-pk');
    }

    public function to(string $to): static
    {
        $this->to = $to;

        return $this;
    }

    public function params(string $key, mixed $value): static
    {
        $this->params = array_merge($this->params, [
            $key => $value,
        ]);
        return $this;
    }

    public function send(): Response
    {
        if (!$this->to) {
            throw SendPkException::invalidTo();
        }

        return $this->service->send($this->to, $this->params);
    }
}

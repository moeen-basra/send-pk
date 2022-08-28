<?php

namespace MoeenBasra\SendPk;


use Illuminate\Support\Arr;
use Illuminate\Contracts\Support\Arrayable;

class Response implements Arrayable
{
    public int $code;
    public string $status;
    public ?string $id = null;
    public string $from;
    public string $to;
    public ?int $cost = null;
    public ?int $balance = null;
    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;

        $this->status = Arr::get($data, 'success') === 'true' ? 'Success' : 'Failed';
        $this->code = ($this->status === 'Success') ? 200 : 400;
        $this->from = Arr::get($data, 'from');
        $this->to = Arr::get($data, 'to');

        if ($this->code === 200) {
            $this->id = $this->parseId();
            $this->cost = (int)Arr::get($data, 'totalprice');
            $this->balance = $this->parseBalance();
        }
    }

    public function toArray(): array
    {
        return [
            'code' => $this->code,
            'status' => $this->status,
            'id' => $this->id,
            'from' => $this->from,
            'to' => $this->to,
            'cost' => $this->cost,
            'balance' => $this->balance,
            'data' => $this->data,
        ];
    }

    private function parseId(): ?string
    {
//        return Arr::get($this->data, 'results.0.messageid');
        return Arr::get($this->data, 'id');
    }

    private function parseBalance(): ?int
    {
        return Arr::first(explode(' ', Arr::get($this->data, 'remaincredit')));
    }
}

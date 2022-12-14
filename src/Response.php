<?php

namespace MoeenBasra\SendPk;


use Illuminate\Support\Arr;
use Illuminate\Contracts\Support\Arrayable;

class Response implements Arrayable
{
    public int $code;
    public string $status;
    public string $message;
    public ?string $id = null;
    public string $from;
    public string $to;

    public function __construct(
        private readonly array $data
    ) {
        $this->message = Arr::get($this->data, 'message');
        $this->status = Arr::get($this->data, 'status');
        $this->code = $this->status === 'Success' ? 200 : 400;
        $this->from = Arr::get($this->data, 'from');
        $this->to = Arr::get($this->data, 'to');

        if ($this->code === 200) {
            $this->id = $this->message;
        }
    }

    public function toArray(): array
    {
        return [
            'code' => $this->code,
            'status' => $this->status,
            'message' => $this->message,
            'id' => $this->id,
            'from' => $this->from,
            'to' => $this->to,
            'data' => $this->data,
        ];
    }

    private function parseId(): ?string
    {
        return Arr::get($this->data, 'id');
    }

    private function parseBalance(): ?int
    {
        return Arr::first(explode(' ', Arr::get($this->data, 'remaincredit')));
    }
}

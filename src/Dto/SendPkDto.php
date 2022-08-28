<?php

namespace MoeenBasra\SendPk\Dto;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

class SendPkDto implements Arrayable
{
    private string $mobile;
    private string $template_id;
    private array $message;
    private ?string $type = null;
    private ?string $date = null;
    private ?string $time = null;

    public function toArray(): array
    {
        return [
            'mobile' => $this->mobile,
            'template_id' => $this->template_id,
            'message' => json_encode($this->message),
            'type' => $this->type,
            'date' => $this->date,
            'time' => $this->time
        ];
    }

    public function prepare(array $params): array
    {
        if (Arr::get($params, 'to')) {
            $this->setMobile(Arr::get($params, 'to'));
        }

        if (Arr::get($params, 'format')) {
            $this->setFormat(Arr::get($params, 'format'));
        }

        if (Arr::get($params, 'template_id')) {
            $this->setTemplateId(Arr::get($params, 'template_id'));
        }

        if (Arr::get($params, 'message')) {
            $this->setMessage(Arr::get($params, 'message'));
        }

        if (Arr::get($params, 'locale')) {
            $type = $this->resolveType(Arr::get($params, 'locale'));

            if ($type) {
                $this->setType($type);
            }
        }

        if (Arr::get($params, 'type')) {
            $this->setType(Arr::get($params, 'type'));
        }

        if (Arr::get($params, 'date')) {
            $this->setDate(Arr::get($params, 'date'));
        }

        return array_filter($this->toArray());
    }

    public function resolveType(string $locale):?string
    {
        return $locale !== 'en' ? 'unicode' : null;
    }

    /**
     * @return string
     */
    public function getMobile(): string
    {
        return $this->mobile;
    }

    /**
     * @param string $mobile
     *
     * @return SendPkDto
     */
    public function setMobile(string $mobile): SendPkDto
    {
        $this->mobile = $mobile;
        return $this;
    }

    /**
     * @return string
     */
    public function getFormat(): string
    {
        return $this->format;
    }

    /**
     * @param string $format
     *
     * @return SendPkDto
     */
    public function setFormat(string $format): SendPkDto
    {
        $this->format = $format;
        return $this;
    }

    /**
     * @return string
     */
    public function getTemplateId(): string
    {
        return $this->template_id;
    }

    /**
     * @param string $template_id
     *
     * @return SendPkDto
     */
    public function setTemplateId(string $template_id): SendPkDto
    {
        $this->template_id = $template_id;
        return $this;
    }

    /**
     * @return array
     */
    public function getMessage(): array
    {
        return $this->message;
    }

    /**
     * @param array $message
     *
     * @return SendPkDto
     */
    public function setMessage(array $message): SendPkDto
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param null|string $type
     *
     * @return SendPkDto
     */
    public function setType(?string $type): SendPkDto
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getDate(): ?string
    {
        return $this->date;
    }

    /**
     * @param null|string $date
     *
     * @return SendPkDto
     */
    public function setDate(?string $date): SendPkDto
    {
        $date = Carbon::parse($date);

        $this->date = $date->format('d-m-Y');
        $this->time = $date->format('H-i-s');

        return $this;
    }

    /**
     * @return null|string
     */
    public function getTime(): ?string
    {
        return $this->time;
    }

    /**
     * @param null|string $time
     *
     * @return SendPkDto
     */
    public function setTime(?string $time): SendPkDto
    {
        $this->time = $time;
        return $this;
    }
}

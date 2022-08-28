<?php

namespace MoeenBasra\SendPk\Exceptions;

use Throwable;
use Exception;

class SendPkException extends Exception
{
    public static function invalidTo(): Throwable
    {
        $message = __('send-pk::messages.recipient.invalid');

        return new static($message);
    }

    public static function invalidTemplateId(): Throwable
    {
        $message = __('send-pk::messages.template_id.invalid');

        return new static($message);
    }

    public static function invalidFrom(): Throwable
    {
        $message = __('send-pk::messages.sender.invalid');

        return new static($message);
    }

    public static function invalidBody(): Throwable
    {
        $message = __('send-pk::messages.body.invalid');

        return new static($message);
    }
}

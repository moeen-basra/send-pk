# SendPK

The package for [laravel](https://laravel.com/) to send sms messages using the send pk

[Site Url](https://sendpk.com/)

## Prerequisites
1. php >= 8.1
2. guzzlehttp/guzzle >= 7

## Installation
`composer require moeen-basra/send-pk`


## Publish config
`php artisan vendor:publish --tag send-pk-config`

## Publish lang if you want localization
`php artisan vendor:publish --tag send-pk-lang`

## How to use

Before moving forward make sure you update the `config/send-pk.php` file.

### Using the SmsMessage
```php
<?php

use MoeenBasra\SendPk\SmsMessage

class MyClass {
    public function sendMessage(): void
    {
        $response = (new SmsMessage())
            ->fields('template_id', confg('send-pk.templates.{my_template_id}'))
            ->fields('message', [
                // template parameters
            ]);

        if ($response->code === 200) {
            // handle success
        } else {
            // handle failed
        }
    }
}
```
### Using the container

```php
<?php

class MyClass {
    public function sendMessage(): void
    {
        $response = app('send-pk')
            ->send($phone_number, [
                'template_id' => confg('send-pk.templates.{my_template_id}'),
                'message' => [
                    // template parameters
                ]
            ]);
        if ($response->code === 200) {
            // handle success
        } else {
            // handle failed
        }
    }
}
```

## Contact
Reach me at email [here](mailto:moeen.basra@gmail.com)

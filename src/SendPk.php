<?php

namespace MoeenBasra\SendPk;

use GuzzleHttp\Client;
use Illuminate\Support\Arr;
use MoeenBasra\SendPk\Dto\SendPkDto;
use MoeenBasra\SendPk\Exceptions\SendPkException;
use Throwable;

/**
 * @mixin SendPkDto
 */
class SendPk
{
    private SendPkDto $dto;
    private readonly string $api_key;
    private string $username;
    private string $password;
    private string $sender;

    public function __construct(
        array $config = []
    ) {
        $this->api_key = $config['api_key'];
        $this->username = $config['username'];
        $this->password = $config['password'];
        $this->sender = $config['sender'];
        $this->dto = new SendPkDto();
    }

    public function username(string $username): self
    {
        $this->username = $username;
        return $this;
    }

    public function password(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function sender(string $sender): self
    {
        $this->sender = $sender;
        return $this;
    }

    public function send(string $to, array $options = []): ?Response
    {
        $params = $this->dto->setMobile($to)->prepare($options);
        $params['api_key'] = $this->api_key;
        $params['username'] = Arr::get($options, 'username', $this->username);
        $params['password'] = Arr::get($options, 'password', $this->password);
        $params['sender'] = Arr::get($options, 'sender', $this->sender);

        try {
            $response = $this->getClient()->post('/api/sms.php', [
                'form_params' => $params,
            ]);

            $data = [
                'from' => $this->sender,
                'to' => $to,
                'params' => $params,
            ];

            $content = $response->getBody()->getContents();

            if (str_starts_with($content, 'OK')) {
                $status = 'Success!';
                [, $message] = preg_split('/^OK ID:/', $content);
            } else {
                $status = 'Failed!';
                $message = str_split($content, ':')[0];
            }
            $data['status'] = $status;
            return new Response($data);

        } catch (\Throwable $throwable) {
            throw new SendPkException($throwable->getMessage(), $throwable->getCode(), $throwable);
        }
    }

    protected function getClient(): Client
    {
        return new Client([
            'base_uri' => 'https://sendpk.com',
            'timeout' => 5,
            'connect_timeout' => 5,
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
        ]);
    }
}

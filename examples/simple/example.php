<?php

require_once __DIR__.'/../../vendor/autoload.php';

use Gsdev\Fabric;

class PublicIpAddressResponse implements Fabric\Model\Response\ResponseInterface, Fabric\Model\Response\ResponseResourceInterface
{
    private $ip;

    public function __construct(string $ip)
    {
        $this->ip = $ip;
    }

    public function getIpAddress(): string
    {
        return $this->ip;
    }

    public static function createFromResponseData($data): ?Fabric\Model\Response\ResponseInterface
    {
        if (!isset($data['ip'])) {
            return null;
        }

        return new self($data['ip']);
    }

}

class GetPublicIpAddressRequest implements Fabric\Model\Request\RequestInterface, Fabric\Model\Request\RequestResponseInterface
{
    use Fabric\Component\Request\GetRequestTrait;

    public function getUri(): string
    {
        return 'https://api.ipify.org?format=json';
    }

    public function getResponseResource(): string
    {
        return PublicIpAddressResponse::class;
    }
}

$client = new Fabric\Bridge\Guzzle\GuzzleClient();
/** @var PublicIpAddressResponse $response */
$response = $client->send(new GetPublicIpAddressRequest());

printf('Your IP is %s' . PHP_EOL, $response->getIpAddress());

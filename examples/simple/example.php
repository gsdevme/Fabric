<?php

require_once __DIR__.'/../../vendor/autoload.php';

use Gsdev\Fabric\Model\Response\ResponseInterface;
use Gsdev\Fabric\Model\Response\ResponseResourceInterface;
use Gsdev\Fabric\Component\Request\GetRequestTrait;
use Gsdev\Fabric\Model\Request\RequestInterface;
use Gsdev\Fabric\Model\Request\RequestResponseInterface;
use Gsdev\Fabric\Bridge\Guzzle\GuzzleClient;

class PublicIpAddressResponse implements ResponseInterface, ResponseResourceInterface
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

    public static function createFromResponseData($data): ?ResponseInterface
    {
        if (!isset($data['ip'])) {
            return null;
        }

        return new self($data['ip']);
    }

}

class GetPublicIpAddressRequest implements RequestInterface, RequestResponseInterface
{
    use GetRequestTrait;

    public function getUri(): string
    {
        return 'https://api.ipify.org?format=json';
    }

    public function getResponseResource(): string
    {
        return PublicIpAddressResponse::class;
    }
}

$client = new GuzzleClient();
/** @var PublicIpAddressResponse $response */
$response = $client->send(new GetPublicIpAddressRequest());

printf('Your IP is %s' . PHP_EOL, $response->getIpAddress());

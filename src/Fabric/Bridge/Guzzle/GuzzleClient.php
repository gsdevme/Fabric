<?php declare(strict_types=1);

namespace Gsdev\Fabric\Bridge\Guzzle;

use Gsdev\Fabric\Bridge\Guzzle\Adapter\RequestToPsrAdapter;
use Gsdev\Fabric\Model\ClientInterface;
use Gsdev\Fabric\Model\Exception\ClientException;
use Gsdev\Fabric\Model\Exception\FabricException;
use Gsdev\Fabric\Model\Exception\InvalidResponseDataException;
use Gsdev\Fabric\Model\Exception\UnauthorizedException;
use Gsdev\Fabric\Model\Request\RequestInterface;
use Gsdev\Fabric\Model\Request\RequestOptionsInterface;
use Gsdev\Fabric\Model\Response\ResponseInterface;
use GuzzleHttp\Client;

class GuzzleClient implements ClientInterface
{
    /**
     * @var RequestToPsrAdapter
     */
    private $adapter;

    /**
     * @var Client
     */
    private $guzzle;

    public function __construct()
    {
        $this->adapter = new RequestToPsrAdapter();
        $this->guzzle = new Client();
    }

    public function send(RequestInterface $request): ?ResponseInterface
    {
        $options = [];

        $psrRequest = $this->adapter->adapt($request);

        if ($request instanceof RequestOptionsInterface) {
            $options = $request->getOptions();
        }

        $response = $this->guzzle->send($psrRequest, $options);
    }
}

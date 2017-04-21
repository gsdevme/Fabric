<?php declare(strict_types = 1);

namespace Gsdev\Fabric\Bridge\Guzzle;

use Gsdev\Fabric\Bridge\Guzzle\Adapter\RequestToPsrAdapter;
use Gsdev\Fabric\Model\ClientInterface;
use Gsdev\Fabric\Model\Exception\ClientException;
use Gsdev\Fabric\Model\Exception\UnauthorizedException;
use Gsdev\Fabric\Model\Request\RequestInterface;
use Gsdev\Fabric\Model\Request\RequestOptionsInterface;
use Gsdev\Fabric\Model\Response\ResponseInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ClientException as GuzzleClientException;
use Psr\Http\Message\RequestInterface as PsrRequestInterface;
use Psr\Http\Message\ResponseInterface as PsrResponseInterface;

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

        $response = $this->doRequest($psrRequest, $options);

        throw new \Exception('todo');
    }

    private function doRequest(PsrRequestInterface $request, array $options): PsrResponseInterface
    {
        try {
            return $this->guzzle->send($request, $options);
        } catch (BadResponseException $e) {
            $response = $e->getResponse();
            $reasonPhrase = '';
            $status = 0;

            if ($response instanceof PsrResponseInterface) {
                $status = $response->getStatusCode();
                $reasonPhrase = $response->getReasonPhrase();
            }

            if ($e instanceof GuzzleClientException && $status === 401) {
                throw new UnauthorizedException($reasonPhrase, 401, $e);
            }

            throw new ClientException($e->getMessage(), 0, $e);
        }
    }
}

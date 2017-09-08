<?php declare(strict_types=1);

namespace Gsdev\Fabric\Bridge\Guzzle;

use Gsdev\Fabric\Bridge\Guzzle\Adapter\RequestToPsrAdapter;
use Gsdev\Fabric\Component\Response\Adapter\PsrResponseToDataAdapter;
use Gsdev\Fabric\Component\Response\Adapter\PsrResponseToDataAdapterInterface;
use Gsdev\Fabric\Model\ClientInterface;
use Gsdev\Fabric\Model\Request\RequestInterface;
use Gsdev\Fabric\Model\Request\RequestOptionsInterface;
use Gsdev\Fabric\Model\Request\RequestResponseFactoryInterface;
use Gsdev\Fabric\Model\Request\RequestResponseInterface;
use Gsdev\Fabric\Model\Request\ValidateResponseDataRequestInterface;
use Gsdev\Fabric\Model\Response\ResponseInterface;
use Gsdev\Fabric\Model\Response\ResponseResourceInterface;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\RequestInterface as PsrRequestInterface;
use Psr\Http\Message\ResponseInterface as PsrResponseInterface;

class GuzzleClient implements ClientInterface
{
    use GuzzleExceptionHandlerTrait;

    /**
     * @var RequestToPsrAdapter
     */
    private $requestAdapter;

    /**
     * @var PsrResponseToDataAdapter
     */
    private $responseAdapter;

    /**
     * @var Client
     */
    private $guzzle;

    public function __construct(
        GuzzleClientInterface $client = null,
        ?PsrResponseToDataAdapterInterface $responseAdapter = null
    ) {
        $this->requestAdapter = new RequestToPsrAdapter();
        $this->responseAdapter = $responseAdapter ?: new PsrResponseToDataAdapter();
        $this->guzzle = $client ?: new Client();
    }

    public function send(RequestInterface $request): ?ResponseInterface
    {
        $options = [];
        $psrRequest = $this->requestAdapter->adapt($request);

        if ($request instanceof RequestOptionsInterface) {
            $options = $request->getOptions();
        }

        $psrResponse = $this->doRequest($psrRequest, $options);

        if ($request instanceof ValidateResponseDataRequestInterface) {
            $validator = $request->getValidator();

            if (!$validator->isValidResponseData($request, $psrResponse)) {
                return null;
            }
        }

        $responseData = $this->responseAdapter->adapt($psrResponse);

        return $this->doResponse($request, $responseData);
    }

    private function doRequest(PsrRequestInterface $request, array $options): PsrResponseInterface
    {
        try {
            return $this->guzzle->send($request, $options);
        } catch (GuzzleException $e) {
            $this->handleException($e);
        }
    }

    private function doResponse(RequestInterface $request, array $responseData): ?ResponseInterface
    {
        if ($request instanceof RequestResponseInterface) {
            $responseResource = $request->getResponseResource();

            if ($this->isResponseResource($responseResource)) {
                /** @var ResponseResourceInterface $responseResource */
                return $responseResource::createFromResponseData($responseData);
            }

            return null;
        }

        if ($request instanceof RequestResponseFactoryInterface) {
            return $request->getResponseFactory()->createFromResponseData($responseData);
        }

        throw new \Exception('todo');
    }

    private function isResponseResource(string $responseResource): bool
    {
        return in_array(ResponseResourceInterface::class, class_implements($responseResource));
    }
}

<?php
declare(strict_types=1);

namespace Gsdev\Fabric\Bridge\Guzzle;

use Gsdev\Fabric\Bridge\Guzzle\Adapter\RequestToPsrAdapter;
use Gsdev\Fabric\Component\Response\Adapter\PsrResponseToDataAdapter;
use Gsdev\Fabric\Component\Response\Adapter\PsrResponseToDataAdapterInterface;
use Gsdev\Fabric\Model\ClientInterface;
use Gsdev\Fabric\Model\Exception\UnknownClientException;
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
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class GuzzleClient implements ClientInterface
{
    use GuzzleExceptionHandlerTrait;

    /**
     * @var RequestToPsrAdapter
     */
    private $requestAdapter;

    /**
     * @var PsrResponseToDataAdapterInterface
     */
    private $responseAdapter;

    /**
     * @var GuzzleClientInterface
     */
    private $guzzle;
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        GuzzleClientInterface $client = null,
        ?PsrResponseToDataAdapterInterface $responseAdapter = null,
        LoggerInterface $logger = null
    ) {
        $this->requestAdapter = new RequestToPsrAdapter();
        $this->responseAdapter = $responseAdapter ?: new PsrResponseToDataAdapter();
        $this->guzzle = $client ?: new Client();
        $this->logger = $logger ?: new NullLogger();
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
        } catch (\Throwable $t) {
            $this->logger->error(
                'Exception threw unexpected exception',
                [
                    'message' => $t->getMessage(),
                    'line' => $t->getLine(),
                    'file' => $t->getFile(),
                    'trace' => $t->getTraceAsString(),
                ]
            );

            throw new UnknownClientException($t->getMessage(), $t->getCode(), $t);
        }
    }

    private function doResponse(RequestInterface $request, $responseData): ?ResponseInterface
    {
        if ($request instanceof RequestResponseInterface) {
            $responseResource = $request->getResponseResource();

            if ($this->isResponseResource($responseResource)) {
                /** @var ResponseResourceInterface $responseResourceClass */
                $responseResourceClass = $responseResource;
                $response = $responseResourceClass::createFromResponseData($responseData);

                return $response;
            }

            return null;
        }

        if ($request instanceof RequestResponseFactoryInterface) {
            return $request->getResponseFactory()->createFromResponseData($responseData);
        }

        // @todo error here

        return null;
    }

    private function isResponseResource(string $responseResource): bool
    {
        return in_array(ResponseResourceInterface::class, class_implements($responseResource));
    }
}

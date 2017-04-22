<?php declare(strict_types=1);

namespace Gsdev\Fabric\Bridge\Guzzle;

use Gsdev\Fabric\Model\Exception\ClientException;
use Gsdev\Fabric\Model\Exception\TimeoutException;
use Gsdev\Fabric\Model\Exception\UnauthorizedException;
use GuzzleHttp\Exception\ClientException as GuzzleClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface as PsrResponseInterface;

trait GuzzleExceptionHandlerTrait
{
    public function handleException(GuzzleException $e): void
    {
        $response = null;
        $reasonPhrase = '';
        $status = 0;

        if ($e instanceof RequestException && $e->hasResponse()) {
            $response = $e->getResponse();
        }

        if ($response instanceof PsrResponseInterface) {
            $status = $response->getStatusCode();
            $reasonPhrase = $response->getReasonPhrase();
        }

        if ($e instanceof ConnectException) {
            throw new TimeoutException($e->getHandlerContext()['error'] ?? $e->getMessage(), 0, $e);
        }

        if ($e instanceof GuzzleClientException && $status === 401) {
            throw new UnauthorizedException($reasonPhrase, 401, $e);
        }

        throw new ClientException($e->getMessage(), 0, $e);
    }
}

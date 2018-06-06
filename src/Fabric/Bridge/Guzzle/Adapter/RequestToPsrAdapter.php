<?php
declare(strict_types=1);

namespace Gsdev\Fabric\Bridge\Guzzle\Adapter;

use Gsdev\Fabric\Model\Request\BodyRequestInterface;
use Gsdev\Fabric\Model\Request\HeaderRequestInterface;
use Gsdev\Fabric\Model\Request\QueryStringRequestInterface;
use Gsdev\Fabric\Model\Request\RequestInterface;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface as PsrRequest;

class RequestToPsrAdapter
{
    public function adapt(RequestInterface $request): PsrRequest
    {
        $headers = [];
        $body = null;
        $uri = $request->getUri();

        if ($request instanceof HeaderRequestInterface) {
            $headers = $request->getHeaders();
        }

        if ($request instanceof QueryStringRequestInterface) {
            $uri = sprintf('%s?%s', $uri, http_build_query($request->getQueryString()));
        }

        if ($request instanceof BodyRequestInterface) {
            $body = $request->getBody();
        }

        $psrRequest = new Request($request->getMethod(), $uri, $headers, $body);

        return $psrRequest;
    }
}

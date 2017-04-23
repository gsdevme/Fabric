<?php declare(strict_types = 1);

namespace Gsdev\Fabric\Component\Response\Adapter;

use Gsdev\Fabric\Model\Exception\MissingContentTypeForResponseDataException;
use Psr\Http\Message\ResponseInterface;

class PsrResponseToDataAdapter
{
    public function adapt(ResponseInterface $response): ?array
    {
        if (!$response->hasHeader('Content-Type')) {
            throw new MissingContentTypeForResponseDataException();
        }

        $contentType = $response->getHeader('Content-Type');
        $contentType = array_pop($contentType);

        switch ($contentType) {
            case 'application/json':
                return (new JsonResponseToDataAdapter())->adapt((string)$response->getBody());
            default:
                throw new \RuntimeException('todo');
        }
    }
}

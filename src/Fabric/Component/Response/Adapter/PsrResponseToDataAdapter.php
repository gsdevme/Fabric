<?php
declare(strict_types=1);

namespace Gsdev\Fabric\Component\Response\Adapter;

use Gsdev\Fabric\Component\Response\Dto\Stringer;
use Gsdev\Fabric\Model\Exception\MissingContentTypeForResponseDataException;
use Psr\Http\Message\ResponseInterface;

class PsrResponseToDataAdapter implements PsrResponseToDataAdapterInterface
{
    /**
     * {@inheritdoc}
     */
    public function adapt(ResponseInterface $response)
    {
        if (!$response->hasHeader('Content-Type')) {
            throw new MissingContentTypeForResponseDataException();
        }

        $contentType = $response->getHeader('Content-Type');
        $contentType = array_pop($contentType);

        if (strpos($contentType, ';') !== false) {
            $contentType = strstr($contentType, ';', true);
        }

        $responseAsString = strval($response->getBody());

        switch ($contentType) {
            case 'application/json':
                return (new JsonResponseToDataAdapter())->adapt($responseAsString);
            case 'text/plain':
                return new Stringer($responseAsString);
            default:
                throw new \RuntimeException('Unsupported return type');
        }
    }
}

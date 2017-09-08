<?php declare(strict_types = 1);

namespace Gsdev\Fabric\Component\Response\Adapter;

use Psr\Http\Message\ResponseInterface;

interface PsrResponseToDataAdapterInterface
{
    /**
     * @param ResponseInterface $response
     *
     * @return string|array|null
     */
    public function adapt(ResponseInterface $response);
}

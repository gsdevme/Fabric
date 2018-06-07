<?php
declare(strict_types=1);

namespace Gsdev\Fabric\Component\Response\Adapter;

use Psr\Http\Message\ResponseInterface;

interface PsrResponseToDataAdapterInterface
{
    /**
     * @param ResponseInterface $response
     *
     * @return null|object
     */
    public function adapt(ResponseInterface $response);
}

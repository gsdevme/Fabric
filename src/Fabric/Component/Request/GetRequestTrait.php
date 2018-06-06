<?php
declare(strict_types=1);

namespace Gsdev\Fabric\Component\Request;

use Gsdev\Fabric\Model\Request\RequestInterface;

trait GetRequestTrait
{
    public function getMethod(): string
    {
        return RequestInterface::METHOD_GET;
    }
}

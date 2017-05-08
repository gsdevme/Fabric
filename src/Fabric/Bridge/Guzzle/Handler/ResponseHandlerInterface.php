<?php declare(strict_types=1);

namespace Gsdev\Fabric\Bridge\Guzzle\Handler;

use Gsdev\Fabric\Model\Request\RequestInterface;

interface ResponseHandlerInterface
{
    public function handle($response, RequestInterface $request);
}

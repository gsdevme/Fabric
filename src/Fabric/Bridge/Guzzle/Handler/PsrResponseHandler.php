<?php declare(strict_types=1);

namespace Gsdev\Fabric\Bridge\Guzzle\Handler;

use Gsdev\Fabric\Model\Request\RequestInterface;
use Psr\Http\Message\ResponseInterface as PsrResponseInterface;

class PsrResponseHandler
{
    public function handle(PsrResponseInterface $psrResponse, RequestInterface $request)
    {
    }
}

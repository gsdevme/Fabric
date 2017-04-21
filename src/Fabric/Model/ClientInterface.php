<?php declare(strict_types = 1);

namespace Gsdev\Fabric\Model;

use Gsdev\Fabric\Model\Exception\ClientException;
use Gsdev\Fabric\Model\Exception\FabricException;
use Gsdev\Fabric\Model\Exception\InvalidResponseDataException;
use Gsdev\Fabric\Model\Exception\UnauthorizedException;
use Gsdev\Fabric\Model\Request\RequestInterface;
use Gsdev\Fabric\Model\Response\ResponseInterface;

interface ClientInterface
{
    /**
     * @param RequestInterface $request
     *
     * @return ResponseInterface
     *
     * @throws FabricException
     * @throws ClientException
     * @throws UnauthorizedException
     * @throws InvalidResponseDataException
     */
    public function send(RequestInterface $request): ?ResponseInterface;
}

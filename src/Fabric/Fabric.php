<?php declare(strict_types=1);

namespace Gsdev\Fabric;

use Gsdev\Fabric\Model\ClientInterface;
use Gsdev\Fabric\Model\Request\RequestInterface;
use Gsdev\Fabric\Model\Response\ResponseInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * Class Fabric
 *
 * Simple wrapper for a client to add a tiny bit of logging
 */
class Fabric implements ClientInterface
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(ClientInterface $client, ?LoggerInterface $logger = null)
    {
        $this->client = $client;
        $this->logger = $logger ?: new NullLogger();
    }

    /**
     * {@inheritdoc}
     */
    public function send(RequestInterface $request): ?ResponseInterface
    {
        $this->logger->debug(sprintf('Fabric: %s:%s', $request->getMethod(), $request->getUri()));

        return $this->client->send($request);
    }
}

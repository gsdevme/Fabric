<?php declare(strict_types = 1);

namespace Gsdev\Fabric\Component\Response\Adapter;

use Gsdev\Fabric\Model\Exception\MissingContentTypeForResponseDataException;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Psr\Http\Message\ResponseInterface;
use Mockery;

class PsrResponseToDataAdapterTest extends MockeryTestCase
{
    /**
     * @var PsrResponseToDataAdapter
     */
    private $adapter;

    public function setUp()
    {
        $this->adapter = new PsrResponseToDataAdapter();
    }

    public function testAdaptWithoutContentType()
    {
        $this->expectException(MissingContentTypeForResponseDataException::class);

        /** @var Mockery\MockInterface|ResponseInterface $response */
        $response = Mockery::mock(ResponseInterface::class);
        $response->shouldReceive('hasHeader')->andReturn(false);

        $this->adapter->adapt($response);
    }
}

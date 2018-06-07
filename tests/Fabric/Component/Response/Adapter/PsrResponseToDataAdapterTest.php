<?php declare(strict_types = 1);

namespace Gsdev\Fabric\Component\Response\Adapter;

use Gsdev\Fabric\Component\Response\Adapter\PsrResponseToDataAdapter;
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

    public function testAdaptWithPlainText()
    {
        /** @var Mockery\MockInterface|ResponseInterface $response */
        $response = Mockery::mock(ResponseInterface::class);
        $response->shouldReceive('hasHeader')->andReturn(true);
        $response->shouldReceive('getHeader')->andReturn(['text/plain']);
        $response->shouldReceive('getBody')->andReturn('123');

        $return = $this->adapter->adapt($response);

        $this->assertEquals(123, (string)$return);
    }

    public function testAdaptWithJson()
    {
        /** @var Mockery\MockInterface|ResponseInterface $response */
        $response = Mockery::mock(ResponseInterface::class);
        $response->shouldReceive('hasHeader')->andReturn(true);
        $response->shouldReceive('getHeader')->andReturn(['application/json']);
        $response->shouldReceive('getBody')->andReturn(json_encode(['test' => 1337]));

        $return = $this->adapter->adapt($response);

        $this->assertEquals((object)['test' => 1337], $return);
    }

    public function testAdaptWithJsonEncoding()
    {
        /** @var Mockery\MockInterface|ResponseInterface $response */
        $response = Mockery::mock(ResponseInterface::class);
        $response->shouldReceive('hasHeader')->andReturn(true);
        $response->shouldReceive('getHeader')->andReturn(['application/json; encoding=utf8']);
        $response->shouldReceive('getBody')->andReturn(json_encode(['test' => 1337]));

        $return = $this->adapter->adapt($response);

        $this->assertEquals((object)['test' => 1337], $return);
    }

    public function testAdaptWithUnsupportedType()
    {
        $this->expectException(\RuntimeException::class);

        /** @var Mockery\MockInterface|ResponseInterface $response */
        $response = Mockery::mock(ResponseInterface::class);
        $response->shouldReceive('hasHeader')->andReturn(true);
        $response->shouldReceive('getHeader')->andReturn(['application/xml; encoding=utf8']);
        $response->shouldReceive('getBody')->andReturn('<xml></xml>');

        $this->adapter->adapt($response);
    }
}

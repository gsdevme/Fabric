<?php declare(strict_types = 1);

namespace Gsdev\Fabric\Bridge\Guzzle\Adapter;

use Gsdev\Fabric\Model\Request\HeaderRequestInterface;
use Gsdev\Fabric\Model\Request\QueryStringRequestInterface;
use Gsdev\Fabric\Model\Request\RequestInterface;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Psr\Http\Message\RequestInterface as PsrRequest;
use GuzzleHttp\Psr7\Uri;

class RequestToPsrAdapterTest extends MockeryTestCase
{
    /**
     * @var RequestToPsrAdapter
     */
    private $adapter;

    public function setUp()
    {
        $this->adapter = new RequestToPsrAdapter();
    }

    public function testSimpleUsageOfTheAdapter()
    {
        $url = 'http://abc.com/123';
        $method = 'GET';

        /** @var Mockery\MockInterface|RequestInterface $request */
        $request = Mockery::mock(RequestInterface::class);
        $request->shouldReceive('getUri')->andReturn($url);
        $request->shouldReceive('getMethod')->andReturn($method);

        $psrRequest = $this->adapter->adapt($request);

        $this->assertInstanceOf(PsrRequest::class, $psrRequest);
        $this->assertEquals($url, $psrRequest->getUri());
        $this->assertEquals($method, $psrRequest->getMethod());
    }

    public function testHeaderWithinTheAdapter()
    {
        $url = 'http://abc.com/123';
        $method = 'GET';
        $headers = [
            'user-agent' => 'firefox 1337',
            'x-request' => '/123',
            'x-random-header' => 'wat',
        ];

        /** @var Mockery\MockInterface|RequestInterface $request */
        $request = Mockery::mock(RequestInterface::class, HeaderRequestInterface::class);
        $request->shouldReceive('getUri')->andReturn($url);
        $request->shouldReceive('getMethod')->andReturn($method);
        $request->shouldReceive('getHeaders')->andReturn($headers);

        $psrRequest = $this->adapter->adapt($request);

        $this->assertInstanceOf(PsrRequest::class, $psrRequest);
        $this->assertEquals($url, $psrRequest->getUri());
        $this->assertEquals($method, $psrRequest->getMethod());
        $this->assertArrayHasKey('user-agent', $psrRequest->getHeaders());
        $this->assertArrayHasKey('x-request', $psrRequest->getHeaders());
        $this->assertArrayHasKey('x-random-header', $psrRequest->getHeaders());
    }

    public function testAdapter()
    {
        $url = 'http://abc.com/123';
        $method = 'GET';
        $headers = [
            'x-header' => 'wat',
        ];
        $queryString = [
            'key' => 'value'
        ];

        /** @var Mockery\MockInterface|RequestInterface $request */
        $request = Mockery::mock(
            RequestInterface::class,
            HeaderRequestInterface::class,
            QueryStringRequestInterface::class
        );

        $request->shouldReceive('getUri')->andReturn($url);
        $request->shouldReceive('getMethod')->andReturn($method);
        $request->shouldReceive('getHeaders')->andReturn($headers);
        $request->shouldReceive('getQueryString')->andReturn($queryString);

        $psrRequest = $this->adapter->adapt($request);

        $this->assertInstanceOf(PsrRequest::class, $psrRequest);
        $this->assertEquals($method, $psrRequest->getMethod());
        $this->assertArrayHasKey('x-header', $psrRequest->getHeaders());

        $uri = $psrRequest->getUri();

        $this->assertInstanceOf(Uri::class, $psrRequest->getUri());
        $this->assertEquals('http://abc.com/123?key=value', (string)$uri);
    }
}

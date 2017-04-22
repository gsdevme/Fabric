<?php declare(strict_types = 1);

namespace Gsdev\Fabric\Test\Bridge\Guzzle;

use Gsdev\Fabric\Bridge\Guzzle\GuzzleClient;
use Gsdev\Fabric\Model\Request\RequestInterface;
use Gsdev\Fabric\Model\Request\RequestOptionsInterface;
use Gsdev\Fabric\Model\Request\RequestResponseInterface;
use Gsdev\Fabric\Model\Request\ValidateResponseDataRequestInterface;
use Gsdev\Fabric\Model\Validator\ValidatorInterface;
use Gsdev\Fabric\Test\Bridge\Guzzle\Fixtures\Stub\GetResponseResourceStub;
use GuzzleHttp\ClientInterface;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Psr\Http\Message\ResponseInterface;

class GuzzleClientTest extends MockeryTestCase
{
    /**
     * @var GuzzleClient
     */
    private $guzzle;

    /**
     * @var Mockery\MockInterface|ClientInterface
     */
    private $client;

    public function setUp()
    {
        $this->client = Mockery::mock(ClientInterface::class);
        $this->guzzle = new GuzzleClient($this->client);
    }

    public function testSimpleJsonSend()
    {
        /** @var Mockery\MockInterface|RequestInterface $request */
        $request = Mockery::mock(RequestInterface::class, RequestResponseInterface::class);
        $request->shouldReceive('getUri')->andReturn('https://abc.com/123');
        $request->shouldReceive('getMethod')->andReturn('GET');
        $request->shouldReceive('getResponseResource')->andReturn(GetResponseResourceStub::class);

        $response = Mockery::mock(ResponseInterface::class);
        $response->shouldReceive('hasHeader')->withArgs(['Content-Type'])->andReturn(true);
        $response->shouldReceive('getHeader')->withArgs(['Content-Type'])->andReturn(['application/json']);
        $response->shouldReceive('getBody')->andReturn('{"id": 1}');

        $this->client->shouldReceive('send')->andReturn($response);

        /** @var GetResponseResourceStub $response */
        $response = $this->guzzle->send($request);

        $this->assertSame(['id' => 1], $response->getData());
    }

    public function testSimpleJsonSendWithOptions()
    {
        /** @var Mockery\MockInterface|RequestInterface $request */
        $request = Mockery::mock(RequestInterface::class, RequestResponseInterface::class, RequestOptionsInterface::class);
        $request->shouldReceive('getUri')->andReturn('https://abc.com/123');
        $request->shouldReceive('getMethod')->andReturn('GET');
        $request->shouldReceive('getOptions')->andReturn(['timeout' => 69]);
        $request->shouldReceive('getResponseResource')->andReturn(GetResponseResourceStub::class);

        $response = Mockery::mock(ResponseInterface::class);
        $response->shouldReceive('hasHeader')->withArgs(['Content-Type'])->andReturn(true);
        $response->shouldReceive('getHeader')->withArgs(['Content-Type'])->andReturn(['application/json']);
        $response->shouldReceive('getBody')->andReturn('{"id": 1}');

        $this->client->shouldReceive('send')->withArgs([Mockery::any(), ['timeout' => 69]])->andReturn($response);

        /** @var GetResponseResourceStub $response */
        $response = $this->guzzle->send($request);

        $this->assertSame(['id' => 1], $response->getData());
    }

    public function testSimpleJsonSendWithValidator()
    {
        $validator = Mockery::mock(ValidatorInterface::class);
        $validator->shouldReceive('isValidResponseData')->andReturn(true);

        /** @var Mockery\MockInterface|RequestInterface $request */
        $request = Mockery::mock(RequestInterface::class, RequestResponseInterface::class, ValidateResponseDataRequestInterface::class);
        $request->shouldReceive('getUri')->andReturn('https://abc.com/123');
        $request->shouldReceive('getMethod')->andReturn('GET');
        $request->shouldReceive('getResponseResource')->andReturn(GetResponseResourceStub::class);
        $request->shouldReceive('getValidator')->andReturn($validator);

        $response = Mockery::mock(ResponseInterface::class);
        $response->shouldReceive('hasHeader')->withArgs(['Content-Type'])->andReturn(true);
        $response->shouldReceive('getHeader')->withArgs(['Content-Type'])->andReturn(['application/json']);
        $response->shouldReceive('getBody')->andReturn('{"id": 1}');

        $this->client->shouldReceive('send')->andReturn($response);

        /** @var GetResponseResourceStub $response */
        $response = $this->guzzle->send($request);

        $this->assertSame(['id' => 1], $response->getData());
    }

    public function testSimpleJsonSendWithValidatorWithInvalid()
    {
        $validator = Mockery::mock(ValidatorInterface::class);
        $validator->shouldReceive('isValidResponseData')->andReturn(false);

        /** @var Mockery\MockInterface|RequestInterface $request */
        $request = Mockery::mock(RequestInterface::class, RequestResponseInterface::class, ValidateResponseDataRequestInterface::class);
        $request->shouldReceive('getUri')->andReturn('https://abc.com/123');
        $request->shouldReceive('getMethod')->andReturn('GET');
        $request->shouldReceive('getResponseResource')->andReturn(GetResponseResourceStub::class);
        $request->shouldReceive('getValidator')->andReturn($validator);

        $response = Mockery::mock(ResponseInterface::class);
        $response->shouldReceive('hasHeader')->withArgs(['Content-Type'])->andReturn(true);
        $response->shouldReceive('getHeader')->withArgs(['Content-Type'])->andReturn(['application/json']);
        $response->shouldReceive('getBody')->andReturn('{"id": 1}');

        $this->client->shouldReceive('send')->andReturn($response);

        /** @var GetResponseResourceStub $response */
        $response = $this->guzzle->send($request);

        $this->assertNull($response);
    }
}

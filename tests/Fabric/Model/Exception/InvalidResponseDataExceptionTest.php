<?php declare(strict_types=1);

namespace Gsdev\Fabric\Model\Exception;

use Gsdev\Fabric\Model\Request\RequestInterface;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery;

class InvalidResponseDataExceptionTest extends MockeryTestCase
{
    public function testInvalidResponseDataException()
    {
        /** @var Mockery\MockInterface|RequestInterface $request */
        $request = Mockery::mock(RequestInterface::class);

        $exception = new InvalidResponseDataException($request, []);

        $this->assertSame($request, $exception->getRequest());
        $this->assertSame([], $exception->getResponseData());
    }
}

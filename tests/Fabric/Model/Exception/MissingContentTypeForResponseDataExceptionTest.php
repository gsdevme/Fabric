<?php declare(strict_types=1);

namespace Gsdev\Fabric\Model\Exception;

use PHPUnit\Framework\TestCase;

class MissingContentTypeForResponseDataExceptionTest extends TestCase
{
    public function testException()
    {
        $exception = new MissingContentTypeForResponseDataException();

        $this->assertInstanceOf(FabricExceptionInterface::class, $exception);
    }
}

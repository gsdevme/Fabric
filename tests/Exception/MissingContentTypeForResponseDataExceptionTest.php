<?php declare(strict_types=1);

namespace Gsdev\Fabric\Test\Exception;

use Gsdev\Fabric\Model\Exception\FabricExceptionInterface;
use Gsdev\Fabric\Model\Exception\MissingContentTypeForResponseDataException;
use PHPUnit\Framework\TestCase;

class MissingContentTypeForResponseDataExceptionTest extends TestCase
{
    public function testException()
    {
        $exception = new MissingContentTypeForResponseDataException();

        $this->assertInstanceOf(FabricExceptionInterface::class, $exception);
    }
}

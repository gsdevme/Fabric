<?php declare(strict_types=1);

namespace Gsdev\Fabric\Component\Response\Adapter;

use Mockery\Adapter\Phpunit\MockeryTestCase;

class JsonResponseToDataAdapterTest extends MockeryTestCase
{
    public function testExceptionOnInvalidJson()
    {
        $this->expectException(\InvalidArgumentException::class);
        
        $adapter = new JsonResponseToDataAdapter();
        $adapter->adapt('invalid json');
    }
}

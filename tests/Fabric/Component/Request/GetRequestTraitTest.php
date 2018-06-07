<?php declare(strict_types = 1);

namespace Gsdev\Fabric\Component\Request;

use Gsdev\Fabric\Component\Request\GetRequestTrait;
use PHPUnit\Framework\TestCase;

class GetRequestTraitTest extends TestCase
{
    public function testGetMethod()
    {
        /** @var GetRequestTrait $request */
        $request = new class() {
            use GetRequestTrait;
        };

        $this->assertEquals('GET', $request->getMethod());
    }
}

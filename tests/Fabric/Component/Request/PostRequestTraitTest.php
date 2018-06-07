<?php declare(strict_types = 1);

namespace Gsdev\Fabric\Component\Request;

use Gsdev\Fabric\Component\Request\PostRequestTrait;
use PHPUnit\Framework\TestCase;

class PostRequestTraitTest extends TestCase
{
    public function testGetMethod()
    {
        /** @var PostRequestTrait $request */
        $request = new class() {
            use PostRequestTrait;
        };

        $this->assertEquals('POST', $request->getMethod());
    }
}

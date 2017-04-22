<?php declare(strict_types = 1);

namespace Gsdev\Fabric\Test\Bridge\Guzzle\Fixtures\Stub;

use Gsdev\Fabric\Model\Response\ResponseInterface;

class GetResponseStub implements ResponseInterface
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }
}

<?php declare(strict_types = 1);

namespace Gsdev\Fabric\Bridge\Guzzle\Fixtures\Stub;

use Gsdev\Fabric\Model\Response\ResponseInterface;
use Gsdev\Fabric\Model\Response\ResponseResourceInterface;

class GetResponseResourceStub implements ResponseInterface, ResponseResourceInterface
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

    public static function createFromResponseData($data): ?ResponseInterface
    {
        return new self($data);
    }
}

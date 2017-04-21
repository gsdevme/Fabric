<?php

namespace Gsdev\Fabric\Model\Exception;

use Gsdev\Fabric\Model\Request\RequestInterface;

class InvalidResponseDataException extends FabricException
{
    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var mixed
     */
    private $responseData;

    /**
     * @param RequestInterface $request
     * @param mixed $responseData
     * @param string $message
     * @param \Exception|null $parentException
     */
    public function __construct(
        RequestInterface $request,
        $responseData,
        $message = '',
        \Exception $parentException = null
    ) {
        $this->request = $request;
        $this->responseData = $responseData;

        parent::__construct($message, 0, $parentException);
    }

    /**
     * @return RequestInterface
     */
    public function getRequest(): RequestInterface
    {
        return $this->request;
    }

    /**
     * @return mixed
     */
    public function getResponseData()
    {
        return $this->responseData;
    }
}

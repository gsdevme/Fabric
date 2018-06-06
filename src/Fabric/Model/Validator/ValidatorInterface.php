<?php
declare(strict_types=1);

namespace Gsdev\Fabric\Model\Validator;

use Gsdev\Fabric\Model\Exception\InvalidResponseDataException;
use Gsdev\Fabric\Model\Request\RequestInterface;

interface ValidatorInterface
{
    /**
     * @param RequestInterface $request
     * @param mixed $response
     * @return bool
     *
     * @throws InvalidResponseDataException
     */
    public function isValidResponseData(RequestInterface $request, $response): bool;
}

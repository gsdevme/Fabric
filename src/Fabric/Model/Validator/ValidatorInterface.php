<?php declare(strict_types=1);

namespace Gsdev\Fabric\Model\Validator;

use Gsdev\Fabric\Model\Exception\InvalidResponseDataException;

interface ValidatorInterface
{
    /**
     * @throws InvalidResponseDataException
     */
    public function isValidResponseData(array $data): bool;
}

<?php declare(strict_types=1);

namespace Gsdev\Fabric\Client;

use Gsdev\Fabric\Model\Exception\InvalidResponseDataException;
use Gsdev\Fabric\Model\Request\RequestInterface;
use Gsdev\Fabric\Model\Request\ValidateResponseDataRequestInterface;

trait ClientValidationTrait
{
    /**
     * @param RequestInterface $request
     * @param $responseData
     *
     * @throws InvalidResponseDataException
     */
    public function doValidation(RequestInterface $request, $responseData): void
    {
        if ($request instanceof ValidateResponseDataRequestInterface) {
            $validator = $request->getValidator();

            if (!$validator->isValidResponseData($responseData)) {
                throw new InvalidResponseDataException($request, $responseData);
            };
        }
    }
}

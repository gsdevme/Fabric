<?php declare(strict_types = 1);

namespace Gsdev\Fabric\Model\Exception;

class MissingContentTypeForResponseDataException extends FabricException
{
    const MESSAGE = <<<STRING
The content type for the response could not be determined.

if the API is not returning a content-type header you can implement ExpectedResponseContentTypeInterface to 
mimic the correct type
STRING
    ;

    public function __construct()
    {
        parent::__construct(self::MESSAGE);
    }
}

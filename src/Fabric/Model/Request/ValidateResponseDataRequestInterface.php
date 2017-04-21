<?php declare(strict_types = 1);

namespace Gsdev\Fabric\Model\Request;

use Gsdev\Fabric\Model\Validator\ValidatorInterface;

interface ValidateResponseDataRequestInterface
{
    public function getValidator(): ValidatorInterface;
}

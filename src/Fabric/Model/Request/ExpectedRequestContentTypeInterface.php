<?php
declare(strict_types=1);

namespace Gsdev\Fabric\Model\Request;

interface ExpectedRequestContentTypeInterface
{
    public function getContentType(): string;
}

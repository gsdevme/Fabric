<?php declare(strict_types = 1);

namespace Gsdev\Fabric\Model\Response;

interface ExpectedResponseContentTypeInterface
{
    public function getContentType(): string;
}

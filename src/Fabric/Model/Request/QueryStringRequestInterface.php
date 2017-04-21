<?php declare(strict_types = 1);

namespace Gsdev\Fabric\Model\Request;

interface QueryStringRequestInterface
{
    public function getQueryString(): array;
}

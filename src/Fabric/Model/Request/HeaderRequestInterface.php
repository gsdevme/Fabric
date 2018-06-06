<?php
declare(strict_types=1);

namespace Gsdev\Fabric\Model\Request;

interface HeaderRequestInterface
{
    public function getHeaders(): array;
}

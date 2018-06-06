<?php
declare(strict_types=1);

namespace Gsdev\Fabric\Model\Response;

interface ResponseFactoryInterface
{
    public function createFromResponseData($data): ?ResponseInterface;
}

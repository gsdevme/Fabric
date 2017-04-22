<?php declare(strict_types = 1);

namespace Gsdev\Fabric\Model\Response;

interface ResponseResourceInterface
{
    public static function createFromResponseData($data): ?ResponseInterface;
}

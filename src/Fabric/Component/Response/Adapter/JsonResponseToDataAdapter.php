<?php declare(strict_types=1);

namespace Gsdev\Fabric\Component\Response\Adapter;

class JsonResponseToDataAdapter
{
    public function adapt(string $json): ?array
    {
        $data = json_decode($json, true);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new \InvalidArgumentException('Adapter cannot decode string, invalid json?');
        }

        return $data;
    }
}

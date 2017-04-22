<?php declare(strict_types=1);

namespace Gsdev\Fabric\Component\Response\Adapter;

class JsonResponseToDataAdapter
{
    public function adapt(string $json): ?array
    {
        return @json_decode($json, true);
    }
}

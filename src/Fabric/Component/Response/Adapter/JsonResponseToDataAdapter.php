<?php
declare(strict_types=1);

namespace Gsdev\Fabric\Component\Response\Adapter;

use Webmozart\Json\DecodingFailedException;
use Webmozart\Json\JsonDecoder;

class JsonResponseToDataAdapter
{
    public function adapt(string $json)
    {
        $decoder = new JsonDecoder();

        try {
            $response = $decoder->decode($json);

            if (is_array($response) || is_object($response) || $response === null) {
                return $response;
            }

            throw new \RuntimeException('JsonResponse could not be adapted');
        } catch (DecodingFailedException $e) {
            throw new \InvalidArgumentException('Adapter failed to decode JSON', 0, $e);
        } catch (\Throwable $t) {
            throw new \InvalidArgumentException($t->getMessage(), 0, $t);
        }
    }
}

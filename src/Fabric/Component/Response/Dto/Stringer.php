<?php
declare(strict_types=1);

namespace Gsdev\Fabric\Component\Response\Dto;

/**
 * Similar concept to golangs stringer, its a object that can be cast to a string
 * PHP doesnt natively support this very well just yet
 */
class Stringer
{
    /**
     * @var string
     */
    private $data;

    public function __construct(string $data)
    {
        $this->data = $data;
    }

    public function __toString()
    {
        return $this->data;
    }
}

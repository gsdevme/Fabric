<?php declare(strict_types = 1);

namespace Gsdev\Fabric\Model\Request;

interface RequestResponseInterface
{
    public function getResponseResource(): string;
}

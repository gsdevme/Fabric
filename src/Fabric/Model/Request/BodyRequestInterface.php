<?php declare(strict_types = 1);

namespace Gsdev\Fabric\Model\Request;

interface BodyRequestInterface
{
    /**
     * @return string|null|resource
     */
    public function getBody();
}

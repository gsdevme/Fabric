<?php declare(strict_types = 1);

namespace Gsdev\Fabric\Model\Request;

use Gsdev\Fabric\Model\Response\ResponseFactoryInterface;

interface RequestResponseFactoryInterface
{
    public function getResponseFactory(): ResponseFactoryInterface;
}

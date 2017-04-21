<?php declare(strict_types = 1);

namespace Gsdev\Fabric\Model\Request;

interface RequestInterface
{
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';

    public function getUri(): string;

    public function getMethod(): string;
}

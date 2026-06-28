<?php
namespace Otus\Hw4\Attributes;

#[\Attribute(\Attribute::TARGET_METHOD | \Attribute::TARGET_FUNCTION)]
class HandlesPath
{
    public function __construct(public string $path, public string $method = 'GET')
    {
    }
}

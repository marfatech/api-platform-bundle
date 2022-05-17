<?php

declare(strict_types=1);

namespace MarfaTech\Bundle\ApiPlatformBundle\Dto;

use MarfaTech\Component\DtoResolver\Dto\DtoResolverInterface;
use MarfaTech\Component\DtoResolver\Dto\DtoResolverTrait;

class DummyDto implements DtoResolverInterface
{
    use DtoResolverTrait;

    private string $string;

    public function getString(): string
    {
        return $this->string;
    }
}

<?php

declare(strict_types=1);

namespace MarfaTech\Bundle\ApiPlatformBundle\Factory;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;

interface ResolverFactoryInterface
{
    public function createForRequest(Request $request): OptionsResolver;

    public function createForDefinition(string $definitionName): OptionsResolver;
}

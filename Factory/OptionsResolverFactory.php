<?php

declare(strict_types=1);

namespace MarfaTech\Bundle\ApiPlatformBundle\Factory;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OptionsResolverFactory implements ResolverFactoryInterface
{
    public function createForRequest(Request $request): OptionsResolver
    {
        return new OptionsResolver();
    }

    public function createForDefinition(string $definitionName): OptionsResolver
    {
        return new OptionsResolver();
    }
}

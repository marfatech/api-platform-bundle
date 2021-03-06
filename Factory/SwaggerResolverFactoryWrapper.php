<?php

declare(strict_types=1);

/*
 * This file is part of the ApiPlatformBundle package.
 *
 * (c) MarfaTech <https://marfa-tech.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MarfaTech\Bundle\ApiPlatformBundle\Factory;

use Linkin\Bundle\SwaggerResolverBundle\Factory\SwaggerResolverFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SwaggerResolverFactoryWrapper implements ResolverFactoryInterface
{
    private SwaggerResolverFactory $swaggerResolverFactory;

    public function __construct(SwaggerResolverFactory $swaggerResolverFactory)
    {
        $this->swaggerResolverFactory = $swaggerResolverFactory;
    }

    public function createForRequest(Request $request): OptionsResolver
    {
        return $this->swaggerResolverFactory->createForRequest($request);
    }

    public function createForDefinition(string $definitionName): OptionsResolver
    {
        return $this->swaggerResolverFactory->createForDefinition($definitionName);
    }
}

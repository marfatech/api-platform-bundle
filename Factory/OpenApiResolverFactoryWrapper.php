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

use Exception;
use Linkin\Bundle\SwaggerResolverBundle\Factory\OpenApiResolverFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OpenApiResolverFactoryWrapper implements ResolverFactoryInterface
{
    private OpenApiResolverFactory $openApiResolverFactory;

    public function __construct(OpenApiResolverFactory $swaggerResolverFactory)
    {
        $this->openApiResolverFactory = $swaggerResolverFactory;
    }

    /**
     * @throws Exception
     */
    public function createForRequest(Request $request): OptionsResolver
    {
        return $this->openApiResolverFactory->createForRequest($request);
    }

    /**
     * @throws Exception
     */
    public function createForDefinition(string $definitionName): OptionsResolver
    {
        return $this->openApiResolverFactory->createForSchema($definitionName);
    }
}

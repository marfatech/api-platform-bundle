<?php

declare(strict_types=1);

namespace MarfaTech\Bundle\ApiPlatformBundle\DependencyInjection\Compiler;

use Linkin\Bundle\SwaggerResolverBundle\Factory\SwaggerResolverFactory;
use MarfaTech\Bundle\ApiPlatformBundle\Factory\ApiDtoFactory;
use MarfaTech\Bundle\ApiPlatformBundle\Factory\ApiDtoResolverFactory;
use MarfaTech\Bundle\ApiPlatformBundle\Factory\OpenApiResolverFactoryWrapper;
use MarfaTech\Bundle\ApiPlatformBundle\Factory\OptionsResolverFactory;
use MarfaTech\Bundle\ApiPlatformBundle\Factory\ResolverFactoryInterface;
use MarfaTech\Bundle\ApiPlatformBundle\Factory\SwaggerResolverFactoryWrapper;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class OptionsResolverFactoryCompiler implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container): void
    {
        if ($container->hasDefinition(SwaggerResolverFactory::class)) {
            $swaggerResolverFactory = $container->getDefinition(SwaggerResolverFactory::class);

            $swaggerResolverFactoryWrapper = new Definition(SwaggerResolverFactoryWrapper::class);
            $swaggerResolverFactoryWrapper->addArgument($swaggerResolverFactory);

            $container->setAlias(ResolverFactoryInterface::class, SwaggerResolverFactoryWrapper::class);
            $container->setDefinition(SwaggerResolverFactoryWrapper::class, $swaggerResolverFactoryWrapper);

            $container->setAlias('marfa_tech_api_platform.factory.api_dto', ApiDtoFactory::class);
        } elseif ($container->hasDefinition('linkin_swagger_resolver.openapi_resolver_factory')) {
            $openApiResolverFactory = $container->getDefinition('linkin_swagger_resolver.openapi_resolver_factory');

            $openApiResolverFactoryWrapper = new Definition(OpenApiResolverFactoryWrapper::class);
            $openApiResolverFactoryWrapper->addArgument($openApiResolverFactory);

            $container->setAlias(ResolverFactoryInterface::class, OpenApiResolverFactoryWrapper::class);
            $container->setDefinition(OpenApiResolverFactoryWrapper::class, $openApiResolverFactoryWrapper);

            $container->setAlias('marfa_tech_api_platform.factory.api_dto', ApiDtoResolverFactory::class);
        } else {
            $optionsResolverFactory = new Definition(OptionsResolverFactory::class);

            $container->setAlias(ResolverFactoryInterface::class, OptionsResolverFactory::class);
            $container->setDefinition(OptionsResolverFactory::class, $optionsResolverFactory);

            $container->setAlias('marfa_tech_api_platform.factory.api_dto', ApiDtoResolverFactory::class);
        }
    }
}

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

namespace MarfaTech\Bundle\ApiPlatformBundle\DependencyInjection\Compiler;

use MarfaTech\Bundle\ApiPlatformBundle\EventListener\ApiResponseListener;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ApiResponseListenerCompiler implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container): void
    {
        $responseDebug = $container->getParameter('marfa_tech_api_platform.response_debug');
        $container->getParameterBag()->remove('marfa_tech_api_platform.response_debug');

        $apiResultDtoClass = $container->getParameter('marfa_tech_api_platform.api_result_dto_class');
        $container->getParameterBag()->remove('marfa_tech_api_platform.api_result_dto_class');

        $listenerDefinition = $container->getDefinition(ApiResponseListener::class);
        $listenerDefinition
            ->addArgument($apiResultDtoClass)
            ->addArgument($responseDebug)
        ;
    }
}

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

use Exception;
use MarfaTech\Bundle\ApiPlatformBundle\Guesser\ApiAreaGuesserInterface;
use MarfaTech\Bundle\ApiPlatformBundle\HttpFoundation\ApiKernel;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

use function is_subclass_of;
use function sprintf;

class ApiKernelCompiler implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container): void
    {
        $apiAreaId = $container->getParameter('marfa_tech_api_platform.api_area_guesser_service');
        $container->getParameterBag()->remove('marfa_tech_api_platform.api_area_guesser_service');

        if (!$container->hasDefinition($apiAreaId)) {
            throw new ServiceNotFoundException($apiAreaId, ApiKernel::class);
        }

        $guesserDefinition = $container->getDefinition($apiAreaId);

        if (!is_subclass_of($guesserDefinition->getClass(), ApiAreaGuesserInterface::class)) {
            throw new InvalidArgumentException(sprintf(
                '"%s" should implements "%s" interface',
                $guesserDefinition->getClass(),
                ApiAreaGuesserInterface::class
            ));
        }

        $container
            ->getDefinition('http_kernel')
            ->setClass(ApiKernel::class)
            ->addMethodCall('setApiAreaGuesser', [$guesserDefinition])
        ;
    }
}

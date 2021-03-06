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

namespace MarfaTech\Bundle\ApiPlatformBundle\DependencyInjection;

use Closure;
use MarfaTech\Bundle\ApiPlatformBundle\Dto\ApiResultDto;
use MarfaTech\Bundle\ApiPlatformBundle\Dto\ApiResultDtoInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;

use function is_subclass_of;
use function sprintf;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('marfa_tech_api_platform');

        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->integerNode('minimal_api_version')
                    ->min(1)
                    ->defaultValue(1)
                ->end()
                ->booleanNode('response_debug')->defaultFalse()->end()
                ->scalarNode('api_result_dto_class')
                    ->defaultValue(ApiResultDto::class)
                    ->cannotBeEmpty()
                    ->validate()->always($this->validationForApiResultDtoClass())->end()
                ->end()
                ->scalarNode('api_area_guesser_service')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('error_code_guesser_service')->defaultNull()->end()
            ->end()
        ;

        return $treeBuilder;
    }

    /**
     * @return Closure
     */
    private function validationForApiResultDtoClass(): Closure
    {
        return function ($apiResultClass) {
            if (!is_subclass_of($apiResultClass, ApiResultDtoInterface::class)) {
                throw new InvalidConfigurationException(sprintf(
                    'Parameter "api_result_dto_class" should contain class which implements "%s"',
                    ApiResultDtoInterface::class
                ));
            }

            return $apiResultClass;
        };
    }
}

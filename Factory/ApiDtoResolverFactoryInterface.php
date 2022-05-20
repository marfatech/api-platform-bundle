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

use MarfaTech\Bundle\ApiPlatformBundle\HttpFoundation\ApiRequest;
use MarfaTech\Component\DtoResolver\Dto\CollectionDtoResolverInterface;
use MarfaTech\Component\DtoResolver\Dto\DtoResolverInterface;

interface ApiDtoResolverFactoryInterface
{
    /**
     * @param class-string<T> $className
     *
     * @return T
     *
     * @template T
     */
    public function createApiCollectionDto(string $className): CollectionDtoResolverInterface;

    /**
     * @param class-string<T> $className
     * @param array<string, mixed> $data
     *
     * @return DtoResolverInterface
     *
     * @template T
     */
    public function createApiDto(string $className, array $data): DtoResolverInterface;

    /**
     * @param class-string<T> $className
     * @param ApiRequest $apiRequest
     * @param bool $withHeaders
     * @param bool $withFiles
     *
     * @return T
     *
     * @template T
     */
    public function createApiDtoByRequest(
        string $className,
        ApiRequest $apiRequest,
        bool $withHeaders = false,
        bool $withFiles = false
    ): DtoResolverInterface;
}

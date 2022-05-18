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
use RuntimeException;
use Symfony\Component\HttpFoundation\Request;

use function is_subclass_of;
use function sprintf;

class ApiDtoResolverFactory
{
    private ResolverFactoryInterface $resolverFactory;

    public function __construct(
        ResolverFactoryInterface $resolverFactory
    ) {
        $this->resolverFactory = $resolverFactory;
    }

    /**
     * @param class-string<T> $className
     *
     * @return T
     *
     * @template T
     */
    public function createApiCollectionDto(string $className): CollectionDtoResolverInterface
    {
        if (!is_subclass_of($className, CollectionDtoResolverInterface::class)) {
            $message = sprintf('Received class should implement "%s"', CollectionDtoResolverInterface::class);

            throw new RuntimeException($message);
        }

        $resolver = $this->resolverFactory->createForDefinition($className::getItemDtoClassName());

        return new $className($resolver);
    }

    /**
     * @param class-string<T> $className
     * @param array<string, mixed> $data
     *
     * @return DtoResolverInterface
     *
     * @template T
     */
    public function createApiDto(string $className, array $data): DtoResolverInterface
    {
        if (!is_subclass_of($className, DtoResolverInterface::class)) {
            $message = sprintf('Received class should implement "%s"', DtoResolverInterface::class);

            throw new RuntimeException($message);
        }

        $resolver = $this->resolverFactory->createForDefinition($className);

        return new $className($data, $resolver);
    }

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
    ): DtoResolverInterface {
        if (!is_subclass_of($className, DtoResolverInterface::class)) {
            $message = sprintf('Received class should implement "%s"', DtoResolverInterface::class);

            throw new RuntimeException($message);
        }

        $resolver = $this->resolverFactory->createForRequest($apiRequest);
        $data = $this->getDataForRequest($apiRequest, $withHeaders, $withFiles);

        return new $className($data, $resolver);
    }

    /**
     * @param ApiRequest $request
     * @param bool $withHeaders
     * @param bool $withFiles
     *
     * @return array
     */
    private function getDataForRequest(ApiRequest $request, bool $withHeaders, bool $withFiles): array
    {
        $data = $this->getRequestDataByMethod($request);

        if ($withHeaders) {
            $data += $request->headers->all();
        }

        if ($withFiles) {
            $data += $request->files->all();
        }

        return $data;
    }

    /**
     * @param ApiRequest $apiRequest
     *
     * @return array
     */
    private function getRequestDataByMethod(ApiRequest $apiRequest): array
    {
        $requestMethod = $apiRequest->getMethod();
        $data = $apiRequest->attributes->all();

        if ($requestMethod === Request::METHOD_GET || $requestMethod === Request::METHOD_DELETE) {
            return $data + $apiRequest->query->all();
        }

        return $data + $apiRequest->body->all() + $apiRequest->request->all();
    }
}

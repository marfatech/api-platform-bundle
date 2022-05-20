<?php

declare(strict_types=1);

namespace Factory;

use MarfaTech\Bundle\ApiPlatformBundle\Dto\DummyDto;
use MarfaTech\Bundle\ApiPlatformBundle\Factory\ApiDtoResolverFactory;
use MarfaTech\Bundle\ApiPlatformBundle\Tests\AppTestKernel;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ApiDtoResolverFactoryTest extends TestCase
{
    protected ContainerInterface $container;

    protected function setUp(): void
    {
        parent::setUp();

        $kernel = new AppTestKernel('test', true);
        $kernel->boot();
        $this->container = $kernel->getContainer();
    }

    public function testApiDtoResolverFactory(): void
    {
        $apiDtoFactory = $this->container->get('api_dto_resolver_factory_test');
        self:self::assertInstanceOf(ApiDtoResolverFactory::class, $apiDtoFactory);

        $dto = $apiDtoFactory->createApiDto(DummyDto::class, ['string' => 'testString']);

        self::assertInstanceOf(DummyDto::class, $dto);
        self::assertSame( 'testString', $dto->getString());
    }
}

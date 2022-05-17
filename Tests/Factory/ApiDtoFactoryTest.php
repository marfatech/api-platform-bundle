<?php

declare(strict_types=1);

namespace Factory;

use MarfaTech\Bundle\ApiPlatformBundle\Dto\DummyDto;
use MarfaTech\Bundle\ApiPlatformBundle\Factory\ApiDtoFactory;
use MarfaTech\Bundle\ApiPlatformBundle\Tests\AppTestKernel;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ApiDtoFactoryTest extends TestCase
{
    protected ContainerInterface $container;

    protected function setUp(): void
    {
        parent::setUp();

        $kernel = new AppTestKernel('test', true);
        $kernel->boot();
        $this->container = $kernel->getContainer();
    }

    public function testApiDtoFactory(): void
    {
        $apiDtoFactory = $this->container->get(ApiDtoFactory::class);
        $dto = $apiDtoFactory->createApiDto(DummyDto::class, ['string' => 'testString']);

        self:self::assertInstanceOf(DummyDto::class, $dto);
        self::assertSame( 'testString', $dto->getString());
    }
}

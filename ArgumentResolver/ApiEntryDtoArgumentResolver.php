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

namespace MarfaTech\Bundle\ApiPlatformBundle\ArgumentResolver;

use Exception;
use Generator;
use MarfaTech\Bundle\ApiPlatformBundle\Exception\ApiException;
use MarfaTech\Bundle\ApiPlatformBundle\Factory\ApiDtoFactory;
use MarfaTech\Bundle\ApiPlatformBundle\HttpFoundation\ApiRequest;
use MarfaTech\Component\DtoResolver\Dto\DtoResolverInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;
use Symfony\Component\Validator\Exception\ValidationFailedException;

use function is_subclass_of;
use function sprintf;

class ApiEntryDtoArgumentResolver implements ArgumentValueResolverInterface
{
    /**
     * @var ApiDtoFactory
     */
    private $factory;

    /**
     * @param ApiDtoFactory $factory
     */
    public function __construct(ApiDtoFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * {@inheritDoc}
     */
    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return $request instanceof ApiRequest && is_subclass_of($argument->getType(), DtoResolverInterface::class);
    }

    /**
     * @param ApiRequest|Request $request
     * @param ArgumentMetadata $argument
     *
     * @return Generator
     */
    public function resolve(Request $request, ArgumentMetadata $argument): Generator
    {
        try {
            $resolvedArgument = $this->factory->createApiDtoByRequest($argument->getType(), $request);
        } catch (ValidationFailedException $e) {
            $violationList = $e->getViolations();

            $violation = $violationList->has(0) ? $violationList->get(0) : null;

            if ($violation) {
                $message = sprintf('%s: %s', $violation->getInvalidValue(), $violation->getMessage());
            } else {
                $message = (string) $e;
            }

            throw new ApiException(ApiException::HTTP_BAD_REQUEST_DATA, $message);
        } catch (Exception|InvalidOptionsException $e) {
            throw new ApiException(ApiException::HTTP_BAD_REQUEST_DATA, $e->getMessage());
        }

        yield $resolvedArgument;
    }
}

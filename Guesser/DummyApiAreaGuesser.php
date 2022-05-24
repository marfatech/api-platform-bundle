<?php

declare(strict_types=1);

namespace MarfaTech\Bundle\ApiPlatformBundle\Guesser;

use Symfony\Component\HttpFoundation\Request;

class DummyApiAreaGuesser implements ApiAreaGuesserInterface
{
    /**
     * {@inheritDoc}
     */
    public function getApiVersion(Request $request): ?int
    {
        return 1;
    }

    /**
     * {@inheritdoc}
     */
    public function isApiRequest(Request $request): bool
    {
        return true;
    }
}

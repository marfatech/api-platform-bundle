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
        $apiVersionMatch = [];
        preg_match('/^\/v([\d]+)\//i', $request->getPathInfo(), $apiVersionMatch);

        if (empty($apiVersionMatch)) {
            return null;
        }

        $apiVersion = (int) end($apiVersionMatch);

        return $apiVersion;
    }

    /**
     * {@inheritdoc}
     */
    public function isApiRequest(Request $request): bool
    {
        return strpos($request->getPathInfo(), '/api') === 0;
    }
}

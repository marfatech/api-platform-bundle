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

namespace MarfaTech\Bundle\ApiPlatformBundle\EventListener;

use MarfaTech\Bundle\ApiPlatformBundle\Exception\ApiException;
use MarfaTech\Bundle\ApiPlatformBundle\HttpFoundation\ApiRequest;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class MinimalApiVersionRequestListener
{
    /**
     * @var int
     */
    protected $minimalApiVersion;

    /**
     * @param int $minimalApiVersion
     */
    public function __construct(int $minimalApiVersion)
    {
        $this->minimalApiVersion = $minimalApiVersion;
    }

    /**
     * @param RequestEvent $event
     */
    public function onKernelRequest(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $request = $event->getRequest();

        if (!$request instanceof ApiRequest) {
            return;
        }

        if ($request->getApiVersion() < $this->minimalApiVersion) {
            throw new ApiException(ApiException::HTTP_GONE, 'Minimal api version is: ' . $this->minimalApiVersion);
        }
    }
}

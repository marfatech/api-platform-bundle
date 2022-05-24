<?php

use MarfaTech\Bundle\ApiPlatformBundle\HttpFoundation\ApiRequestOld;
use MarfaTech\Bundle\ApiPlatformBundle\HttpFoundation\ApiRequestSF6;
use Symfony\Component\HttpKernel\Kernel;

if (Kernel::MAJOR_VERSION >= 6) {
    class_alias(ApiRequestSF6::class, 'MarfaTech\Bundle\ApiPlatformBundle\HttpFoundation\ApiRequest');
} else {
    class_alias(ApiRequestOld::class, 'MarfaTech\Bundle\ApiPlatformBundle\HttpFoundation\ApiRequest');
}

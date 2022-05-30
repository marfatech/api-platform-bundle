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

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;

interface ResolverFactoryInterface
{
    public function createForRequest(Request $request): OptionsResolver;

    public function createForDefinition(string $definitionName): OptionsResolver;
}

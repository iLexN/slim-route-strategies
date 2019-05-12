<?php

declare(strict_types=1);

namespace Ilex\Slim\Tests\RouteStrategies\Fake;

use Ilex\Slim\RouteStrategies\RouteArgsResolverInterface;

final class Case2 implements RouteArgsResolverInterface
{
    public function getArgsResolver(): array
    {
        return [
            'z' => 'a',
        ];
    }
}

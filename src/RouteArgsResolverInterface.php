<?php

declare(strict_types=1);

namespace Ilex\Slim\RouteStrategies;

interface RouteArgsResolverInterface
{
    public function getArgsResolver(): array;
}

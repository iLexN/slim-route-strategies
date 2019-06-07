<?php

declare(strict_types=1);

namespace Ilex\Slim\RouteStrategies;

interface RouteArgsResolverInterface
{
    /**
     * @return iterable
     */
    public function getArgsResolver(): iterable;
}

<?php

declare(strict_types=1);

namespace Ilex\Slim\Tests\RouteStrategies\Fake;

use Ilex\Slim\RouteStrategies\RouteArgsResolverInterface;

final class Case1 implements RouteArgsResolverInterface
{
    public function __invoke(string $value): int
    {
        return 1;
    }

    public function get(string $value): string
    {
        return $value;
    }

    /**
     * @return callable[]|iterable
     */
    public function getArgsResolver(): iterable
    {
        return [
            'a' => [$this, 'get'],
            'b' => static function ($value) {
                return $value;
            },
            'c' => $this,
        ];
    }
}

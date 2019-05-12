<?php

declare(strict_types=1);

namespace Ilex\Slim\Tests\RouteStrategies\Strategies;

use Ilex\Slim\RouteStrategies\Exception\RouteArgsResolverException;
use Ilex\Slim\RouteStrategies\RouteArgsResolver;
use Ilex\Slim\RouteStrategies\Strategies\RequestResponseArgs;
use Ilex\Slim\Tests\RouteStrategies\Fake\Case1;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class RequestResponseArgsTest extends TestCase
{
    public function testCreateClass(): void
    {
        self::assertEquals(true, true);
    }

    /**
     * @dataProvider provider
     *
     * @param callable $callable
     * @param array $args
     * @throws RouteArgsResolverException
     * @throws \ReflectionException
     */
    public function testInvoke(callable $callable, array $args): void
    {
        $request = $this->createMock(ServerRequestInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $r = new RouteArgsResolver();
        $r->add(new Case1());
        $strategies = new RequestResponseArgs($r);
        $response1 = $strategies($callable, $request, $response, $args);
        self::assertEquals($response, $response1);
    }

    public function provider(): array
    {
        return [
            [
                static function ($request, $response, string $a, string $b, int $c) {
                    self::assertEquals('a', $a);
                    self::assertEquals('b', $b);
                    self::assertEquals(1, $c);
                    return $response;
                },
                [
                    'a' => 'a',
                    'b' => 'b',
                    'c' => 'c'
                ],
            ],
            [
                static function ($request, $response, int $c, string $z) {
                    self::assertEquals('z', $z);
                    self::assertEquals(1, $c);
                    return $response;
                },
                [
                    'c' => 'c',
                    'z' => 'z'
                ],
            ],
        ];
    }
}

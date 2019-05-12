<?php

namespace Ilex\Slim\Tests\RouteStrategies;

use Ilex\Slim\RouteStrategies\Exception\RouteArgsResolverException;
use Ilex\Slim\RouteStrategies\RouteArgsResolver;
use Ilex\Slim\Tests\RouteStrategies\Fake\Case1;
use Ilex\Slim\Tests\RouteStrategies\Fake\Case2;
use PHPUnit\Framework\TestCase;

final class RouteArgsResolverTest extends TestCase
{
    public function testAdd(): void
    {
        $resolver = new RouteArgsResolver();
        $newResolver = $resolver->add(new Case1());
        self::assertEquals($resolver, $newResolver);
    }

    public function testAddKeyExist(): void
    {
        $this->expectException(RouteArgsResolverException::class);
        $resolver = new RouteArgsResolver();
        $resolver->add(new Case1())
            ->add(new Case1());
    }

    public function testIsNotCallable(): void
    {
        $this->expectException(RouteArgsResolverException::class);
        $resolver = new RouteArgsResolver();
        $resolver->add(new Case2());
    }

    public function testHasKey(): void
    {
        $resolver = new RouteArgsResolver();
        $resolver->add(new Case1());

        self::assertEquals(true, $resolver->has('a'));
        self::assertEquals(false, $resolver->has('i'));
    }

    public function testResolve(): void
    {
        $resolver = new RouteArgsResolver();
        $resolver->add(new Case1());

        $result = $resolver->resolve('a', 'a');

        self::assertEquals('a', $result);
    }
}

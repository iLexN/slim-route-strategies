<?php

declare(strict_types=1);

namespace Ilex\Slim\RouteStrategies;

use Ilex\Slim\RouteStrategies\Exception\RouteArgsResolverException;

final class RouteArgsResolver
{
    /**
     * @var callable[]
     */
    private $resolvers = [];

    public function __construct()
    {
    }

    /**
     * @param RouteArgsResolverInterface $handler
     * @return RouteArgsResolver
     * @throws RouteArgsResolverException
     */
    public function add(RouteArgsResolverInterface $handler): self
    {
        $keys = $handler->getArgsResolver();
        foreach ($keys as $key => $callable) {
            $this->isValid($key, $callable);
            $this->resolvers[$key] = $callable;
        }
        return $this;
    }

    /**
     * @param string $key
     * @param string $value
     * @return mixed
     */
    public function resolve(string$key, string $value)
    {
        return \call_user_func($this->resolvers[$key], $value);
    }

    public function has(string $key): bool
    {
        return isset($this->resolvers[$key]);
    }

    /**
     * @param string $key
     * @param mixed $callable
     * @throws RouteArgsResolverException
     */
    private function isValid(string $key, $callable): void
    {
        if (\array_key_exists($key, $this->resolvers)) {
            throw RouteArgsResolverException::KeyAlreadyExist($key);
        }

        if (!\is_callable($callable)) {
            throw RouteArgsResolverException::isNotCallable($key);
        }
    }
}

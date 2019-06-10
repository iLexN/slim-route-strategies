<?php

declare(strict_types=1);

namespace Ilex\Slim\RouteStrategies\Strategies;

use Ilex\Slim\RouteStrategies\RouteArgsResolver;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Interfaces\InvocationStrategyInterface;

final class RequestResponseArgs implements InvocationStrategyInterface
{
    /**
     * @var RouteArgsResolver
     */
    private $routeArgsResolver;

    /**
     * RequestResponseArgs constructor.
     *
     * @param RouteArgsResolver $routeArgsResolver
     */
    public function __construct(RouteArgsResolver $routeArgsResolver)
    {
        $this->routeArgsResolver = $routeArgsResolver;
    }

    /**
     * Invoke a Route callable.
     *
     * @param callable $callable The callable to invoke using the strategy.
     * @param ServerRequestInterface $serverRequest The request object.
     * @param ResponseInterface $response The response object.
     * @param array $routeArguments The Route's placeholder arguments
     *
     * @return ResponseInterface The response from the callable.
     */
    public function __invoke(
        callable $callable,
        ServerRequestInterface $serverRequest,
        ResponseInterface $response,
        array $routeArguments
    ): ResponseInterface {
        $newRouteArguments = \array_map(
            [$this, 'resolve'],
            array_keys($routeArguments),
            $routeArguments
        );

        return $callable($serverRequest, $response, ...$newRouteArguments);
    }

    /**
     * @param string $key
     * @param string $value
     *
     * @return mixed
     */
    private function resolve(string $key, string $value)
    {
        if ($this->routeArgsResolver->has($key)) {
            return $this->routeArgsResolver->resolve($key, $value);
        }
        return $value;
    }
}

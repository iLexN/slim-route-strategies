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
    private $argsResolvers;

    /**
     * RequestResponseArgs constructor.
     *
     * @param RouteArgsResolver $argsResolver
     */
    public function __construct(RouteArgsResolver $argsResolver)
    {
        $this->argsResolvers = $argsResolver;
    }

    /**
     * Invoke a Route callable.
     *
     * @param callable $callable The callable to invoke using the strategy.
     * @param ServerRequestInterface $request The request object.
     * @param ResponseInterface $response The response object.
     * @param array $routeArguments The Route's placeholder arguments
     *
     * @return ResponseInterface The response from the callable.
     */
    public function __invoke(
        callable $callable,
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $routeArguments
    ): ResponseInterface {
        foreach ($routeArguments as $key => $value) {
            if ($this->argsResolvers->has($key)) {
                $routeArguments[$key] = $this->argsResolvers->resolve($key, $value);
            }
        }

        return $callable($request, $response, ...array_values($routeArguments));
    }
}

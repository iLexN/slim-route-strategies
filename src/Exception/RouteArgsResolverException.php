<?php

declare(strict_types=1);

namespace Ilex\Slim\RouteStrategies\Exception;

final class RouteArgsResolverException extends \Exception
{
    public static function keyAlreadyExist(string $key): self
    {
        $message = "key ({$key}) already exist";
        return new static($message);
    }

    public static function isNotCallable(string $key): self
    {
        $message = "Key ({$key}) is not callable";
        return new static($message);
    }
}

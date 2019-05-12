<?php

declare(strict_types=1);

namespace Ilex\Slim\RouteStrategies\Exception;

use Throwable;

class RouteArgsResolverException extends \Exception
{
    public function __construct(
        string $message = '',
        int $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    public static function KeyAlreadyExist(string  $key): self
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

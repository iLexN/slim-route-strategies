# Slim4 Route Strategies

[![Coverage Status](https://coveralls.io/repos/github/iLexN/slim-route-strategies/badge.svg?branch=master)](https://coveralls.io/github/iLexN/slim-route-strategies?branch=master)
[![Build Status](https://travis-ci.org/iLexN/slim-route-strategies.svg?branch=master)](https://travis-ci.org/iLexN/slim-route-strategies)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/iLexN/slim-route-strategies/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/iLexN/slim-route-strategies/?branch=master)


Slim 4 route strategies for parameter upcasting

## Install

Via Composer

``` bash
$ composer require ilexn/slim-route-strategies
```

## Usage

``` php
$resolver = new RouteArgsResolver();
$resolver->add(new Case1());

$app = AppFactory::create();
$routeCollector = $app->getRouteCollector();
$routeCollector->setDefaultInvocationStrategy($resolver);

$app->get('/hello/{name}', function ($request, $response, Name $name) {
    $response->getBody()->write("Hello ". $name->getName());
    return $response;
});

```
``` php
final class Case1 implements RouteArgsResolverInterface
{
    public function __invoke(string $value): int
    {
        return 1;
    }

    public function get(string $value): Name
    {
        return new Name($value);
    }
    
    /**
    * @return callable[]
    */
    public function getArgsResolver(): array
    {
        return [
            'name' => [$this, 'get'],
            'b' => static function ($value) {
                return $value;
            },
            'c' => $this,
        ];
    }
}
```
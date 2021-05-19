<?php

namespace Kiboko\Component\ArrayExpressionLanguage;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;

class Map extends ExpressionFunction
{
    public function __construct($name)
    {
        parent::__construct(
            $name,
            \Closure::fromCallable([$this, 'compile'])->bindTo($this),
            \Closure::fromCallable([$this, 'evaluate'])->bindTo($this)
        );
    }

    private function compile(string $callback, string $iterator): string
    {
        $pattern = <<<"PATTERN"
(function() use(%1\$s) {
    foreach (%s as \$item) {
        yield %s(\$item);
    }
})()
PATTERN;

        return sprintf($pattern, $iterator, $callback);
    }

    private function evaluate(array $context, callable $callback, iterable $iterator): \Generator
    {
        foreach ($iterator as $item) {
            yield $callback($item);
        }
    }
}

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
foreach (%s as \$i) {
    yield %s(\$i);
}
PATTERN;

        return sprintf($pattern, $iterator, $callback);
    }

    public function evaluate(array $context, callable $callback, iterable $iterator): \Generator
    {
        foreach ($iterator as $i) {
            yield $callback($i);
        }
    }
}

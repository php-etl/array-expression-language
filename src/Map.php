<?php

declare(strict_types=1);

namespace Kiboko\Component\ArrayExpressionLanguage;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;

class Map extends ExpressionFunction
{
    public function __construct($name)
    {
        parent::__construct(
            $name,
            $this->compile(...)->bindTo($this),
            $this->evaluate(...)->bindTo($this)
        );
    }

    private function compile(string $callback, string $iterator): string
    {
        $pattern = <<<'PATTERN'
            (function($source) {
                foreach ($source as $item) {
                    yield (%2$s)($item);
                }
            })(%1$s)
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

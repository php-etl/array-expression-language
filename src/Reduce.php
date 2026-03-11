<?php

declare(strict_types=1);

namespace Kiboko\Component\ArrayExpressionLanguage;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;

final class Reduce extends ExpressionFunction
{
    public function __construct($name)
    {
        parent::__construct(
            $name,
            $this->compile(...)->bindTo($this),
            $this->evaluate(...)->bindTo($this)
        );
    }

    private function compile(string $iterator, string $callback, string $seed = 'null'): string
    {
        $pattern = <<<'PATTERN'
            (function($source) use ($input) {
                $value = %3$s;
                foreach ($source as $item) {
                    $value = (%2$s)($item, $value);
                }
                
                return $value;
            })(%1$s)
            PATTERN;

        return sprintf($pattern, $iterator, $callback, $seed);
    }

    /**
     * @param array<string, mixed> $context
     * @param iterable<array-key, mixed> $iterator
     */
    private function evaluate(array $context, iterable $iterator, callable $callback, mixed $seed): mixed
    {
        $value = $seed;
        foreach ($iterator as $item) {
            $value = $callback($item, $value);
        }

        return $value;
    }
}

<?php

declare(strict_types=1);

namespace Kiboko\Component\ArrayExpressionLanguage;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;

final class List_ extends ExpressionFunction
{
    public function __construct($name)
    {
        parent::__construct(
            $name,
            \Closure::fromCallable([$this, 'compile'])->bindTo($this),
            \Closure::fromCallable([$this, 'evaluate'])->bindTo($this)
        );
    }

    private function compile(string $length, string $value)
    {
        $pattern =<<<"PATTERN"
array_fill(0, %s, %s)
PATTERN;

        return sprintf($pattern, $length, $value);
    }

    private function evaluate(array $context, int $length, $value)
    {
        return array_fill(0, $length, $value);
    }
}

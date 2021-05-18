<?php

namespace Kiboko\Component\ArrayExpressionLanguage;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;

class SearchData extends ExpressionFunction
{
    public function __construct($name)
    {
        parent::__construct(
            $name,
            \Closure::fromCallable([$this, 'compile'])->bindTo($this),
            \Closure::fromCallable([$this, 'evaluate'])->bindTo($this)
        );
    }

    private function compile(string $path): string
    {
        $pattern = <<<"PATTERN"
function (\$array) use (\$path) {
    return \$array["%s"];
}
PATTERN;

        return sprintf($pattern, $path);
    }

    function evaluate(array $context, string $path): \Closure
    {
        return function ($array) use ($path) {
            return $array[$path];
        };
    }
}

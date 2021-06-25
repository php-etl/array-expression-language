<?php

namespace Kiboko\Component\ArrayExpressionLanguage;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;
use Symfony\Component\PropertyAccess\PropertyAccess;

class ExtractData extends ExpressionFunction
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
\Symfony\Component\PropertyAccess\PropertyAccess::createPropertyAccessor()->getValue(\$item, %s);
PATTERN;

        return sprintf($pattern, $path);
    }

    private function evaluate(array $context, string $path): \Closure
    {
        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        return function ($item) use ($path, $propertyAccessor) {
            return $propertyAccessor->getValue($item, $path);
        };
    }
}

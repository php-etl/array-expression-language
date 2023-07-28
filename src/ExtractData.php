<?php

declare(strict_types=1);

namespace Kiboko\Component\ArrayExpressionLanguage;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;
use Symfony\Component\PropertyAccess\PropertyAccess;

class ExtractData extends ExpressionFunction
{
    public function __construct($name)
    {
        parent::__construct(
            $name,
            $this->compile(...)->bindTo($this),
            $this->evaluate(...)->bindTo($this)
        );
    }

    private function compile(string $path): string
    {
        $pattern = <<<'PATTERN'
            fn ($item) => \Symfony\Component\PropertyAccess\PropertyAccess::createPropertyAccessor()->getValue($item, %s)
            PATTERN;

        return sprintf($pattern, $path);
    }

    private function evaluate(array $context, string $path): \Closure
    {
        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        return fn ($item) => $propertyAccessor->getValue($item, $path);
    }
}

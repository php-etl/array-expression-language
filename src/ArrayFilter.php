<?php

declare(strict_types=1);

namespace Kiboko\Component\ArrayExpressionLanguage;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;

class ArrayFilter extends ExpressionFunction
{
    public function __construct($name)
    {
        parent::__construct(
            $name,
            \Closure::fromCallable([$this, 'compile'])->bindTo($this),
            \Closure::fromCallable([$this, 'evaluate'])->bindTo($this)
        );
    }

    private function compile(array|\Traversable $item, ?callable $callback): string
    {
        $pattern = <<<"PATTERN"
        if(!is_array(\$item)) {
            \$item = iterator_to_array(\$item, true);
        }
        return array_filter(\$item, \$callback)
    }
PATTERN;

        return sprintf($pattern, $item);
    }

    private function evaluate(array $context, array|\Traversable $item, ?callable $callback): array
    {
        if (!is_array($item)) {
            $item = iterator_to_array($item, true);
        }
        return array_filter($item, $callback);
    }
}

<?php

declare(strict_types=1);

namespace Kiboko\Component\ArrayExpressionLanguage;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;

final class FilterList extends ExpressionFunction
{
    public function __construct($name)
    {
        parent::__construct(
            $name,
            $this->compile(...)->bindTo($this),
            $this->evaluate(...)->bindTo($this)
        );
    }

    private function compile(string $iterator, string $callback): string
    {
        return <<<PHP
            (function () use(\$input) {
                \$iterator = {$iterator};
                \$callback = {$callback} ?? fn (\$item) => !!\$item;
                
                if (\$iterator instanceof \\IteratorAggregate) {
                    \$iterator = new \\IteratorIterator(\$iterator);
                } else if (is_array(\$iterator)) {
                    \$iterator = new \\ArrayIterator(\$iterator);
                }

                return new \\CallbackFilterIterator(\$iterator, \$callback);
            })()
            PHP;
    }

    private function evaluate(array $context, iterable $iterator, ?callable $callback = null)
    {
        if ($iterator instanceof \IteratorAggregate) {
            $iterator = new \IteratorIterator($iterator);
        } elseif (\is_array($iterator)) {
            $iterator = new \ArrayIterator($iterator);
        }

        return new \CallbackFilterIterator($iterator, $callback ?? fn ($item) => (bool) $item);
    }
}

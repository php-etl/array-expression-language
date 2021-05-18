<?php declare(strict_types=1);

namespace Kiboko\Component\ArrayExpressionLanguage;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;

final class Reduce extends ExpressionFunction
{
    public function __construct($name)
    {
        parent::__construct(
            $name,
            \Closure::fromCallable([$this, 'compile'])->bindTo($this),
            \Closure::fromCallable([$this, 'evaluate'])->bindTo($this)
        );
    }

    private function compile(string $iterator, string $callback)
    {
        $pattern =<<<"PATTERN"
(function() use (\$input) {
    \$value = null;
    foreach (%s as \$item) {
        \$value = (%s)(\$item, \$value);
    }
    
    return \$value;
})()
PATTERN;

        return sprintf($pattern, $iterator, $callback);
    }

    private function evaluate(array $context, iterable $iterator, callable $callback)
    {
        $value = null;
        foreach ($iterator as $item) {
            $value = $callback($item, $value);
        }
        
        return $value;
    }
}

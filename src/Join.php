<?php declare(strict_types=1);

namespace Kiboko\Component\ArrayExpressionLanguage;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;

final class Join extends ExpressionFunction
{
    public function __construct($name)
    {
        parent::__construct(
            $name,
            \Closure::fromCallable([$this, 'compile'])->bindTo($this),
            \Closure::fromCallable([$this, 'evaluate'])->bindTo($this)
        );
    }

    private function compile(string $separator, string $value)
    {
        return <<<PATTERN
(function (array \$input) {
    if (!is_array($value)) {
        return null;
    }
    return implode($separator, array_values($value));
}) (\$input);
PATTERN;
    }

    private function evaluate(array $context, string $separator, array $value)
    {
        return (function (array $separator, array $value) {
            return implode($separator, array_values($value));
        }) ($separator, $value);
    }
}

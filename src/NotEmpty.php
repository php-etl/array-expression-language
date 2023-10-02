<?php

declare(strict_types=1);

namespace Kiboko\Component\ArrayExpressionLanguage;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;

final class NotEmpty extends ExpressionFunction
{
    public function __construct($name)
    {
        parent::__construct(
            $name,
            $this->compile(...)->bindTo($this),
            $this->evaluate(...)->bindTo($this)
        );
    }

    private function compile()
    {
        return <<<PHP
            fn (\$carry, \$item) => \$carry && \$item !== null
            PHP;
    }

    private function evaluate(array $context, string $separator): callable
    {
        return fn ($carry, $item) => $carry && $item !== null;
    }
}

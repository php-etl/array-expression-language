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
            $this->compile(...)->bindTo($this),
            $this->evaluate(...)->bindTo($this)
        );
    }

    private function compile(string $length, string $value): string
    {
        $pattern = <<<'PATTERN'
            array_fill(0, %s, %s)
            PATTERN;

        return sprintf($pattern, $length, $value);
    }

    /**
     * @param array<string, mixed> $context
     * @return list<mixed>
     */
    private function evaluate(array $context, int $length, mixed $value): array
    {
        return array_fill(0, $length, $value);
    }
}

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

    private function compile(string $separator)
    {
        $pattern =<<<"PATTERN"
function (\$item, \$value) {
    if (null === \$item) {
        throw new \InvalidArgumentException('Item must not be null');
    }

    if (null === \$value) {
        return \$item;
    }

    return \$value . %s . \$item;
}
PATTERN;

        return sprintf($pattern, $separator);
    }

    private function evaluate(array $context, string $separator)
    {
        return function ($item, $value) use ($separator) {
            if (null === $item) {
                throw new \InvalidArgumentException('Item must not be null');
            }

            if (null === $value) {
                return $item;
            }

            return $value . $separator . $item;
        };
    }
}

<?php

namespace Kiboko\Component\ArrayExpressionLanguage;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;

class ArrayExpressionLanguageProvider implements ExpressionFunctionProviderInterface
{
    public function getFunctions(): array
    {
        return [
            new Join('join'),
            ExpressionFunction::fromPhp('array_key_first', 'firstKey'),
            ExpressionFunction::fromPhp('array_key_last', 'lastKey')
        ];
    }
}

<?php

namespace Kiboko\Component\ArrayExpressionLanguage;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;

class ArrayExpressionLanguageProvider implements ExpressionFunctionProviderInterface
{
    public function getFunctions(): array
    {
        return [
            ExpressionFunction::fromPhp('array_key_first', 'firstKey'),
            ExpressionFunction::fromPhp('array_key_last', 'lastKey'),
            ExpressionFunction::fromPhp('array_key_exists', 'keyExists'),
            ExpressionFunction::fromPhp('array_merge', 'merge'),
            ExpressionFunction::fromPhp('count', 'count'),
            ExpressionFunction::fromPhp('array_combine', 'combine'),
            new Reduce('reduce'),
            new Join('join'),
            new Map('map'),
            new ExtractData('extractData'),
            new List_('list'),
        ];
    }
}

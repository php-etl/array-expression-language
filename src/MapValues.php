<?php

declare(strict_types=1);

namespace Kiboko\Component\ArrayExpressionLanguage;

use Kiboko\Contract\Pipeline\RejectedItemException;
use Symfony\Component\ExpressionLanguage\ExpressionFunction;

class MapValues extends ExpressionFunction
{
    public function __construct($name)
    {
        parent::__construct(
            $name,
            $this->compile(...)->bindTo($this),
            $this->evaluate(...)->bindTo($this)
        );
    }

    private function compile(string $input, string $values): string
    {
        return <<<PHP
            (function () use(\$input) {
                \$inputs = {$input};
                \$patterns = [];
                \$replacements = [];
                foreach ({$values} as \$pattern => \$replacement) {
                    \$patterns[] = '('.\$pattern.')';
                    \$replacements[] = \$replacement;
                }

                \$pattern = '/^' . implode('|', \$patterns) . '$/';

                if (is_iterable(\$inputs)) {
                    foreach (\$inputs as \$key => \$input) {
                        preg_match(\$pattern, (string) \$input, \$matches);

                        if (empty(\$matches)) {
                            throw new Kiboko\Contract\Pipeline\RejectedItemException(sprintf(
                            'No replacement found for value "%s". Expected values: %s',
                             \$input,
                              implode(', ', array_keys(\$replacements))
                          ));
                        }

                        array_shift(\$matches);
                        \$inputs[\$key] = \$replacements[array_keys(array_filter(\$matches))[0]];
                    }
                }

                return \$inputs;
            })()
            PHP;
    }

    private function evaluate(array $context, array $input, array $values)
    {
        $inputs = $input;
        $patterns = [];
        $replacements = [];
        foreach ($values as $pattern => $replacement) {
            $patterns[] = '('.$pattern.')';
            $replacements[] = $replacement;
        }

        $pattern = '/^' . implode('|', $patterns) . '$/';

        if (is_iterable($inputs)) {
            foreach ($inputs as $key => $input) {
                preg_match($pattern, (string) $input, $matches);

                if (empty($matches)) {
                    throw new RejectedItemException(sprintf(
                    'No replacement found for value "%s". Expected values: %s',
                     $input,
                      implode(', ', array_keys($replacements))
                  ));
                }

                array_shift($matches);
                $inputs[$key] = $replacements[array_keys(array_filter($matches))[0]];
            }
        }

        return $inputs;
    }
}

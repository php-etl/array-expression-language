<?php

namespace functional\Kiboko\Component\ArrayExpressionLanguage;

use Kiboko\Component\ArrayExpressionLanguage\ArrayExpressionLanguageProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

class ArrayExpressionLanguageProviderTest extends TestCase
{
    public function testCountExpression(): void
    {
        $input = [
            'bar',
            'foo'
        ];

        $interpreter = new ExpressionLanguage(null, [new ArrayExpressionLanguageProvider()]);

        $this->assertEquals(2, $interpreter->evaluate('count(input)', ['input' => $input]));
    }

    public function testListExpression(): void
    {
        $input = [];

        $interpreter = new ExpressionLanguage(null, [new ArrayExpressionLanguageProvider()]);

        $this->assertEquals(
            [
                'test'
            ],
            $interpreter->evaluate('list(1, "test")', ['input' => $input])
        );
    }

    public function testFirstKeyExpression(): void
    {
        $input = [
            'first_name' => 'Wouter',
            'lastName' => 'de Jond',
        ];

        $interpreter = new ExpressionLanguage(null, [new ArrayExpressionLanguageProvider()]);

        $this->assertEquals(
            'first_name',
            $interpreter->evaluate('firstKey(input)', ['input' => $input])
        );
    }

    public function testLastKeyExpression(): void
    {
        $input = [
            'first_name' => 'Wouter',
            'lastName' => 'de Jond',
        ];

        $interpreter = new ExpressionLanguage(null, [new ArrayExpressionLanguageProvider()]);

        $this->assertEquals(
            'lastName',
            $interpreter->evaluate('lastKey(input)', ['input' => $input])
        );
    }

    public function testIterableToArrayExpression(): void
    {
        $input = new \ArrayIterator([
            [
                'first_name' => 'Wouter',
                'lastName' => 'de Jond',
            ],
            [
                'first_name' => 'Foo',
                'lastName' => 'Bar',
            ]
        ]);

        $interpreter = new ExpressionLanguage(null, [new ArrayExpressionLanguageProvider()]);

        $this->assertEquals(
            [
                [
                    'first_name' => 'Wouter',
                    'lastName' => 'de Jond',
                ],
                [
                    'first_name' => 'Foo',
                    'lastName' => 'Bar',
                ]
            ],
            $interpreter->evaluate('iterableToArray(input)', ['input' => $input])
        );
    }

    public function testExtractDataExpression(): void
    {
        $input = [
            'first_name' => 'Wouter',
            'lastName' => 'de Jond',
        ];

        $interpreter = new ExpressionLanguage(null, [new ArrayExpressionLanguageProvider()]);

        $this->assertEquals($input["first_name"], $interpreter->evaluate('extractData("[first_name]")')($input));
    }

    public function testJoinExpression(): void
    {
        $input = [
            'first_name' => 'Wouter',
            'lastName' => 'de Jond',
        ];

        $interpreter = new ExpressionLanguage(null, [new ArrayExpressionLanguageProvider()]);

        $this->assertEquals($input["lastName"] . ',' . $input["first_name"], $interpreter->evaluate('join(",")')($input["first_name"], $input["lastName"]));
    }

    public function testFilterListExpression(): void
    {
        $input = [1, 2, 3, 4, 5];

        $callback = static function ($var) {
            return !($var & 1);
        };

        $interpreter = new ExpressionLanguage(null, [new ArrayExpressionLanguageProvider()]);

        $this->assertEquals(
            [
                1 => 2,
                3 => 4
            ],
            $interpreter->evaluate('filterList(input, callback)',
                [
                    'input' => $input,
                    'callback' => $callback
                ]
            )
        );
    }
}

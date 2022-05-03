Array Expression Language
===

This package extends the [ExpressionLanguage](https://symfony.com/doc/current/components/expression_language.html) Symfony component to compile and evaluate arrays and iterables with custom functions.

[![Quality](https://github.com/php-etl/array-expression-language/actions/workflows/quality.yaml/badge.svg)](https://github.com/php-etl/pipeline-contracts/actions/workflows/quality.yaml)
[![PHPStan level 5](https://github.com/php-etl/array-expression-language/actions/workflows/phpstan-5.yaml/badge.svg)](https://github.com/php-etl/array-expression-language/actions/workflows/phpstan-5.yaml)
[![PHPStan level 7](https://github.com/php-etl/array-expression-language/actions/workflows/phpstan-7.yaml/badge.svg)](https://github.com/php-etl/array-expression-language/actions/workflows/phpstan-7.yaml)
[![PHPStan level 8](https://github.com/php-etl/array-expression-language/actions/workflows/phpstan-8.yaml/badge.svg)](https://github.com/php-etl/array-expression-language/actions/workflows/phpstan-8.yaml)
![PHP](https://img.shields.io/packagist/php-v/php-etl/array-expression-language)

Documentation
---

[See full Documentation](https://php-etl.github.io/documentation)

Installation
---

```
composer require php-etl/array-expression-language
```

Usage
---

You can use these expressions in your configuration files as in the following example :

```yaml
foo: '@=count(input["myArray"])'
```

List of available functions
---

#### Generic functions

* `firstKey(array $array) : int|string|null`
* `lastKey(array $array) : int|string|null `
* `keyExists(string|int $key, array $array) : bool`
* `merge(array ...$arrays) : array`
* `count(Countable|array $value) : int`
* `combine(array $keys, array $values) : array`
* `iterableToArray(Traversable $iterator, bool $use_keys = true) : array`
* `map(callable $callback, iterable $source) : iterable`
* `reduce(callable $callback, iterable $source) : string`
* `list(int $length, mixed $value) : iterable`

#### Functions that can be used with `reduce`

* `join(string $separator) : callable`

#### Functions that can be used with `map`

* `extraxctData(string $path) : callable`

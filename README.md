# Array Expression Language
This package extends the [ExpressionLanguage](https://symfony.com/doc/current/components/expression_language.html) component of Symfony to compile and evaluate arrays with custom functions.

# Installation
```
composer require php-etl/array-expression-language
```

# Usage
You can use these expressions in your configuration files as in the following example :
```yaml
foo: '@=count(input["myArray"])'
```

# List of available functions
## Generic functions
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
* `arrayFilter(array $array, ?callable $callback = null) : array`

## Functions that can be used with `reduce`

* `join(string $separator) : callable`

## Functions that can be used with `map`

* `extraxctData(string $path) : callable`

## Functions that can be used with `arrayFilter`

* `reduce(callable $callback, iterable $source) : string` 
* `map(callable $callback, iterable $source) : iterable` 

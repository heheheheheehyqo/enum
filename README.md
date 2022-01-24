# hyqo/enum implementation 
![Packagist Version](https://img.shields.io/packagist/v/hyqo/enum?style=flat-square)
![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/hyqo/enum?style=flat-square)
![GitHub Workflow Status](https://img.shields.io/github/workflow/status/hyqo/enum/run-tests?style=flat-square)

Simple Backed Enums implementation for PHP <8.1

## Install

```sh
composer require hyqo/enum
```

This is very similar to real PHP 8.1 Backed Enums: https://www.php.net/manual/en/language.enumerations.backed.php
* `static` method `from($case): self` will take a scalar and return the corresponding Enum Case. If one is not found, it will throw an exception
* `static` method `tryFrom($case): ?self` will take a scalar and return the corresponding Enum Case. If one is not found, it will return `null`
* `static` method `cases(): array` returns a packed array of all defined Cases
* _read-only_ property `value` is the value specified in the definition
* _read-only_ property `name` is the case-sensitive name of the case itself
* Enums may contain methods

But these are not real Enums, so Cases must be defined via public constants

## Usage
```php
use \Hyqo\Enum\Enum;

class Suit extends Enum
{
    public const Hearts = 'H';
    public const Diamonds = 'D';
    public const Clubs = 'C';
    public const Spades = 'S';

    public function color(): string
    {
        switch ($this->value) {
            case self::Hearts:
            case self::Diamonds:
                return 'red';
            case self::Clubs:
            case self::Spades:
                return 'black';
        }
    }
}

Suit::from(Suit::Hearts)->value //H
Suit::from(Suit::Hearts)->name //Hearts
Suit::from(Suit::Hearts)->color() //red

Suit::tryFrom('foo') //null
Suit::from('foo') //throw \Hyqo\Enum\InvalidValueException

Suit::from(Suit::Hearts)->foo //throw \RuntimeException
Suit::from(Suit::Hearts)->value = 'foo' //throw \RuntimeException
```

<?php

namespace Hyqo\Enum;

/**
 * @property $value
 * @property $name
 */
abstract class Enum
{
    protected $value;
    protected $name;

    /**
     * @param string|int $value
     */
    public function __construct($value)
    {
        foreach (self::cases() as $name => $backedValue) {
            if ($backedValue === $value) {
                $this->value = $value;
                $this->name = $name;
                return;
            }
        }

        throw new InvalidValueException(sprintf('Invalid value: %s', $value));
    }

    public static function cases(): array
    {
        return (new \ReflectionClass(static::class))->getConstants();
    }

    /**
     * @param string|int
     * @return static
     */
    public static function from($value): self
    {
        if (!is_scalar($value)) {
            throw new \InvalidArgumentException('Only scalar value is available, %s given', gettype($value));
        }

        return new static($value);
    }

    /**
     * @param string|int
     * @return static|null
     */
    public static function tryFrom($value): ?self
    {
        try {
            return self::from($value);
        } catch (InvalidValueException $e) {
            return null;
        }
    }

    final public function __get($name)
    {
        switch ($name) {
            case 'value':
                return $this->value;
            case 'name':
                return $this->name;
            default:
                throw new \RuntimeException('Only "value" and "name" properties can be read');
        }
    }

    final public function __set($name, $value)
    {
        throw new \RuntimeException('Property does not exist');
    }

    final public function __isset($name): bool
    {
        switch ($name) {
            case 'value':
            case 'name':
                return true;
            default:
                return false;
        }
    }

    /** @return static */
    final public static function __callStatic($name, $arguments): self
    {
        try {
            if ($value = @constant(static::class . '::' . $name)) {
                return self::from($value);
            }
        } catch (\ErrorException $e) {
        }

        throw new InvalidValueException(sprintf('Invalid case: %s', $value));
    }
}

<?php

namespace Hyqo\Enum\Test;

use Hyqo\Enum\Enum;
use Hyqo\Enum\InvalidValueException;
use PHPUnit\Framework\TestCase;

class EnumTest extends TestCase
{
    public function test_create(): void
    {
        $this->assertEquals('H', Suit::from(Suit::Hearts)->value);
        $this->assertEquals('Hearts', Suit::from(Suit::Hearts)->name);

        $this->assertNull(Suit::tryFrom('foo'));

        $this->expectException(InvalidValueException::class);
        Suit::from('foo');
    }

    public function test_write_value(): void
    {
        $this->expectException(\RuntimeException::class);
        Suit::from(Suit::Hearts)->value = 'foo';
    }

    public function test_cases(): void
    {
        $this->assertEquals([
            'Hearts' => 'H',
            'Diamonds' => 'D',
            'Clubs' => 'C',
            'Spades' => 'S',
        ], Suit::cases());
    }

    public function test_method(): void
    {
        $this->assertEquals('red', Suit::from(Suit::Hearts)->color());
    }
}

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

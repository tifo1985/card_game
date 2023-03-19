<?php

declare(strict_types=1);

namespace App\Domain\Enum;

enum Value: string implements RandomInterface
{
    use RandomTrait;
    case One = 'as';
    case Tow = '2';
    case Three = '3';
    case Four = '4';
    case Five = '5';
    case Six = '6';
    case Seven = '7';
    case Eight = '8';
    case Nine = '9';
    case Ten = '10';
    case Jack = 'jack';
    case King = 'king';
    case Queen = 'queen';

    public static function values(): array
    {
        return array_map(fn (Value $value) => $value->value, Value::cases());
    }
}

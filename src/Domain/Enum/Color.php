<?php

declare(strict_types=1);

namespace App\Domain\Enum;

enum Color: string implements RandomInterface
{
    use RandomTrait;

    case Clubs = 'clubs';
    case Diamonds = 'diamonds';
    case Hearts = 'hearts';
    case Spades = 'spades';

    public static function colors(): array
    {
        return array_map(fn (Color $color) => $color->value, Color::cases());
    }
}

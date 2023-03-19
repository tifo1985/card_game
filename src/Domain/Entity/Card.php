<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Enum\Color;
use App\Domain\Enum\Value;

final class Card
{
    public function __construct(private readonly Color $color, private readonly Value $value)
    {
    }

    public function equals(Card $card): bool
    {
        return (string) $this === (string) $card;
    }

    public function getColor(): string
    {
        return $this->color->value;
    }

    public function getValue(): string
    {
        return $this->value->value;
    }

    public function __toString(): string
    {
        return $this->value->value.'_'.$this->color->value;
    }
}

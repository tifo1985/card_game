<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Enum\Color;
use App\Domain\Enum\RandomInterface;
use App\Domain\Enum\Value;

final class Game implements \JsonSerializable
{
    /**
     * @param RandomInterface[] $colorsOrder
     * @param RandomInterface[] $valuesOrder
     */
    public function __construct(
        private readonly array $colorsOrder,
        private readonly array $valuesOrder,
        private readonly Hand $hand
    ) {
    }

    public function valid(): bool
    {
        $colors = $this->getColorsOrder();
        $values = $this->getValuesOrder();
        if (!$this->hand->valid() ||
            count(Color::colors()) != count($colors) || 0 < count(array_diff(Color::colors(), $colors)) ||
            count(Value::values()) != count($values) || 0 < count(array_diff(Value::values(), $values))
        ) {
            return false;
        }

        return true;
    }

    public function getColorsOrder(): array
    {
        return array_map(fn (Color $color) => $color->value, $this->colorsOrder);
    }

    public function getValuesOrder(): array
    {
        return array_map(fn (Value $value) => $value->value, $this->valuesOrder);
    }

    public function sortHand(): self
    {
        $this->hand->sort($this->getColorsOrder(), $this->getValuesOrder());

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'cards' => $this->hand,
            'colors_order' => $this->getColorsOrder(),
            'values_order' => $this->getValuesOrder(),
        ];
    }
}

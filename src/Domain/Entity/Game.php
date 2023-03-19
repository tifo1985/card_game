<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Enum\Color;
use App\Domain\Enum\RandomInterface;
use App\Domain\Enum\Value;

final class Game implements \JsonSerializable
{
    private const CARDS_NUMBER = 10;
    /** @var Card[] */
    private array $cards = [];

    /**
     * @param RandomInterface[] $colorsOrder
     * @param RandomInterface[] $valuesOrder
     */
    public function __construct(private readonly array $colorsOrder, private readonly array $valuesOrder)
    {
    }

    public function addCard(Card $card): self
    {
        if (!$this->hasCard($card) && self::CARDS_NUMBER > count($this->cards)) {
            $this->cards[] = $card;
        }

        return $this;
    }

    public function hasCard(Card $card): bool
    {
        foreach ($this->cards as $myCard) {
            if ($myCard->equals($card)) {
                return true;
            }
        }

        return false;
    }

    public function valid(): bool
    {
        if (self::CARDS_NUMBER != count($this->cards) && self::CARDS_NUMBER != count(array_unique($this->cards)) ||
            count(Color::cases()) != count($this->colorsOrder) && count(Value::cases()) != count($this->valuesOrder)
        ) {
            return false;
        }

        return true;
    }

    public function sortCards(): self
    {
        $cards = [];
        foreach ($this->colorsOrder as $color) {
            foreach ($this->valuesOrder as $value) {
                $card = new Card($color, $value);
                if ($this->hasCard(new Card($color, $value))) {
                    $cards[] = $card;
                }
            }
        }
        $this->cards = $cards;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'cards' => array_map(fn (Card $card) => ['color' => $card->getColor(), 'value' => $card->getValue()], $this->cards),
            'colors_order' => array_map(fn (Color $color) => $color->value, $this->colorsOrder),
            'values_order' => array_map(fn (Value $value) => $value->value, $this->valuesOrder),
        ];
    }
}

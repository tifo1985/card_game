<?php

declare(strict_types=1);

namespace App\Domain\Entity;

final class Hand implements \JsonSerializable
{
    private const CARDS_NUMBER = 10;

    /** @var Card[] */
    private array $cards = [];

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

    /** @return Card[] */
    public function getCards(): array
    {
        return $this->cards;
    }

    public function valid(): bool
    {
        if (self::CARDS_NUMBER != count($this->cards) && self::CARDS_NUMBER != count(array_unique($this->cards))) {
            return false;
        }

        return true;
    }

    /**
     * Method to sort the cards in the hand based on color and value.
     */
    public function sort(array $colors, array $values)
    {
        // Create a temporary array to hold the sorted cards
        $sortedCards = [];

        // Loop through each color and value to sort the cards
        foreach ($colors as $color) {
            foreach ($values as $value) {
                // Loop through the cards in the hand and add them to the sorted array if they match the color and value
                foreach ($this->cards as $card) {
                    if ($card->getColor() == $color && $card->getValue() == $value) {
                        $sortedCards[] = $card;
                    }
                }
            }
        }

        // Replace the original array with the sorted array
        $this->cards = $sortedCards;
    }

    public function jsonSerialize(): array
    {
        return array_map(fn (Card $card) => ['color' => $card->getColor(), 'value' => $card->getValue()], $this->cards);
    }
}

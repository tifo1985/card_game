<?php

declare(strict_types=1);

namespace App\Domain\UseCase;

use App\Domain\Entity\Card;
use App\Domain\Entity\Game;
use App\Domain\Entity\Hand;
use App\Domain\Enum\Color;
use App\Domain\Enum\Value;
use App\Domain\Exception\InvalidGameException;
use App\Domain\Request\SortCardsRequest;

final class SortCards
{
    public function execute(SortCardsRequest $sortCardsRequest): Game
    {
        try {
            $options = $sortCardsRequest->getOptions();
            $hand = new Hand();
            foreach ($options['cards'] as $cardData) {
                $card = new Card(Color::from($cardData['color']), Value::from($cardData['value']));
                $hand->addCard($card);
            }
            $colorsOrder = array_map(fn (string $color) => Color::from($color), $options['colors_order']);
            $valuesOrder = array_map(fn (string $value) => Value::from($value), $options['values_order']);

            $game = new Game($colorsOrder, $valuesOrder, $hand);
        } catch (\Throwable $exception) {
            throw new InvalidGameException('The request does not contain valid data');
        }

        if (!$game->valid()) {
            throw new InvalidGameException('The request does not contain valid data');
        }
        $game->sortHand();

        return $game;
    }
}

<?php

declare(strict_types=1);

namespace App\Domain\UseCase;

use App\Domain\Entity\Card;
use App\Domain\Entity\Game;
use App\Domain\Enum\Color;
use App\Domain\Enum\Value;

final class GenerateGame
{
    public function execute(): Game
    {
        $game = new Game(Color::randomOrder(), Value::randomOrder());

        do {
            $card = new Card(Color::random(), Value::random());
            $game->addCard($card);
        } while (!$game->valid());

        return $game;
    }
}

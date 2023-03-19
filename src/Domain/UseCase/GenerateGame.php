<?php

declare(strict_types=1);

namespace App\Domain\UseCase;

use App\Domain\Entity\Card;
use App\Domain\Entity\Game;
use App\Domain\Entity\Hand;
use App\Domain\Enum\Color;
use App\Domain\Enum\Value;

final class GenerateGame
{
    public function execute(): Game
    {
        $hand = new Hand();
        do {
            $card = new Card(Color::random(), Value::random());
            $hand->addCard($card);
        } while (!$hand->valid());

        return new Game(Color::randomOrder(), Value::randomOrder(), $hand);
    }
}

<?php

declare(strict_types=1);

namespace App\Tests\Domain\Entity;

use App\Domain\Entity\Card;
use App\Domain\Entity\Game;
use App\Domain\Entity\Hand;
use App\Domain\Enum\Color;
use App\Domain\Enum\Value;
use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{
    public function testValidGame(): void
    {
        $colors = [Color::Diamonds, Color::Hearts, Color::Clubs, Color::Spades];
        $values = [Value::Tow, Value::Three, Value::Four, Value::Five, Value::Seven, Value::Six, Value::Ten, Value::Jack, Value::Eight, Value::Nine, Value::Ase, Value::King, Value::Queen];
        $hand = new Hand();
        for ($i = 0; $i < 10; ++$i) {
            $hand->addCard(new Card($colors[$i % 4], $values[$i]));
        }

        $game = new Game($colors, $values, $hand);
        $this->assertTrue($game->valid());
    }

    public function testInvalidGame(): void
    {
        $colors = [Color::Diamonds, Color::Hearts, Color::Clubs, Color::Clubs];
        $values = [Value::Tow, Value::Three, Value::Four, Value::Five, Value::Seven, Value::Six, Value::Ten, Value::Jack, Value::Eight, Value::Nine, Value::Ase, Value::King, Value::Queen];
        $hand = new Hand();
        for ($i = 0; $i < 10; ++$i) {
            $hand->addCard(new Card($colors[$i % 4], $values[$i]));
        }

        $game = new Game($colors, $values, $hand);

        $this->assertFalse($game->valid());
    }
}

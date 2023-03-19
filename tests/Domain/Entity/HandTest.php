<?php

declare(strict_types=1);

namespace App\Tests\Domain\Entity;

use App\Domain\Entity\Card;
use App\Domain\Entity\Hand;
use App\Domain\Enum\Color;
use App\Domain\Enum\Value;
use PHPUnit\Framework\TestCase;

class HandTest extends TestCase
{
    public function testAddCard(): void
    {
        $hand = new Hand();

        $card1 = new Card(Color::Clubs, Value::King);
        $hand->addCard($card1);
        $hand->addCard($card1);

        $this->assertCount(1, $hand->getCards());
        $this->assertContains($card1, $hand->getCards());

        $card2 = new Card(Color::Diamonds, Value::Five);
        $hand->addCard($card2);

        $this->assertCount(2, $hand->getCards());
        $this->assertContains($card2, $hand->getCards());
    }

    public function testValid(): void
    {
        $hand = new Hand();

        $this->assertFalse($hand->valid());

        $hand->addCard(new Card(Color::Clubs, Value::Ase));
        $this->assertFalse($hand->valid());

        $hand->addCard(new Card(Color::Diamonds, Value::King));
        $this->assertFalse($hand->valid());

        $hand->addCard(new Card(Color::Spades, Value::Queen));
        $this->assertFalse($hand->valid());

        $hand->addCard(new Card(Color::Hearts, Value::Queen));
        $this->assertFalse($hand->valid());

        $hand->addCard(new Card(Color::Clubs, Value::Queen));
        $this->assertFalse($hand->valid());

        $hand->addCard(new Card(Color::Diamonds, Value::Queen));
        $this->assertFalse($hand->valid());

        $hand->addCard(new Card(Color::Spades, Value::Ase));
        $this->assertFalse($hand->valid());

        $hand->addCard(new Card(Color::Hearts, Value::Ase));
        $this->assertFalse($hand->valid());

        $hand->addCard(new Card(Color::Diamonds, Value::Ase));
        $this->assertFalse($hand->valid());

        $hand->addCard(new Card(Color::Hearts, Value::Jack));
        $this->assertTrue($hand->valid());
    }

    public function testSort()
    {
        $card1 = new Card(Color::Hearts, Value::Ase);
        $card2 = new Card(Color::Diamonds, Value::King);
        $card3 = new Card(Color::Clubs, Value::Queen);
        $card4 = new Card(Color::Spades, Value::Jack);
        $card5 = new Card(Color::Hearts, Value::King);

        $hand = (new Hand())
            ->addCard($card1)
            ->addCard($card2)
            ->addCard($card3)
            ->addCard($card4)
            ->addCard($card5);

        $hand->sort(['hearts', 'spades', 'diamonds', 'clubs'], ['king', 'jack', 'queen', 'ase']);

        $expectedCards = [$card5, $card1, $card4, $card2, $card3];
        $actualCards = $hand->getCards();

        $this->assertEquals($expectedCards, $actualCards);
    }
}

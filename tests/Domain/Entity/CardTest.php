<?php

declare(strict_types=1);

namespace App\Tests\Domain\Entity;

use App\Domain\Entity\Card;
use App\Domain\Enum\Color;
use App\Domain\Enum\Value;
use PHPUnit\Framework\TestCase;

class CardTest extends TestCase
{
    public function testCardCreation()
    {
        $card = new Card(Color::Clubs, Value::Tow);
        $this->assertInstanceOf(Card::class, $card);
    }

    public function testCardColor()
    {
        $card = new Card(Color::Hearts, Value::Jack);
        $this->assertEquals('hearts', $card->getColor());
    }

    public function testCardValue()
    {
        $card = new Card(Color::Diamonds, Value::Ase);
        $this->assertEquals('ase', $card->getValue());
    }

    public function testToString()
    {
        $card = new Card(Color::Diamonds, Value::Ase);
        $this->assertEquals('ase_diamonds', $card->__toString());
    }

    public function testEquals()
    {
        $card1 = new Card(Color::Diamonds, Value::Ase);
        $card2 = new Card(Color::Diamonds, Value::Ase);
        $card3 = new Card(Color::Diamonds, Value::Jack);
        $this->assertTrue($card1->equals($card2));
        $this->assertFalse($card1->equals($card3));
    }
}

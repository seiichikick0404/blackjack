<?php
namespace BlackJack\Tests;

use PHPUnit\Framework\TestCase;
use BlackJack\lib\Card;

require_once(__DIR__ . '/../lib/GameClass.php');

class CardTest extends TestCase
{
    public function testRandomTwoCard()
    {
        $card = new Card();
        $card->randomTwoCard();
        $drawCards = $card->getDrawCards();
        $this->assertSame(2, count($drawCards));
    }

    public function testRandomCard()
    {
        $card = new Card();
        $card->randomCard();
        $drawCards = $card->getDrawCards();
        $this->assertSame(1, count($drawCards));
    }

    public function testGetDrawCards()
    {
        // ドローしてない場合
        $card = new Card();
        $this->assertSame([], $card->getDrawCards());
    }
}

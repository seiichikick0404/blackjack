<?php
namespace BlackJack\Tests;

use PHPUnit\Framework\TestCase;
use BlackJack\lib\Dealer;

require_once(__DIR__ . '/../lib/DealerClass.php');

class DealerTest extends TestCase
{
    public function testFirstDrawCards()
    {
        $dealer = new Dealer();

        // カードを2枚ドローできてるか
        $this->assertSame(3, count($dealer->firstDrawCards($dealer)));
    }

    public function testHandleScore()
    {
        $drawCards = [
            [
                'prim' => 'A',
                'rank' => 1,
                'type' => 'ダイヤ'
            ],
        ];

        $drawCards2 = [
            [
                'prim' => 'A',
                'rank' => 1,
                'type' => 'ダイヤ'
            ],
            [
                'prim' => 'A',
                'rank' => 1,
                'type' => 'ダイヤ'
            ],
        ];

        $drawCards3 = [
            [
                'prim' => '3',
                'rank' => 3,
                'type' => 'ハート'
            ],
            [
                'prim' => 'A',
                'rank' => 1,
                'type' => 'クラブ'
            ],
        ];

        // カードが1枚　マッチポイント以下
        $dealer = new Dealer();
        $dealer->handleScore($dealer, $drawCards);
        $this->assertSame(11, $dealer->getScore());

        //  カードが1枚　マッチポイント以上
        $dealer->handleScore($dealer, $drawCards);
        $this->assertSame(12, $dealer->getScore());

        // カードが2枚 どちらもAの時
        $dealer2 = new Dealer();
        $dealer2->handleScore($dealer2, $drawCards2);
        $this->assertSame(12, $dealer2->getScore());

        // カードが2枚 どちらか一方がAの時
        $dealer3 = new Dealer();
        $dealer3->handleScore($dealer3, $drawCards3);
        $this->assertSame(14, $dealer3->getScore());
    }

    public function testGetName()
    {
        $dealer = new Dealer();
        $this->assertSame('dealer', $dealer->getName());
    }

}

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

    public function testDrawCards()
    {
        $dealer = new Dealer();

        // カードを1枚ドローできてるか
        $this->assertSame(2, count($dealer->drawCards($dealer)));
    }

    public function testHandleScore()
    {
        $drawCards = [
            [
                'prim' => 'A',
                'rank' => '1',
                'type' => 'ダイヤ'
            ],
        ];

        $drawCards2 = [
            [
                'prim' => '7',
                'rank' => '7',
                'type' => 'ダイヤ'
            ],
        ];

        $drawCards3 = [
            [
                'prim' => 'A',
                'rank' => '1',
                'type' => 'ダイヤ'
            ],
            [
                'prim' => 'A',
                'rank' => '1',
                'type' => 'ダイヤ'
            ],
        ];

        $drawCards4 = [
            [
                'prim' => '3',
                'rank' => '3',
                'type' => 'ハート'
            ],
            [
                'prim' => 'A',
                'rank' => '1',
                'type' => 'クラブ'
            ],
        ];

        // カードが1枚　Aの時
        $dealer = new Dealer();
        $dealer->handleScore($dealer, $drawCards);
        $this->assertSame(11, $dealer->getScore());

        // カードが1枚　A以外
        // $dealer = new Dealer();
        // $dealer->handleScore($dealer, $drawCards);
        // $this->assertSame(11, $dealer->getScore);


    }

}

<?php
namespace BlackJack\Tests;

use PHPUnit\Framework\TestCase;
use BlackJack\lib\Player2;

require_once(__DIR__ . '/../lib/Player2Class.php');

class Player2Test extends TestCase
{
    public function testFirstDrawCards()
    {
        $player = new Player2();

        // カードを2枚ドローできてるか
        $this->assertSame(3, count($player->firstDrawCards($player)));
    }

    public function testDrawCards()
    {
        $player = new Player2();

        // カードを1枚ドローできてるか
        $this->assertSame(2, count($player->drawCards($player)));
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
        $player = new Player2();
        $player->handleScore($player, $drawCards);
        $this->assertSame(11, $player->getScore());

        //  カードが1枚　マッチポイント以上
        $player->handleScore($player, $drawCards);
        $this->assertSame(12, $player->getScore());

        // カードが2枚 どちらもAの時
        $player2 = new Player2();
        $player2->handleScore($player2, $drawCards2);
        $this->assertSame(12, $player2->getScore());

        // カードが2枚 どちらか一方がAの時
        $player3 = new Player2();
        $player3->handleScore($player3, $drawCards3);
        $this->assertSame(14, $player3->getScore());
    }

    public function testGetName()
    {
        $player = new Player2();
        $this->assertSame('player2', $player->getName());
    }

}

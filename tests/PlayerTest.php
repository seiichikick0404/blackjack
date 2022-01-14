<?php
namespace BlackJack\Tests;

use PHPUnit\Framework\TestCase;
use BlackJack\lib\Player;

require_once(__DIR__ . '/../lib/PlayerClass.php');

class PlayerTest extends TestCase
{
    public function testFirstDrawCards()
    {
        $player = new Player();

        // カードを2枚ドローできてるか
        $this->assertSame(3, count($player->firstDrawCards($player)));

        // 返り値が配列かチェック
        $this->assertTrue(is_array($player->firstDrawCards($player)));
    }

    public function testDrawCards()
    {
        $player = new Player();

        // カードを1枚ドローできてるか
        $this->assertSame(2, count($player->drawCards($player)));

        // 返り値が配列かチェック
        $this->assertTrue(is_array($player->firstDrawCards($player)));
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
        $player = new Player();
        $player->handleScore($player, $drawCards);
        $this->assertSame(11, $player->getScore());

        //  カードが1枚　マッチポイント以上
        $player->handleScore($player, $drawCards);
        $this->assertSame(12, $player->getScore());

        // カードが2枚 どちらもAの時
        $player2 = new Player();
        $player2->handleScore($player2, $drawCards2);
        $this->assertSame(12, $player2->getScore());

        // カードが2枚 どちらか一方がAの時
        $player3 = new Player();
        $player3->handleScore($player3, $drawCards3);
        $this->assertSame(14, $player3->getScore());
    }

    public function testGetScore()
    {
        // 数値かチェック
        $player = new Player();
        $this->assertTrue(is_numeric($player->getScore()));
    }

    public function testGetName()
    {
        $player = new Player();
        $this->assertSame('player', $player->getName());
    }

}

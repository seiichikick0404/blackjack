<?php
namespace BlackJack\Tests;

use PHPUnit\Framework\TestCase;
use BlackJack\lib\TwoPlayerRule;
use BlackJack\lib\Player;
use BlackJack\lib\Dealer;

require_once(__DIR__ . '/../lib/TwoPlayerRuleClass.php');

class TwoPlayerRuleTest extends TestCase
{
    public function testDisplayDrawCards()
    {
        $drawCards = [
            [
                'prim' => 'A',
                'rank' => 1,
                'type' => 'ダイヤ'
            ],
            [
                'prim' => '10',
                'rank' => 10,
                'type' => 'ダイヤ'
            ],
            'name' => 'player'
        ];

        $drawCards2 = [
            [
                'prim' => 'A',
                'rank' => 1,
                'type' => 'ダイヤ'
            ],
            'name' => 'player'
        ];

        $drawCards3 = [
            [
                'prim' => 'A',
                'rank' => 1,
                'type' => 'ダイヤ'
            ],
            [
                'prim' => '10',
                'rank' => 10,
                'type' => 'ダイヤ'
            ],
            'name' => 'dealer'
        ];

        $player = new Player();
        $dealer = new Dealer();
        
        // プレイヤー　初回ドロー
        $rule = new TwoPlayerRule();

        $output = <<<EOD
        あなたの引いたカードはダイヤのAです
        あなたの引いた2枚目のカードはダイヤの10です

        EOD;
        
        $this->expectOutputString($output);
        $rule->displayDrawCards($drawCards);

        // プレイヤー　通常ドロー
        $output = <<<EOD
        あなたの引いたカードはダイヤのAです
        あなたの引いた2枚目のカードはダイヤの10です
        あなたの引いたカードはダイヤのAです

        EOD;
        $this->expectOutputString($output);
        $rule->displayDrawCards($drawCards2);

        // ディーラー　初回ドロー
        $rule = new TwoPlayerRule();
        $output = <<<EOD
        あなたの引いたカードはダイヤのAです
        あなたの引いた2枚目のカードはダイヤの10です
        あなたの引いたカードはダイヤのAです
        ディーラーの引いたカードはダイヤのAです
        ディーラーの引いた2枚目のカードは分かりません

        EOD;
        $this->expectOutputString($output);
        $rule->displayDrawCards($drawCards3);

    }

    public function testSetActivePlayers()
    {
        $player = new Player();
        $dealer = new Dealer();
        $rule = new TwoPlayerRule();

       $playerArr = [
           $player,
           $dealer
       ];

       $rule->setActivePlayers($playerArr);
       $this->assertSame($rule->getActivePlayers(), $playerArr);
    }
}
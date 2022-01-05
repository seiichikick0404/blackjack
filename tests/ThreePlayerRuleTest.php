<?php
namespace BlackJack\Tests;

use PHPUnit\Framework\TestCase;
use BlackJack\lib\ThreePlayerRule;
use BlackJack\lib\Player;
use BlackJack\lib\Dealer;

require_once(__DIR__ . '/../lib/TwoPlayerRuleClass.php');

class ThreePlayerRuleTest extends TestCase
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

        $drawCards4 = [
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
            'name' => 'player2'
        ];

        $drawCards5 = [
            [
                'prim' => 'A',
                'rank' => 1,
                'type' => 'ダイヤ'
            ],
            'name' => 'player2'
        ];
    
        // プレイヤー　初回ドロー
        $rule = new ThreePlayerRule();
        $rule->displayDrawCards($drawCards);

        $output = <<<EOD
        あなたの引いたカードはダイヤのAです
        あなたの引いた2枚目のカードはダイヤの10です
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
        あなたの引いた2枚目のカードはダイヤの10です
        あなたの引いたカードはダイヤのAです

        EOD;
        $this->expectOutputString($output);
        $rule->displayDrawCards($drawCards2);

        // ディーラー　初回ドロー
        $rule = new ThreePlayerRule();
        $output = <<<EOD
        あなたの引いたカードはダイヤのAです
        あなたの引いた2枚目のカードはダイヤの10です
        あなたの引いたカードはダイヤのAです
        あなたの引いた2枚目のカードはダイヤの10です
        あなたの引いたカードはダイヤのAです
        ディーラーの引いたカードはダイヤのAです
        ディーラーの引いた2枚目のカードは分かりません

        EOD;
        $this->expectOutputString($output);
        $rule->displayDrawCards($drawCards3);

        // プレイヤー2　初回ドロー
        $rule = new ThreePlayerRule();
        $output = <<<EOD
        あなたの引いたカードはダイヤのAです
        あなたの引いた2枚目のカードはダイヤの10です
        あなたの引いたカードはダイヤのAです
        あなたの引いた2枚目のカードはダイヤの10です
        あなたの引いたカードはダイヤのAです
        ディーラーの引いたカードはダイヤのAです
        ディーラーの引いた2枚目のカードは分かりません
        プレイヤー2の引いたカードはダイヤのAです
        プレイヤー2の引いた2枚目のカードはダイヤの10です

        EOD;
        $this->expectOutputString($output);
        $rule->displayDrawCards($drawCards4);

        // プレイヤー2　通常ドロー
        $rule = new ThreePlayerRule();
        $output = <<<EOD
        あなたの引いたカードはダイヤのAです
        あなたの引いた2枚目のカードはダイヤの10です
        あなたの引いたカードはダイヤのAです
        あなたの引いた2枚目のカードはダイヤの10です
        あなたの引いたカードはダイヤのAです
        ディーラーの引いたカードはダイヤのAです
        ディーラーの引いた2枚目のカードは分かりません
        プレイヤー2の引いたカードはダイヤのAです
        プレイヤー2の引いた2枚目のカードはダイヤの10です
        プレイヤー2の引いたカードはダイヤのAです

        EOD;
        $this->expectOutputString($output);
        $rule->displayDrawCards($drawCards5);
    }

    public function testSetActivePlayers()
    {
        $player = new Player();
        $dealer = new Dealer();
        $rule = new ThreePlayerRule();

       $playerArr = [
           $player,
           $dealer
       ];

       $rule->setActivePlayers($playerArr);
       $this->assertSame($rule->getActivePlayers(), $playerArr);
    }
}

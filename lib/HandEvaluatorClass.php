<?php
namespace BlackJack\lib;
require_once(__DIR__ . '/PlayerClass.php');
require_once(__DIR__ . '/DealerClass.php');

class HandEvaluator
{
    private const MATCH_POINT = 21;
    private const PLAYER_GAME_COUNT = 21;
    private const DEALER_GAME_COUNT = 17;
    private $PlayerCount = 2;
    private $rule = '';

    public function __construct($rule)
    {
        $this->rule = $rule;
    }


    public function checkOver(array $PlayerArr): void
    {
        $this->rule->checkOver($PlayerArr);
    }

    public function displayResult($PlayerArr, string $winner): void
    {
        foreach ($PlayerArr as $player) {
            echo $player->getName() . 'の得点は' . $player->getScore() . 'です' . PHP_EOL;
        }
        echo $winner . 'の勝ちです！' . PHP_EOL;
        exit;
    }

    public function checkWinner(array $PlayerArr): void
    {
        $this->rule->checkWinner($PlayerArr);

        
        // $PlayerDifference = self::MATCH_POINT - $player->getScore();
        // $Player2Difference = self::MATCH_POINT - $player2->getScore();
        // $DealerDifference = self::MATCH_POINT - $dealer->getScore();

        // $ScoreArr = [
        //     'あなた' => $PlayerDifference,
        //     'プレイヤー2' => $Player2Difference,
        //     'ディーラー' => $DealerDifference
        // ];
        
        $ScoreArr = [];
        // 差分を計算
        foreach ($PlayerArr as $player) {
            $diff = self::MATCH_POINT - $player->getScore();
            $ScoreArr[$player->getName()] = $diff;
        }
        
        $MinPlayers = array_keys($ScoreArr, min($ScoreArr));
        // $MinCount = count($MinPlayers);

        // 全員の得点を表示
        foreach ($PlayerArr as $player) {
            echo $player->getName() . 'の現在の得点は' . $player->getScore() . 'です。' . PHP_EOL;
        }



        
        // if ($MinCount === 1) {
        //     echo '勝者は' . $MinPlayers[0] . 'です！' . PHP_EOL;
        // } elseif ($MinCount === 2 && $MinPlayers[0] !== 'ディーラー' && $MinPlayers[1] !== 'ディーラー') {
        //     echo '勝者は' . $MinPlayers[0] . 'と' . $MinPlayers[1] . 'です！' . PHP_EOL;
        // } elseif ($MinCount === 3) {
        //     echo '引き分けです';
        // } elseif ($MinCount === 2 && $MinPlayers[0] === 'ディーラー' || $MinPlayers[1] === 'ディーラー') {
        //     echo $MinPlayers[0] . 'と' . $MinPlayers[1] . 'は' . '引き分けです！' . PHP_EOL;
        // } 

        echo 'ブラックジャックを終了します。' . PHP_EOL;
        exit;
    }
}
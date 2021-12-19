<?php
namespace BlackJack\lib;
require_once(__DIR__ . '/PlayerClass.php');
require_once(__DIR__ . '/DealerClass.php');

class HandEvaluator
{
    private const MATCH_POINT = 21;
    private const PLAYER_GAME_COUNT = 21;
    private const DEALER_GAME_COUNT = 17;


    public function checkOver(UserInterface $player, UserInterface $player2, Dealer $dealer, $name)
    {
        $PlayerScore = $player->getScore();
        $Player2Score = $player2->getScore();
        $DealerScore = $dealer->getScore();

        if ($name === 'プレイヤー' && $PlayerScore > self::MATCH_POINT) {
            $this->displayResult($PlayerScore, $Player2Score, $DealerScore, 'ディーラーとプレイヤー2');
            exit;
        }  elseif ($name === 'プレイヤー2' && $Player2Score > self::MATCH_POINT) {
            $this->displayResult($PlayerScore, $Player2Score, $PlayerScore, 'あなたとディーラー');
            exit;
        } elseif ($name === 'ディーラー' && $DealerScore > self::MATCH_POINT) {
            $this->displayResult($PlayerScore, $Player2Score, $DealerScore, 'あなたとプレイヤ-2');
            exit;
        }
    }

    public function displayResult(int $PlayerScore, int $Player2Score, int $DealerScore, string $winner): void
    {
        echo 'あなたの得点は' . $PlayerScore . 'です' . PHP_EOL;
        echo 'プレイヤー2の得点は'. $Player2Score . 'です' . PHP_EOL;
        echo 'ディーラーの得点は'. $DealerScore . 'です' . PHP_EOL;
        echo $winner . 'の勝ちです！' . PHP_EOL;
        exit;
    }

    public function checkWinner(UserInterface $player, UserInterface $player2, Dealer $dealer): void
    {
        $PlayerDifference = self::MATCH_POINT - $player->getScore();
        $Player2Difference = self::MATCH_POINT - $player2->getScore();
        $DealerDifference = self::MATCH_POINT - $dealer->getScore();

        $ScoreArr = [
            'あなた' => $PlayerDifference,
            'プレイヤー2' => $Player2Difference,
            'ディーラー' => $DealerDifference
        ];
        
        $MinPlayers = array_keys($ScoreArr, min($ScoreArr));
        $MinCount = count($MinPlayers);

        echo 'あなたの現在の得点は' . $player->getScore() . 'です。' . PHP_EOL;
        echo 'プレイヤ-2の現在の得点は' . $player2->getScore() . 'です。' . PHP_EOL;
        echo 'ディーラーの現在の得点は' . $dealer->getScore() . 'です。' . PHP_EOL;
        
        if ($MinCount === 1) {
            echo '勝者は' . $MinPlayers[0] . 'です！' . PHP_EOL;
        } elseif ($MinCount === 2 && $MinPlayers[0] !== 'ディーラー' && $MinPlayers[1] !== 'ディーラー') {
            echo '勝者は' . $MinPlayers[0] . 'と' . $MinPlayers[1] . 'です！' . PHP_EOL;
        } elseif ($MinCount === 3) {
            echo '引き分けです';
        } elseif ($MinCount === 2 && $MinPlayers[0] === 'ディーラー' || $MinPlayers[1] === 'ディーラー') {
            echo $MinPlayers[0] . 'と' . $MinPlayers[1] . 'は' . '引き分けです！' . PHP_EOL;
        } 

        echo 'ブラックジャックを終了します。' . PHP_EOL;
        exit;
    }
}
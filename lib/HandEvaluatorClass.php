<?php
namespace BlackJack\lib;
require_once(__DIR__ . '/PlayerClass.php');
require_once(__DIR__ . '/DealerClass.php');

class HandEvaluator
{
    private const MATCH_POINT = 21;
    private const PLAYER_GAME_COUNT = 21;
    private const DEALER_GAME_COUNT = 17;


    public function checkOver(Player $player, Dealer $dealer, $name)
    {
        $PlayerScore = $player->getScore();
        $DealerScore = $dealer->getScore();

        if ($name === 'プレイヤー' && $PlayerScore > self::MATCH_POINT) {
            $this->displayResult($PlayerScore, $DealerScore, 'ディーラー');
            exit;
        } elseif ($name === 'ディーラー' && $DealerScore > self::MATCH_POINT) {
            $this->displayResult($PlayerScore, $DealerScore, 'プレイヤー');
            exit;
        }
    }

    public function displayResult(int $PlayerScore, int $DealerScore, string $winner): void
    {
        echo 'あなたの得点は' . $PlayerScore . 'です' . PHP_EOL;
        echo 'ディーラーの得点は'. $DealerScore . 'です' . PHP_EOL;
        echo $winner . 'の勝ちです！' . PHP_EOL;
        exit;
    }

    public function checkWinner(Player $player, Dealer $dealer): void
    {
        $PlayerDifference = self::MATCH_POINT - $player->getScore();
        $DealerDifference = self::MATCH_POINT - $dealer->getScore();

        echo 'あなたの現在の得点は' . $player->getScore() . 'です。' . PHP_EOL;
        echo 'ディーラーの現在の得点は' . $dealer->getScore() . 'です。' . PHP_EOL;

        if ($PlayerDifference < $DealerDifference) {
            echo '勝者はあなたです！' . PHP_EOL;
        } elseif ($DealerDifference < $PlayerDifference) {
            echo '勝者はディーラーです' . PHP_EOL;
        }

        echo 'ブラックジャックを終了します。' . PHP_EOL;
        exit;
    }

}
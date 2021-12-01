<?php
namespace BlackJack\lib;
require_once(__DIR__ . '/PlayerClass.php');
require_once(__DIR__ . '/DealerClass.php');

class HandEvaluator
{
    private const PLAYER_GAME_COUNT = 21;
    private const DEALER_GAME_COUNT = 17;
    private $PlayerScore = 0;
    private $DealerScore = 0;

    public function checkOver(Player $player, Dealer $dealer, $name)
    {
        $PlayerScore = $player->getScore();
        $DealerScore = $dealer->getScore();
        if ($name === 'プレイヤー' && $PlayerScore > self::PLAYER_GAME_COUNT) {
            $this->displayResult($PlayerScore, $DealerScore, 'ディーラー');
            exit;
        } elseif ($name === 'ディーラー' && $DealerScore > self::DEALER_GAME_COUNT) {
            $this->displayResult($DealerScore, $DealerScore, 'プレイヤー');
            exit;
        }
    }

    public function displayResult(int $PlayerScore, int $DealerScore, string $winner): void
    {
        echo 'あなたの得点は' . $PlayerScore . 'です' . PHP_EOL;
        echo 'ディーラーの得点は'. $DealerScore . 'です' . PHP_EOL;
        echo $winner . 'の勝ちです';
        exit;
    }

}
<?php
namespace BlackJack\lib;
require_once(__DIR__ . '/RuleInterface.php');

class ThreePlayerRule implements Rule
{
    private const MATCH_POINT = 21;

    public function checkOver(array $PlayerArr)
    {
        if ($PlayerArr[0]->getName() === 'player' && $PlayerArr[0]->getScore() > self::MATCH_POINT) {
            $this->displayResult($PlayerArr, 'ディーラー');
            exit;
        } elseif ($PlayerArr[1]->getName() === 'dealer' && $PlayerArr[1]->getScore() > self::MATCH_POINT) {
            $this->displayResult($PlayerArr, 'あなた');
            exit;
        }
    }

    public function checkWinner(array $PlayerArr)
    {

    }

    public function displayResult($PlayerArr, string $winner): void
    {
        foreach ($PlayerArr as $player) {
            echo $player->getName() . 'の得点は' . $player->getScore() . 'です' . PHP_EOL;
        }
        echo $winner . 'の勝ちです！' . PHP_EOL;
        exit;
    }
}
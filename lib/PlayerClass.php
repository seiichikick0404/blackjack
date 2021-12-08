<?php
namespace BlackJack\lib;

require_once(__DIR__ . '/UserInterface.php');
require_once(__DIR__ . '/CardClass.php');
require_once(__DIR__ . '/HandEvaluatorClass.php');

class Player implements UserInterface
{
    private const GAME_COUNT = 21;
    private $score = 0;
    private $name = 'player';

    public function firstDrawCards($player): array
    {
        $card = new Card();
        $card->randomTwoCard();
        $DrawCards = $card->getDrawCards();
        // スコアに加算
        if ($DrawCards[0]['prim'] === 'A' || $DrawCards[1]['prim'] === 'A') {
            $this->handleScore($player);
        } else {
            $this->score += $DrawCards[0]['rank']; 
            $this->score += $DrawCards[1]['rank'];
            // 配列にname追加
            $DrawCards['name'] = $this->name; 
        }

        return $DrawCards;
    }

    public function drawCards($player)
    {
        $card = new Card();
        $card->randomCard();
        $DrawCards = $card->getDrawCards();
        //スコアに加算
        if ($DrawCards[0]['prim'] === 'A') {
            $this->handleScore($player);
        } else {
            $this->score += $DrawCards[0]['rank']; 
            // 配列にname追加
            $DrawCards['name'] = $this->name; 
        }
        
        return $DrawCards;
    }

    public function handleDraw(string $input, int $score): bool
    {
        // 前後のスペース削除
        $select = trim($input, "\t\n\r\0\x0B");

        if ($select === 'Y' && $score <= self::GAME_COUNT) {
            return true;
        } else {
            return false;
        }
    }

    public function handleScore($player)
    {
        $MaxScore = $player->getScore() + 11;

        if ($MaxScore <= self::GAME_COUNT) {
            $this->score += 11;
        } else {
            $this->score += 1;
        }
    }

    public function getScore(): int
    {
        return $this->score;
    }
}
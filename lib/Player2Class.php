<?php
namespace BlackJack\lib;

require_once(__DIR__ . '/UserInterface.php');
require_once(__DIR__ . '/CardClass.php');
require_once(__DIR__ . '/HandEvaluatorClass.php');

class Player implements UserInterface 
{
    public function firstDrawCards($player): array
    {
        $card = new Card();
        $card->randomTwoCard();
        $DrawCards = $card->getDrawCards();
        // スコアに加算
        if ($DrawCards[0]['prim'] === 'A' || $DrawCards[1]['prim'] === 'A') {
            $this->handleScore($player, $DrawCards);
            $DrawCards['name'] = $this->name; 
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
            $this->handleScore($player, $DrawCards);
            $DrawCards['name'] = $this->name; 
        } else {
            $this->score += $DrawCards[0]['rank']; 
            // 配列にname追加
            $DrawCards['name'] = $this->name; 
        }
        
        return $DrawCards;
    }

    public function getScore(): int
    {
        return $this->score;
    }

}
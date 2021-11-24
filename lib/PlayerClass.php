<?php
namespace BlackJack\lib;

require_once(__DIR__ . '/UserInterface.php');
require_once(__DIR__ . '/CardClass.php');

class Player implements UserInterface
{
    private $score = 0;

    public function firstDrawCards(): array
    {
        $card = new Card();
        $card->randomTwoCard();
        $DrawCards = $card->getDrawCards();
        //スコアに加算
        $this->score += $DrawCards[0]['rank']; 
        $this->score += $DrawCards[1]['rank']; 

        return $DrawCards;
    }

    public function drawCards()
    {
        $card = new Card();
        $card->randomCard();
        $DrawCards = $card->getDrawCards();
        //スコアに加算
        $this->score += $DrawCards[0]['rank']; 
        
        return $DrawCards;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function handleDraw(string $select): void
    {
        if ($select === 'Y') {
            $this->drawCards();
        } elseif ($select === 'N') {
            // 何もしない
        }
    }
}
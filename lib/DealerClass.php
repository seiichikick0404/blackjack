<?php
namespace BlackJack\lib;

require_once(__DIR__ . '/UserInterface.php');
require_once(__DIR__ . '/CardClass.php');

class Dealer implements UserInterface
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
    }

    public function getScore(): int
    {
        return $this->score;
    }
}
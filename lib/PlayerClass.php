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

    public function handleDraw(string $input): bool
    {
        // 前後のスペース削除
        $select = trim($input, "\t\n\r\0\x0B");

        if ($select === 'Y') {
            return true;
        } else {
            return false;
        }
    }

    public function getScore(): int
    {
        return $this->score;
    }
}
<?php
namespace BlackJack\lib;

require_once(__DIR__ . '/UserInterface.php');
require_once(__DIR__ . '/CardClass.php');

class Dealer implements UserInterface
{
    private const GAME_COUNT = 17;
    private $score = 0;
    private $name = 'dealer';

    public function firstDrawCards(): array
    {
        $card = new Card();
        $card->randomTwoCard();
        $DrawCards = $card->getDrawCards();
        //スコアに加算
        $this->score += $DrawCards[0]['rank']; 
        $this->score += $DrawCards[1]['rank'];
        // 配列にname追加
        $DrawCards['name'] = $this->name; 

        return $DrawCards;
    }

    public function drawCards()
    {
        $card = new Card();
        $card->randomCard();
        $DrawCards = $card->getDrawCards();
        //スコアに加算
        $this->score += $DrawCards[0]['rank']; 
        // 配列にname追加
        $DrawCards['name'] = $this->name; 
        
        return $DrawCards;
    }

    public function  eachDrawCards(Dealer $dealer): void
    {
        while ($this->getScore() <= self::GAME_COUNT) {
            $card = new Card();
            $card->randomCard();
            $DrawCards = $card->getDrawCards();
            //スコアに加算
            $this->score += $DrawCards[0]['rank'];
            echo 'ディーラーの引いたカードは' . $DrawCards[0]['type'] . 'の' . $DrawCards[0]['prim'] . 'です' . PHP_EOL;
            echo 'ディーラーの現在の得点は' . $dealer->getScore() . 'です' . PHP_EOL;
        }
    }

    public function getScore(): int
    {
        return $this->score;
    }

    
}
<?php
namespace BlackJack\lib;

require_once(__DIR__ . '/UserInterface.php');
require_once(__DIR__ . '/CardClass.php');

class Dealer implements UserInterface
{
    private const GAME_COUNT = 17;
    private $score = 0;
    private $name = 'dealer';

    public function firstDrawCards($dealer): array
    {
        $card = new Card();
        $card->randomTwoCard();
        $DrawCards = $card->getDrawCards();
        // スコアに加算
        if ($DrawCards[0]['prim'] === 'A' || $DrawCards[1]['prim'] === 'A') {
            $this->handleScore($dealer, $DrawCards);
            $DrawCards['name'] = $this->name; 
        } else {
            $this->score += $DrawCards[0]['rank']; 
            $this->score += $DrawCards[1]['rank'];
            // 配列にname追加
            $DrawCards['name'] = $this->name; 
        }

        return $DrawCards;
    }

    public function drawCards($dealer)
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
            if ($DrawCards[0]['prim'] === 'A') {
                $this->handleScore($dealer, $DrawCards);
                $DrawCards['name'] = $this->name; 
            } else {
                $this->score += $DrawCards[0]['rank'];
                $DrawCards['name'] = $this->name; 
            }
            
            echo 'ディーラーの引いたカードは' . $DrawCards[0]['type'] . 'の' . $DrawCards[0]['prim'] . 'です' . PHP_EOL;
            echo 'ディーラーの現在の得点は' . $dealer->getScore() . 'です' . PHP_EOL;
        }
    }

    public function handleScore($dealer, $DrawCards)
    {
        $MaxScore = $dealer->getScore() + 11;
        $arrCount = count($DrawCards);


        if ($arrCount === 2) {
            #初回ドロー
            if ($DrawCards[0]['prim'] === 'A' && $DrawCards[1]['prim'] !== 'A') {
                $this->score += 11;
                $this->score += $DrawCards[1]['rank'];
            } elseif ($DrawCards[0]['prim'] !== 'A' && $DrawCards[1]['prim'] === 'A') {
                $this->score += 11;
                $this->score += $DrawCards[0]['rank'];
            } elseif ($DrawCards[0]['prim'] === 'A' && $DrawCards[1]['prim'] === 'A') {
                $this->score += 11;
                $this->score += $DrawCards[1]['rank'];
            } else {
                $this->score += $DrawCards[0]['rank'];
                $this->score += $DrawCards[1]['rank'];
            }
        } elseif ($arrCount === 1) {
            #通常ドロー
            $MaxScore = $dealer->getScore() + 11;
            if ($MaxScore <= self::GAME_COUNT) {
                $this->score += 11;
            } else {
                $this->score += 1;
            }
        }
    }

    public function getScore(): int
    {
        return $this->score;
    }
}

// 以下テスト
// $dealer = new Dealer();
// $DrawCards = $dealer->EachDrawCards($dealer);
// var_dump($dealer->getScore());
// exit;
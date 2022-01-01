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
        $drawCards = $card->getDrawCards();
        // スコアに加算
        if ($drawCards[0]['prim'] === 'A' || $drawCards[1]['prim'] === 'A') {
            $this->handleScore($dealer, $drawCards);
            $drawCards['name'] = $this->name;
        } elseif ($drawCards[0]['prim'] !== 'A' && $drawCards[1]['prim'] !== 'A') {
            $this->score += $drawCards[0]['rank'];
            $this->score += $drawCards[1]['rank'];
            // 配列にname追加
            $drawCards['name'] = $this->name;
        }

        return $drawCards;
    }

    public function drawCards($dealer): array
    {
        $card = new Card();
        $card->randomCard();
        $drawCards = $card->getDrawCards();
        //スコアに加算
        $this->score += $drawCards[0]['rank'];
        // 配列にname追加
        $drawCards['name'] = $this->name;

        return $drawCards;
    }

    public function eachDrawCards(UserInterface $dealer): void
    {
        while ($this->getScore() <= self::GAME_COUNT) {
            $card = new Card();
            $card->randomCard();
            $drawCards = $card->getDrawCards();
            //スコアに加算
            if ($drawCards[0]['prim'] === 'A') {
                $this->handleScore($dealer, $drawCards);
                $drawCards['name'] = $this->name;
            } elseif ($drawCards[0]['prim'] !== 'A') {
                $this->score += $drawCards[0]['rank'];
                $drawCards['name'] = $this->name;
            }

            echo 'ディーラーの引いたカードは' . $drawCards[0]['type'] . 'の' . $drawCards[0]['prim'] . 'です' . PHP_EOL;
            echo 'ディーラーの現在の得点は' . $dealer->getScore() . 'です' . PHP_EOL;
        }
    }

    public function handleScore($dealer, $drawCards): void
    {
        $maxScore = $dealer->getScore() + 11;
        $arrCount = count($drawCards);


        if ($arrCount === 2) {
            #初回ドロー
            if ($drawCards[0]['prim'] === 'A' && $drawCards[1]['prim'] !== 'A') {
                $this->score += 11;
                $this->score += $drawCards[1]['rank'];
            } elseif ($drawCards[0]['prim'] !== 'A' && $drawCards[1]['prim'] === 'A') {
                $this->score += 11;
                $this->score += $drawCards[0]['rank'];
            } elseif ($drawCards[0]['prim'] === 'A' && $drawCards[1]['prim'] === 'A') {
                $this->score += 11;
                $this->score += $drawCards[1]['rank'];
            } else {
                $this->score += $drawCards[0]['rank'];
                $this->score += $drawCards[1]['rank'];
            }
        } elseif ($arrCount === 1) {
            #通常ドロー
            $maxScore = $dealer->getScore() + 11;
            if ($maxScore <= self::GAME_COUNT) {
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

    public function getName()
    {
        return $this->name;
    }
}

<?php

namespace BlackJack\lib;

require_once(__DIR__ . '/UserInterface.php');
require_once(__DIR__ . '/CardClass.php');
require_once(__DIR__ . '/HandEvaluatorClass.php');

class Player2 implements UserInterface
{
    private const GAME_COUNT = 17;
    private $score = 0;
    private $name = 'player2';

    public function firstDrawCards($player): array
    {
        $card = new Card();
        $card->randomTwoCard();
        $drawCards = $card->getDrawCards();
        // スコアに加算
        if ($drawCards[0]['prim'] === 'A' || $drawCards[1]['prim'] === 'A') {
            $this->handleScore($player, $drawCards);
            $drawCards['name'] = $this->name;
        } else {
            $this->score += $drawCards[0]['rank'];
            $this->score += $drawCards[1]['rank'];
            // 配列にname追加
            $drawCards['name'] = $this->name;
        }

        return $drawCards;
    }

    public function drawCards($player): array
    {
        $card = new Card();
        $card->randomCard();
        $drawCards = $card->getDrawCards();
        //スコアに加算
        if ($drawCards[0]['prim'] === 'A') {
            $this->handleScore($player, $drawCards);
            $drawCards['name'] = $this->name;
        } else {
            $this->score += $drawCards[0]['rank'];
            // 配列にname追加
            $drawCards['name'] = $this->name;
        }

        return $drawCards;
    }

    public function eachDrawCards(UserInterface $player2): void
    {
        while ($this->getScore() <= self::GAME_COUNT) {
            $card = new Card();
            $card->randomCard();
            $drawCards = $card->getDrawCards();
            //スコアに加算
            if ($drawCards[0]['prim'] === 'A') {
                $this->handleScore($player2, $drawCards);
                $drawCards['name'] = $this->name;
            } else {
                $this->score += $drawCards[0]['rank'];
                $drawCards['name'] = $this->name;
            }

            echo 'プレイヤー2の引いたカードは' . $drawCards[0]['type'] . 'の' . $drawCards[0]['prim'] . 'です' . PHP_EOL;
            echo 'プレイヤー2の現在の得点は' . $player2->getScore() . 'です' . PHP_EOL;
        }
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

    public function handleScore($player, $drawCards): void
    {
        $maxScore = $player->getScore() + 11;
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
            $maxScore = $player->getScore() + 11;
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

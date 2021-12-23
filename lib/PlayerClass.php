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

    public function handleScore($player, $DrawCards)
    {
        $MaxScore = $player->getScore() + 11;
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
            $MaxScore = $player->getScore() + 11;
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

    public function getName()
    {
        return $this->name;
    }
}

// 以下テスト
// $player = new Player();
// $DrawCards = $player->drawCards($player);
// var_dump($DrawCards) . PHP_EOL;
// var_dump($player->getScore());
// exit;


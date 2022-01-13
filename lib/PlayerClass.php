<?php

namespace BlackJack\lib;

require_once(__DIR__ . '/UserInterface.php');
require_once(__DIR__ . '/PlayerInterface.php');
require_once(__DIR__ . '/CardClass.php');
require_once(__DIR__ . '/HandEvaluatorClass.php');

class Player implements PlayerInterface
{
    private const GAME_COUNT = 21;
    private $score = 0;
    private $name = 'player';

    /**
     * 初回ドロー
     * @param UserInterface $player
     * @return array $drawCards
     */
    public function firstDrawCards(UserInterface $player): array
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

    /**
     * 通常ドロー
     * @param UserInterface $player
     * @return array $drawCards
     */
    public function drawCards(UserInterface $player): array
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

    /**
     * ドローするか選択処理
     * @param string $input
     * @return bool
     */
    public function handleDraw(string $input): bool
    {
        // 前後のスペース削除
        $select = trim($input, "\t\n\r\0\x0B");

        if ($select === 'Y') {
            return true;
        } elseif ($select === 'N') {
            return false;
        }
    }

    /**
     * Aを引いた際の得点処理
     * @param UserInterface $player
     * @param array $drawCards
     * @return void
     */
    public function handleScore(UserInterface $player, $drawCards)
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

    /**
     * スコア取得
     * @return int $score
     */
    public function getScore(): int
    {
        return $this->score;
    }

    /**
     * 名前の取得
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }
}

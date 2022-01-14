<?php

namespace BlackJack\lib;

interface Rule
{
    /**
     * バースト判定処理
     * @param array $playerArr
     * @return void
     */
    public function checkOver(array $playerArr);

    /**
     * 勝者判定
     * @param $playerArr
     * @return void
     */
    public function checkWinner(array $playerArr);

    /**
     * 生き残ってるプレイヤーの配列を返す
     * @return array
     */
    public function getActivePlayers();

    /**
     * アクティブプレイヤーのセット
     * @param array $playerArr
     * @return void
     */
    public function setActivePlayers(array $playerArr);

    /**
     * バースト時の勝敗表示です
     * @param array $playerArr
     * @param string $winner
     * @return void
     */
    public function displayResult(array $playerArr, string $winner);

    /**
     * ドロー時のカード表示
     * @param array $drawCards
     * @return void
     */
    public function displayDrawCards(array $drawCards);
}

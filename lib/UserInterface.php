<?php

namespace BlackJack\lib;

interface UserInterface
{
    /**
     * 初回ドロー
     * @param UserInterface $user
     * @return array<int>
     */
    public function firstDrawCards(UserInterface $user): array;

    /**
     * 通常ドロー
     * @param UserInterface $user
     * @return array<int>
     */
    public function drawCards(UserInterface $user): array;

    /**
     * スコアの取得
     * @return int
     */
    public function getScore(): int;
}

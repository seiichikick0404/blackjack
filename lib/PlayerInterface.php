<?php

namespace BlackJack\lib;

require_once(__DIR__ . '/UserInterface.php');

interface PlayerInterface extends UserInterface
{
    /**
     * 通常ドロー
     * @param PlayerInterface $user
     * @return array<int>
     */
    public function drawCards(PlayerInterface $user): array;
}

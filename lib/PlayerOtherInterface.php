<?php

namespace BlackJack\lib;

require_once(__DIR__ . '/UserInterface.php');

interface PlayerOtherInterface extends UserInterface
{
    /**
     * 連続ドロー
     * @param PlayerOtherInterface $user
     * @return array<int>
     */
    public function eachDrawCards(UserInterface $user): void;
}

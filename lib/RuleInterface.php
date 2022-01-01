<?php

namespace BlackJack\lib;

interface Rule
{
    public function checkOver(array $playerArr);
    public function checkWinner(array $playerArr);
    public function getActivePlayers();
    public function setActivePlayers(array $playerArr);
    public function displayResult($playerArr, string $winner);
    public function displayDrawCards(array $drawCards);
}

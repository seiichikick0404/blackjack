<?php

namespace BlackJack\lib;

interface Rule
{
    public function checkOver(array $PlayerArr);
    public function checkWinner(array $PlayerArr);
    public function getActivePlayers();
    public function setActivePlayers(array $PlayerArr);
    public function displayResult($PlayerArr, string $winner);
    public function displayDrawCards(array $DrawCards);
}

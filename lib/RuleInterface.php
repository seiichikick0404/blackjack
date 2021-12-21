<?php
namespace BlackJack\lib;

interface Rule
{
    public function checkOver(array $PlayerArr);
    public function checkWinner(array $PlayerArr);
}
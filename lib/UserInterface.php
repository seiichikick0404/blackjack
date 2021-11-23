<?php
namespace BlackJack\lib;

interface UserInterface
{
    public function firstDrawCards();
    public function drawCards();
    public function getScore();
}
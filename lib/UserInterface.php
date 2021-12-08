<?php
namespace BlackJack\lib;

interface UserInterface
{
    public function firstDrawCards($user);
    public function drawCards($user);
    public function getScore();
}
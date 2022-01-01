<?php

namespace BlackJack\lib;

require_once(__DIR__ . '/PlayerClass.php');
require_once(__DIR__ . '/DealerClass.php');

class HandEvaluator
{
    private $rule = '';

    public function __construct($rule)
    {
        $this->rule = $rule;
    }

    public function checkOver(array $playerArr): void
    {
        $this->rule->checkOver($playerArr);
    }

    public function checkWinner(array $playerArr): void
    {
        $this->rule->checkWinner($playerArr);
    }
}

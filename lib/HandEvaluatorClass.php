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

    public function checkOver(array $PlayerArr): void
    {
        $this->rule->checkOver($PlayerArr);
    }

    public function checkWinner(array $PlayerArr): void
    {
        $this->rule->checkWinner($PlayerArr);
    }
}

<?php

namespace BlackJack\lib;

require_once(__DIR__ . '/PlayerClass.php');
require_once(__DIR__ . '/DealerClass.php');

class HandEvaluator
{
    private $rule = '';

    /**
     * ルールのセット
     * @param Rule $rule
     * @return void
     */
    public function __construct(Rule $rule)
    {
        $this->rule = $rule;
    }

    /**
     * バーストチェック
     * @param array $playerArr
     * @return void
     */
    public function checkOver(array $playerArr): void
    {
        $this->rule->checkOver($playerArr);
    }

    /**
     * 勝敗判定
     * @param array $playerArr
     * @return void
     */
    public function checkWinner(array $playerArr): void
    {
        $this->rule->checkWinner($playerArr);
    }
}

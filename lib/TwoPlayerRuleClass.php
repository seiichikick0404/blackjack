<?php

namespace BlackJack\lib;

require_once(__DIR__ . '/RuleInterface.php');

class TwoPlayerRule implements Rule
{
    private const MATCH_POINT = 21;
    private $ActivePlayers = [];

    public function checkOver(array $PlayerArr): void
    {
        #　アクティブプレイヤーをセット
        $this->setActivePlayers($PlayerArr);

        if ($PlayerArr[0]->getName() === 'player' && $PlayerArr[0]->getScore() > self::MATCH_POINT) {
            $this->displayResult($PlayerArr, 'ディーラー');
            exit;
        } elseif ($PlayerArr[1]->getName() === 'dealer' && $PlayerArr[1]->getScore() > self::MATCH_POINT) {
            $this->displayResult($PlayerArr, 'あなた');
            exit;
        }
    }

    public function checkWinner(array $PlayerArr): void
    {
        // 得点表示
        foreach ($PlayerArr as $player) {
            if ($player->getName() === 'player') {
                echo 'あなたの得点は' . $player->getScore() . 'です' . PHP_EOL;
            }
            if ($player->getName() === 'dealer') {
                echo 'ディーラーの得点は' . $player->getScore() . 'です' . PHP_EOL;
            }
        }
        $ScoreArr = [];
        // 差分を計算
        foreach ($PlayerArr as $player) {
            $diff = self::MATCH_POINT - $player->getScore();
            if ($player->getName() === 'player') {
                $ScoreArr['あなた'] = $diff;
            }
            if ($player->getName() === 'dealer') {
                $ScoreArr['ディーラー'] = $diff;
            }
        }

        $MinPlayers = array_keys($ScoreArr, min($ScoreArr));

        // 勝敗判定
        if (count($MinPlayers) === 1) {
            echo '勝者は' . $MinPlayers[0] . 'です！' . PHP_EOL;
        } elseif (count($MinPlayers) === 2) {
            echo 'この勝負引き分けです' . PHP_EOL;
        }
        exit;
    }

    public function displayResult($PlayerArr, string $winner): void
    {
        foreach ($PlayerArr as $player) {
            if ($player->getName() === 'player') {
                echo 'あなたの得点は' . $player->getScore() . 'です' . PHP_EOL;
            }
            if ($player->getName() === 'dealer') {
                echo 'ディーラーの得点は' . $player->getScore() . 'です' . PHP_EOL;
            }
        }
        echo $winner . 'の勝ちです！' . PHP_EOL;
        exit;
    }

    public function displayDrawCards(array $DrawCards): void
    {
        if (count($DrawCards) === 2 && $DrawCards['name'] === 'player') {
            #通常ドロー プレイヤー
            echo 'あなたの引いたカードは' . $DrawCards[0]['type'] . 'の' . $DrawCards[0]['prim'] . 'です' . PHP_EOL;
        } elseif (count($DrawCards) === 2 && $DrawCards['name'] === 'dealer') {
            #通常ドロー　ディーラー
            echo 'ディーラーの引いたカードは' . $DrawCards[0]['type'] . 'の' . $DrawCards[0]['prim'] . 'です' . PHP_EOL;
            echo 'ディーラーの引いた2枚目のカードは分かりません' . PHP_EOL;
        } elseif (count($DrawCards) === 3 && $DrawCards['name'] === 'player') {
            #初回ドロー　プレイヤー
            echo 'あなたの引いたカードは' . $DrawCards[0]['type'] . 'の' . $DrawCards[0]['prim'] . 'です' . PHP_EOL;
            echo 'あなたの引いた2枚目のカードは' . $DrawCards[1]['type'] . 'の' . $DrawCards[1]['prim'] . 'です' . PHP_EOL;
        } elseif (count($DrawCards) === 3 && $DrawCards['name'] === 'dealer') {
            #初回ドロー　ディーラー
            echo 'ディーラーの引いたカードは' . $DrawCards[0]['type'] . 'の' . $DrawCards[0]['prim'] . 'です' . PHP_EOL;
            echo 'ディーラーの引いた2枚目のカードは分かりません' . PHP_EOL;
        } else {
            echo '条件に当てはまりません。処理を終了します' . PHP_EOL;
            exit;
        }
    }

    public function getActivePlayers(): array
    {
        return $this->ActivePlayers;
    }

    public function setActivePlayers(array $PlayerArr): void
    {
        $this->ActivePlayers = $PlayerArr;
    }
}

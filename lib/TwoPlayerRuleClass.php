<?php

namespace BlackJack\lib;

require_once(__DIR__ . '/RuleInterface.php');

class TwoPlayerRule implements Rule
{
    private const MATCH_POINT = 21;
    private array $activePlayers = [];

    /**
     * バーストしたかをチェックします
     * @param array $playerArr
     * @return void
     */
    public function checkOver(array $playerArr): void
    {
        #　アクティブプレイヤーをセット
        $this->setActivePlayers($playerArr);

        if ($this->isPlayerBurst($playerArr)) {
            $this->displayResult($playerArr, 'ディーラー');
            exit;
        } elseif ($this->isDealerBurst($playerArr)) {
            $this->displayResult($playerArr, 'あなた');
            exit;
        }
    }

    /**
     * 勝敗を判定します
     * @param array $playerArr
     * @return void
     */
    public function checkWinner(array $playerArr): void
    {
        echo '----------------- 結果 --------------------' . PHP_EOL;

        // 得点表示
        foreach ($playerArr as $player) {
            if ($player->getName() === 'player') {
                echo 'あなたの得点は' . $player->getScore() . 'です' . PHP_EOL;
            }
            if ($player->getName() === 'dealer') {
                echo 'ディーラーの得点は' . $player->getScore() . 'です' . PHP_EOL;
            }
        }
        $scoreArr = [];
        // 差分を計算
        foreach ($playerArr as $player) {
            $diff = self::MATCH_POINT - $player->getScore();
            if ($player->getName() === 'player') {
                $scoreArr['あなた'] = $diff;
            }
            if ($player->getName() === 'dealer') {
                $scoreArr['ディーラー'] = $diff;
            }
        }

        $minPlayers = array_keys($scoreArr, min($scoreArr));

        // 勝敗判定
        if (count($minPlayers) === 1) {
            echo '勝者は' . $minPlayers[0] . 'です！' . PHP_EOL;
        } elseif (count($minPlayers) === 2) {
            echo 'この勝負引き分けです' . PHP_EOL;
        }
        exit;
    }

    /**
     * バースト時の勝敗表示です
     * @param array $playerArr
     * @param UserInterface $winner
     * @return void
     */
    public function displayResult(array $playerArr, string $winner): void
    {
        echo '----------------- 結果 --------------------' . PHP_EOL;

        foreach ($playerArr as $player) {
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

    /**
     * ドローしたカードの表示
     * @param array drawCards
     * @return void
     */
    public function displayDrawCards(array $drawCards): void
    {
        if (count($drawCards) === 2 && $drawCards['name'] === 'player') {
            #通常ドロー プレイヤー
            echo 'あなたの引いたカードは' . $drawCards[0]['type'] . 'の' . $drawCards[0]['prim'] . 'です' . PHP_EOL;
        } elseif (count($drawCards) === 2 && $drawCards['name'] === 'dealer') {
            #通常ドロー　ディーラー
            echo 'ディーラーの引いたカードは' . $drawCards[0]['type'] . 'の' . $drawCards[0]['prim'] . 'です' . PHP_EOL;
            echo 'ディーラーの引いた2枚目のカードは分かりません' . PHP_EOL;
        } elseif (count($drawCards) === 3 && $drawCards['name'] === 'player') {
            #初回ドロー　プレイヤー
            echo 'あなたの引いたカードは' . $drawCards[0]['type'] . 'の' . $drawCards[0]['prim'] . 'です' . PHP_EOL;
            echo 'あなたの引いた2枚目のカードは' . $drawCards[1]['type'] . 'の' . $drawCards[1]['prim'] . 'です' . PHP_EOL;
        } elseif (count($drawCards) === 3 && $drawCards['name'] === 'dealer') {
            #初回ドロー　ディーラー
            echo 'ディーラーの引いたカードは' . $drawCards[0]['type'] . 'の' . $drawCards[0]['prim'] . 'です' . PHP_EOL;
            echo 'ディーラーの引いた2枚目のカードは分かりません' . PHP_EOL;
        } else {
            echo '条件に当てはまりません。処理を終了します' . PHP_EOL;
            exit;
        }
    }

    /**
     * アクティブプレイヤー取得
     * @return array
     */
    public function getActivePlayers(): array
    {
        return $this->activePlayers;
    }

    /**
     * アクティブプレイヤーのセット
     * @param array $playerArr
     * @return void
     */
    public function setActivePlayers(array $playerArr): void
    {
        $this->activePlayers = $playerArr;
    }

    /**
     * プレイヤーがバーストしたか判定
     * @param array $playerArr
     * @return bool
     */
    public function isPlayerBurst(array $playerArr): bool
    {
        return $playerArr[0]->getName() === 'player' && $playerArr[0]->getScore() > self::MATCH_POINT;
    }

    /**
     * ディーラーがバーストしたか判定
     * @param array $playerArr
     * @return bool
     */
    public function isDealerBurst(array $playerArr): bool
    {
        return $playerArr[1]->getName() === 'dealer' && $playerArr[1]->getScore() > self::MATCH_POINT;
    }
}

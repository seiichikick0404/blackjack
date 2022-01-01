<?php

namespace BlackJack\lib;

require_once(__DIR__ . '/RuleInterface.php');

class ThreePlayerRule implements Rule
{
    private const MATCH_POINT = 21;
    private $ActivePlayers = [];
    private $DealerStatus = false;
    private $PlayerScore = '';
    private $Player2Score = '';
    private $DealerScore = '';

    /**
     * バーストしたかをチェックします
     * @param array
     * @return void
     */
    public function checkOver(array $playerArr): void
    {
        #　アクティブプレイヤーをセット
        $this->setActivePlayers($playerArr);

        # バースト処理
        foreach ($playerArr as $index => $player) {
            if ($player->getName() === 'player' && $player->getScore() > self::MATCH_POINT) {
                echo 'あなたはバーストしました' . PHP_EOL;
                // バーストしたプレイヤーを削除
                unset($this->ActivePlayers[$index]);
                $this->ActivePlayers = array_values($this->ActivePlayers);
            } elseif ($player->getName() === 'player2' && $player->getScore() > self::MATCH_POINT) {
                echo 'プレイヤー2はバーストしました' . PHP_EOL;
                // バーストしたプレイヤーを削除
                unset($this->ActivePlayers[$index]);
                $this->ActivePlayers = array_values($this->ActivePlayers);
            } elseif ($player->getName() === 'dealer' && $player->getScore() > self::MATCH_POINT) {
                echo 'ディーラーはバーストしました' . PHP_EOL;
                // バーストしたプレイヤーを削除
                unset($this->ActivePlayers[$index]);
                $this->ActivePlayers = array_values($this->ActivePlayers);
            }
        }
    }

     /**
     * 勝敗を判定します
     * @param array
     * @return void
     */
    public function checkWinner(array $playerArr): void
    {
        $scoreArr = [];

        // 得点表示と差分計算
        foreach ($playerArr as $player) {
            $diff = self::MATCH_POINT - $player->getScore();
            if ($player->getName() === 'player') {
                echo 'あなたの得点は' . $player->getScore() . 'です' . PHP_EOL;
                $scoreArr['あなた'] = $diff;
                $this->PlayerScore = $player->getScore();
            }
            if ($player->getName() === 'player2') {
                echo 'プレイヤー2の得点は' . $player->getScore() . 'です' . PHP_EOL;
                $scoreArr['プレイヤー2'] = $diff;
                $this->Player2Score = $player->getScore();
            }
            if ($player->getName() === 'dealer') {
                echo 'ディーラーの得点は' . $player->getScore() . 'です' . PHP_EOL;
                $scoreArr['ディーラー'] = $diff;
                $this->DealerScore = $player->getScore();
                $this->DealerStatus = true;
            }
        }

        // 全員バーストしたら終了
        if (count($playerArr) === 0) {
            echo '全員バーストしたので引き分けです' . PHP_EOL;
            exit;
        }

        if ($this->DealerStatus) {
            # ディーラーが存在した時
            if (count($playerArr) === 1) {
                echo 'ディーラーの勝利です' . PHP_EOL;
            } elseif (count($playerArr) === 2 && $playerArr[0]->getName() === 'player') {
                if ($playerArr[0]->getScore() > $this->DealerScore) {
                    echo 'あなたの勝利です' . PHP_EOL;
                } elseif ($playerArr[0]->getScore() < $this->DealerScore) {
                    echo 'ディーラーはあなたに勝利しました' . PHP_EOL;
                } elseif ($playerArr[0]->getScore() === $this->DealerScore) {
                    echo 'あなたとディーラーは引き分けです' . PHP_EOL;
                }
            } elseif (count($playerArr) === 2 && $playerArr[0]->getName() === 'player2') {
                if ($playerArr[0]->getScore() > $this->DealerScore) {
                    echo 'プレイヤー2の勝利です' . PHP_EOL;
                } elseif ($playerArr[0]->getScore() < $this->DealerScore) {
                    echo 'ディーラーはプレイヤー2に勝利しました' . PHP_EOL;
                } elseif ($playerArr[0]->getScore() === $this->DealerScore) {
                    echo 'プレイヤー2とディーラーは引き分けです' . PHP_EOL;
                }
            } elseif (count($playerArr) === 3) {
                $sliceArr = $playerArr;
                // ディーラー削除
                array_pop($sliceArr);

                foreach ($sliceArr as $player) {
                    if ($player->getName() === 'player') {
                        if ($player->getScore() > $this->DealerScore) {
                            echo 'あなたの勝利です' . PHP_EOL;
                        } elseif ($player->getScore() < $this->DealerScore) {
                            echo 'ディーラーはあなたに勝利しました' . PHP_EOL;
                        }
                    } elseif ($player->getName() === 'player2') {
                        if ($player->getScore() > $this->DealerScore) {
                            echo 'プレイヤー2の勝利です' . PHP_EOL;
                        } elseif ($player->getScore() < $this->DealerScore) {
                            echo 'ディーラーはプレイヤー2に勝利しました' . PHP_EOL;
                        }
                    }
                }
            }
        } elseif (!$this->DealerStatus) {
            # ディーラーが存在しない時
            foreach ($playerArr as $player) {
                if ($player->getName() === 'player') {
                    echo 'あなたは勝利しました' . PHP_EOL;
                } elseif ($player->getName() === 'player2') {
                    echo 'プレイヤー2は勝利しました' . PHP_EOL;
                }
            }
        }
        exit;
    }

    /**
     * バースト時の勝敗表示です
     * @param array
     * @param UserInterface $winner
     * @return void
     */
    public function displayResult($playerArr, string $winner): void
    {
        foreach ($playerArr as $player) {
            if ($player->getName() === 'player') {
                echo 'あなたの得点は' . $player->getScore() . 'です' . PHP_EOL;
            }
            if ($player->getName() === 'player2') {
                echo 'プレイヤー2の得点は' . $player->getScore() . 'です' . PHP_EOL;
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
     * @param array
     * @return void
     */
    public function displayDrawCards(array $drawCards): void
    {
        if (count($drawCards) === 2 && $drawCards['name'] === 'player') {
            #通常ドロー プレイヤー
            echo 'あなたの引いたカードは' . $drawCards[0]['type'] . 'の' . $drawCards[0]['prim'] . 'です' . PHP_EOL;
        } elseif (count($drawCards) === 2 && $drawCards['name'] === 'player2') {
            #通常ドロー　プレイヤー2
            echo 'プレイヤー2の引いたカードは' . $drawCards[0]['type'] . 'の' . $drawCards[0]['prim'] . 'です' . PHP_EOL;
        } elseif (count($drawCards) === 2 && $drawCards['name'] === 'dealer') {
            #通常ドロー　ディーラー
            echo 'ディーラーの引いたカードは' . $drawCards[0]['type'] . 'の' . $drawCards[0]['prim'] . 'です' . PHP_EOL;
            echo 'ディーラーの引いた2枚目のカードは分かりません' . PHP_EOL;
        } elseif (count($drawCards) === 3 && $drawCards['name'] === 'player') {
            #初回ドロー　プレイヤー
            echo 'あなたの引いたカードは' . $drawCards[0]['type'] . 'の' . $drawCards[0]['prim'] . 'です' . PHP_EOL;
            echo 'あなたの引いた2枚目のカードは' . $drawCards[1]['type'] . 'の' . $drawCards[1]['prim'] . 'です' . PHP_EOL;
        } elseif (count($drawCards) === 3 && $drawCards['name'] === 'player2') {
            #初回ドロー　プレイヤー2
            echo 'プレイヤー2の引いたカードは' . $drawCards[0]['type'] . 'の' . $drawCards[0]['prim'] . 'です' . PHP_EOL;
            echo 'プレイヤー2の引いた2枚目のカードは' . $drawCards[1]['type'] . 'の' . $drawCards[1]['prim'] . 'です' . PHP_EOL;
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
    public function getActivePlayers()
    {
        return $this->ActivePlayers;
    }

    /**
     * アクティブプレイヤーのセット
     * @param array
     * @return void
     */
    public function setActivePlayers(array $playerArr): void
    {
        $this->ActivePlayers = $playerArr;
    }
}

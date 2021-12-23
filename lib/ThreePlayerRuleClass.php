<?php
namespace BlackJack\lib;
require_once(__DIR__ . '/RuleInterface.php');

class ThreePlayerRule implements Rule
{
    private const MATCH_POINT = 21;
    private $ActivePlayers = [];
    

    public function checkOver(array $PlayerArr): void
    {
        # 前処理用インスタンス
        $PlayerSliceArr = $PlayerArr;

        # バースト処理1から考える
        # バーストしてないプレイヤーが処理を実行できるようにしたい

        // if ($PlayerArr[0]->getName() === 'player' && $PlayerArr[0]->getScore() > self::MATCH_POINT) {
        //     // バーストしたプレイヤーを削除
        //     echo 'あなたはバーストしました' . PHP_EOL;
        //     array_shift($PlayerSliceArr);
        //     $this->ActivePlayers = $PlayerSliceArr;
        //     // 他プレイヤー処理続行
        //     $this->doContinue($this->ActivePlayers, $PlayerArr);
        // } elseif ($PlayerArr[1]->getName() === 'player2' && $PlayerArr[1]->getScore() > self::MATCH_POINT) {
        //     // バーストしたプレイヤーを削除
        //     echo 'プレイヤー2はバーストしました' . PHP_EOL;
        //     if ($this->getActivePlayerInt === 2) {
        //         unset($PlayerSliceArr[0]);
        //         $PlayerSliceArr = array_values($PlayerSliceArr);
        //         $this->ActivePlayers = $PlayerSliceArr;
        //     } elseif ($this->getActivePlayerInt() === 3) {
        //         unset($PlayerSliceArr[1]);
        //         $PlayerSliceArr = array_values($PlayerSliceArr);
        //         $this->ActivePlayers = $PlayerSliceArr;
        //     }
        // } elseif ($PlayerArr[2]->getName() === 'dealer' && $PlayerArr[2]->getScore() > self::MATCH_POINT) {
        //     // バーストしたプレイヤーを削除
        //     echo 'ディーラーはバーストしました' . PHP_EOL;
        //     if ($this->getActivePlayerInt === 1) {
        //         unset($PlayerSliceArr[0]);
        //         $PlayerSliceArr = array_values($PlayerSliceArr);
        //         $this->ActivePlayers = $PlayerSliceArr;
        //     } elseif ($this->getActivePlayerInt() === 2) {
        //         unset($PlayerSliceArr[1]);
        //         $PlayerSliceArr = array_values($PlayerSliceArr);
        //         $this->ActivePlayers = $PlayerSliceArr;
        //     } elseif ($this->getActivePlayerInt() === 3) {
        //         unset($PlayerSliceArr[2]);
        //         $PlayerSliceArr = array_values($PlayerSliceArr);
        //         $this->ActivePlayers = $PlayerSliceArr;
        //     }
        // }
    }

    public function doContinue(array $ActivePlayers, array $PlayerArr) {
        foreach ($ActivePlayers as $player) {
            $player->eachDrawCards($player);
            #カードの判定
            $this->checkOver($PlayerArr);
        }
    }

    public function checkWinner(array $PlayerArr): void
    {
        // 得点表示
        foreach ($PlayerArr as $player) {
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
        $ScoreArr = [];
        // 差分を計算
        foreach ($PlayerArr as $player) {
            $diff = self::MATCH_POINT - $player->getScore();
            if ($player->getName() === 'player') {
                $ScoreArr['あなた'] = $diff;
            }
            if ($player->getName() === 'player2') {
                $ScoreArr['プレイヤー2'] = $diff;
            }
            if ($player->getName() === 'dealer') {
                $ScoreArr['ディーラー'] = $diff;
            }
        }
        
        $MinPlayers = array_keys($ScoreArr, min($ScoreArr));
        
        // 勝敗判定
        if (count($MinPlayers) === 1) {
            echo '勝者は' . $MinPlayers[0] . 'です！' . PHP_EOL;
        } elseif (count($MinPlayers) === 2 && $MinPlayers[0] !== 'dealer' || $MinPlayers[1] !== 'dealer') {
            echo '勝者は' . $MinPlayers[0] . 'と' . $MinPlayers[1] . 'です' . PHP_EOL;
        } elseif (count($MinPlayers) === 2 && $MinPlayers[0] === 'dealer' || $MinPlayers[1] === 'dealer') {
            echo $MinPlayers[0] . 'と' . $MinPlayers[1] . 'は引き分けです' . PHP_EOL;
        } elseif (count($MinPlayers) === 3) {
            echo 'この勝負引き分けです' . PHP_EOL;
        }
        exit;
    }

    public function getActivePlayerInt()
    {
        return count($this->ActivePlayers);
    }

    public function displayResult($PlayerArr, string $winner): void
    {
        foreach ($PlayerArr as $player) {
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

    public function displayDrawCards(array $DrawCards): void
    {
       if (count($DrawCards) === 2 && $DrawCards['name'] === 'player') {
            #通常ドロー プレイヤー
            echo 'あなたの引いたカードは' . $DrawCards[0]['type'] . 'の' . $DrawCards[0]['prim'] . 'です' . PHP_EOL;
        } elseif (count($DrawCards) === 2 && $DrawCards['name'] === 'player2') {
            #通常ドロー　プレイヤー2
            echo 'プレイヤー2の引いたカードは' . $DrawCards[0]['type'] . 'の' . $DrawCards[0]['prim'] . 'です' . PHP_EOL;
        } elseif (count($DrawCards) === 2 && $DrawCards['name'] === 'dealer') {
            #通常ドロー　ディーラー
            echo 'ディーラーの引いたカードは' . $DrawCards[0]['type'] . 'の' . $DrawCards[0]['prim'] . 'です' . PHP_EOL;
            echo 'ディーラーの引いた2枚目のカードは分かりません' . PHP_EOL;
        } elseif (count($DrawCards) === 3 && $DrawCards['name'] === 'player') {
            #初回ドロー　プレイヤー
            echo 'あなたの引いたカードは' . $DrawCards[0]['type'] . 'の' . $DrawCards[0]['prim'] . 'です' . PHP_EOL;
            echo 'あなたの引いた2枚目のカードは' . $DrawCards[1]['type'] . 'の' . $DrawCards[1]['prim'] . 'です' . PHP_EOL;
        } elseif (count($DrawCards) === 3 && $DrawCards['name'] === 'player2') {
            #初回ドロー　プレイヤー2
            echo 'プレイヤー2の引いたカードは' . $DrawCards[0]['type'] . 'の' . $DrawCards[0]['prim'] . 'です' . PHP_EOL;
            echo 'プレイヤー2の引いた2枚目のカードは' . $DrawCards[1]['type'] . 'の' . $DrawCards[1]['prim'] . 'です' . PHP_EOL;
        } elseif (count($DrawCards) === 3 && $DrawCards['name'] === 'dealer') {
            #初回ドロー　ディーラー
            echo 'ディーラーの引いたカードは' . $DrawCards[0]['type'] . 'の' . $DrawCards[0]['prim'] . 'です' . PHP_EOL;
            echo 'ディーラーの引いた2枚目のカードは分かりません' . PHP_EOL;
        } else {
            echo '条件に当てはまりません。処理を終了します' . PHP_EOL;
            exit;
        } 
    }
}
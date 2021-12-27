<?php
namespace BlackJack\lib;
require_once(__DIR__ . '/RuleInterface.php');

class ThreePlayerRule implements Rule
{
    private const MATCH_POINT = 21;
    private $ActivePlayers = [];
    private $DealerStatus = false;
    private $DealerScore = 0;
    

    public function checkOver(array $PlayerArr): void
    {
        #　アクティブプレイヤーをセット
        $this->setActivePlayers($PlayerArr);

        # バースト処理
        foreach ($PlayerArr as $index => $player) {
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

    public function checkWinner(array $PlayerArr): void
    {
        $ScoreArr = [];

        // 得点表示と差分計算
        foreach ($PlayerArr as $player) {
            $diff = self::MATCH_POINT - $player->getScore();
            if ($player->getName() === 'player') {
                echo 'あなたの得点は' . $player->getScore() . 'です' . PHP_EOL;
                $ScoreArr['あなた'] = $diff;
            }
            if ($player->getName() === 'player2') {
                echo 'プレイヤー2の得点は' . $player->getScore() . 'です' . PHP_EOL;
                $ScoreArr['プレイヤー2'] = $diff;
            }
            if ($player->getName() === 'dealer') {
                echo 'ディーラーの得点は' . $player->getScore() . 'です' . PHP_EOL;
                $ScoreArr['ディーラー'] = $diff;
            }
        }
        
        $MinPlayers = array_keys($ScoreArr, min($ScoreArr));
        
        
        if (count($MinPlayers) === 1) {
            echo '勝者は' . $MinPlayers[0] . 'です！' . PHP_EOL;
        } elseif (count($PlayerArr) === 2 && $MinPlayers[1] === 'dealer') {
            echo $MinPlayers[0] . 'と' . $MinPlayers[1] . 'は引き分けです';
        } elseif (count($PlayerArr) === 3) {

        }

        

        // if (count($MinPlayers) === 1) {
        //     echo '勝者は' . $MinPlayers[0] . 'です！' . PHP_EOL;
        // } elseif (count($MinPlayers) === 2 && $MinPlayers[1] === 'dealer') {
        //     echo $MinPlayers[0] . 'と' . $MinPlayers[1] . 'は引き分けです' . PHP_EOL;
        // } elseif (count($MinPlayers) === 2 && $MinPlayers[1] !== 'dealer') {
        //     echo '勝者は' . $MinPlayers[0] . 'と' . $MinPlayers[1] . 'です' . PHP_EOL;
        // } elseif (count($MinPlayers) === 3 && $PlayerArr[0]->getScore() === $PlayerArr[1]->getScore()) {
        //     echo '勝者は' . $MinPlayers[0] . 'と' . $MinPlayers[1] . 'です' . PHP_EOL;
        // } else {
        //     echo '全員バーストしたので引き分けです' . PHP_EOL;
        // }

        
         

        // if (count($MinPlayers) === 1) {
        //     echo '勝者は' . $MinPlayers[0] . 'です！' . PHP_EOL;
        // } elseif (count($MinPlayers) === 2 && $MinPlayers[0] !== 'dealer' || $MinPlayers[1] !== 'dealer') {
        //     echo '勝者は' . $MinPlayers[0] . 'と' . $MinPlayers[1] . 'です' . PHP_EOL;
        // } elseif (count($MinPlayers) === 2 && $MinPlayers[0] === 'dealer' || $MinPlayers[1] === 'dealer') {
        //     echo $MinPlayers[0] . 'と' . $MinPlayers[1] . 'は引き分けです' . PHP_EOL;
        // } elseif (count($MinPlayers) === 3) {
        //     echo 'この勝負引き分けです' . PHP_EOL;
        // } else {
        //     echo '全員バーストしたので引き分けです' . PHP_EOL;
        // }
        exit;
    }

    public function getActivePlayers()
    {
        return $this->ActivePlayers;
    }

    public function setActivePlayers(array $PlayerArr): void
    {
        $this->ActivePlayers = $PlayerArr;
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
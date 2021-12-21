<?php
namespace BlackJack\lib;

require_once(__DIR__ . '/PlayerClass.php');
require_once(__DIR__ . '/Player2Class.php');
require_once(__DIR__ . '/DealerClass.php');
require_once(__DIR__ . '/HandEvaluatorClass.php');
require_once(__DIR__ . '/TwoPlayerRuleClass.php');
require_once(__DIR__ . '/ThreePlayerRuleClass.php');

class Game
{
    private $PlayerInt = 1;

    public function __construct($players)
    {
        $this->PlayerInt = $players;
    }

    public function startGame()
    {
        # インスタンス生成
        $PlayerArr = $this->getPlayers();
        # 前処理用インスタンス
        $PlayerSliceArr = $PlayerArr;
        # ルールセット
        $rule = $this->getRule();
        
        echo 'ブラックジャックを開始します' . PHP_EOL;

        #初回ドロー
        foreach($PlayerArr as $player) {
            $PlayerFirstDrawCards = $player->firstDrawCards($player);
            $this->displayCards($PlayerFirstDrawCards);
        }
        
        // カードを引くか判定
        while (true) {
            $input = $this->displayHandleDraw($PlayerArr[0]);

            if ($PlayerArr[0]->handleDraw($input, $PlayerArr[0]->getScore())) {
                $PlayerDrawCards = $PlayerArr[0]->drawCards($PlayerArr[0]);
                $this->displayCards($PlayerDrawCards);
                #カードの判定
                $PlayerCheckHand = new HandEvaluator($rule);
                $PlayerCheckHand->checkOver($PlayerArr);
                
            } elseif ($PlayerArr[0]->handleDraw($input, $PlayerArr[0]->getScore()) === false) {
                array_shift($PlayerSliceArr);
                foreach ($PlayerSliceArr as $player) {
                    $player->eachDrawCards($player);
                    #カードの判定
                    $PlayerCheckHand = new HandEvaluator($rule);
                    $PlayerCheckHand->checkOver($PlayerArr);
                }
                break;
            }
        }
        
        // 結果判定処理
        $resulut = new HandEvaluator($rule);
        $resulut->checkWinner($PlayerArr);
        exit;    
    }

    public function displayCards(array $drawCards): void
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
    
    public function displayHandleDraw(Player $player): string
    {
        echo 'あなたの現在の得点は' . $player->getScore() . 'です。カードを引きますか？（Y/N）' . PHP_EOL;
        $input = fgets(STDIN);
        return $input;
    }

    public function getPlayers()
    {
        if ($this->PlayerInt === 1) {
            $player = new Player();
            $dealer = new Dealer();
            return [$player, $dealer];
        } elseif ($this->PlayerInt === 2) {
            $player = new Player();
            $player2 = new Player2();
            $dealer = new Dealer();
            return [$player, $player2, $dealer];
        }
    }

    public function getRule()
    {
        if ($this->PlayerInt === 1) {
            $rule = new TwoPlayerRule();
        } elseif ($this->PlayerInt === 2) {
            $rule = new ThreePlayerRule();
        }

        return $rule;
    }
}



$game = new Game(1);
$game->startGame();
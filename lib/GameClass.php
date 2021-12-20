<?php
namespace BlackJack\lib;

require_once(__DIR__ . '/PlayerClass.php');
require_once(__DIR__ . '/Player2Class.php');
require_once(__DIR__ . '/DealerClass.php');
require_once(__DIR__ . '/HandEvaluatorClass.php');

class Game
{
    private $PlayerInt = 1;

    public function __construct($players)
    {
        $this->PlayerInt = $players;
    }

    public function startGame()
    {
        // $player = new Player();
        // $player2 = new Player2();
        $dealer = new Dealer();

        # 人数に応じてインスタンス生成
        $PlayerArr = $this->getPlayers();
        
        echo 'ブラックジャックを開始します' . PHP_EOL;

        #初回ドロー
        foreach($PlayerArr as $player) {
            $PlayerFirstDrawCards = $player->firstDrawCards($player);
            $this->displayCards($PlayerFirstDrawCards);
        }
        

        exit;

        // 最初のドロー　プレイヤー
        // $PlayerFirstDrawCards = $player->firstDrawCards($player);
        // $this->displayCards($PlayerFirstDrawCards);
        // // 最初のドロー　プレイヤー2
        // $Player2FirstDrawCards = $player2->firstDrawCards($player2);
        // $this->displayCards($Player2FirstDrawCards);
        // // 最初のドロー　NPC
        // $DealerFirstDrawCards = $dealer->firstDrawCards($dealer);
        // $this->displayCards($DealerFirstDrawCards);

        
        // カードを引くか判定
        while (true) {
            $input = $this->displayHandleDraw($player);

            if ($player->handleDraw($input, $player->getScore())) {
                $PlayerDrawCards = $player->drawCards($player);
                $this->displayCards($PlayerDrawCards);
                #カードの判定
                $PlayerCheckHand = new HandEvaluator();
                $PlayerCheckHand->checkOver($player, $player2, $dealer, 'プレイヤー');
            } elseif ($player->handleDraw($input, $player->getScore()) === false) {
                #プレイヤー2の処理
                $player2->eachDrawCards($player2);
                #カードの判定
                $Player2CheckHand = new HandEvaluator();
                $Player2CheckHand->checkOver($player, $player2, $dealer, 'プレイヤー2');

                # ディーラーの処理
                echo 'ディーラーの引いた2枚目のカードは' . $DealerFirstDrawCards[1]['type'] . 'の' . $DealerFirstDrawCards[1]['prim'] . 'でした。' . PHP_EOL;
                $dealer->eachDrawCards($dealer);
                #カードの判定
                $DealerCheckHand = new HandEvaluator();
                $DealerCheckHand->checkOver($player, $player2, $dealer, 'ディーラー');
                break;
            }
        }
        // 結果判定処理
        $resulut = new HandEvaluator();
        $resulut->checkWinner($player, $player2, $dealer);
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
}



$game = new Game(2);
$game->startGame();
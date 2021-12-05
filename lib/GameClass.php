<?php
namespace BlackJack\lib;

require_once(__DIR__ . '/PlayerClass.php');
require_once(__DIR__ . '/DealerClass.php');
require_once(__DIR__ . '/HandEvaluatorClass.php');

class Game
{
    public function startGame()
    {
        echo 'ブラックジャックを開始します' . PHP_EOL;

        $player = new Player();
        $dealer = new Dealer();
        // 最初のドロー　プレイヤー
        $PlayerFirstDrawCards = $player->firstDrawCards();
        $this->displayCards($PlayerFirstDrawCards);
        // 最初のドロー　NPC
        $DealerFirstDrawCards = $dealer->firstDrawCards();
        $this->displayCards($DealerFirstDrawCards);
        
        // カードを引くか判定
        while (true) {
            $input = $this->displayHandleDraw($player);

            if ($player->handleDraw($input, $player->getScore())) {
                $PlayerDrawCards = $player->drawCards();
                $this->displayCards($PlayerDrawCards);
                #カードの判定
                $PlayerCheckHand = new HandEvaluator();
                $PlayerCheckHand->checkOver($player, $dealer, 'プレイヤー');
            } else {
                echo 'ディーラーの引いた2枚目のカードは' . $DealerFirstDrawCards[1]['type'] . 'の' . $DealerFirstDrawCards[1]['prim'] . 'でした。' . PHP_EOL;
                $dealer->eachDrawCards();
                #カードの判定
                $DealerCheckHand = new HandEvaluator();
                $DealerCheckHand->checkOver($player, $dealer, 'ディーラー');
            }
        }

        $resulut = new HandEvaluator();
        $resulut->checkWinner($player, $dealer);
        exit;
    }

    public function displayCards(array $drawCards): void
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
            echo 'あなたの引いたカードは' . $drawCards[1]['type'] . 'の' . $drawCards[1]['prim'] . 'です' . PHP_EOL;
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
    
}

$game = new Game();
$game->startGame();
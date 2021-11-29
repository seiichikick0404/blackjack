<?php
namespace BlackJack\lib;

require_once(__DIR__ . '/PlayerClass.php');
require_once(__DIR__ . '/DealerClass.php');

class Game
{
    public function startGame()
    {
        echo 'ブラックジャックを開始します' . PHP_EOL;

        $player = new Player();
        $dealer = new Dealer();

        $PlayerFirstDrawCards = $player->firstDrawCards();
        $this->displayCards($PlayerFirstDrawCards);

        $DealerFirstDrawCards = $dealer->firstDrawCards();
        $this->displayCards($DealerFirstDrawCards);
        echo 'あなたの現在の得点は' . $player->getScore() . 'です。カードを引きますか？（Y/N）' . PHP_EOL;
        
        $input = fgets(STDIN);
        // カードを引くか判定
        if ($player->handleDraw($input)) {
            $PlayerDrawCards = $player->drawCards();

            echo 'あなたの引いたカードは' . $PlayerDrawCards[0]['type'] . 'の' . $PlayerDrawCards[0]['prim'] . 'です' . PHP_EOL;
        } else {

        }
        
        echo 'あなたの現在の得点は' . $player->getScore() . 'です。カードを引きますか？（Y/N）' . PHP_EOL;
    }

    public function displayCards(array $drawCards): void
    {
        if (count($drawCards) === 2 && $drawCards['name'] === 'player') {
            #通常ドロー プレイヤー
            echo 'プレイヤーの引いたカードは' . $drawCards[0]['type'] . 'の' . $drawCards[0]['prim'] . 'です' . PHP_EOL;
        } elseif (count($drawCards) === 2 && $drawCards['name'] === 'dealer') {
            #通常ドロー　ディーラー
            echo 'ディーラーの引いたカードは' . $drawCards[0]['type'] . 'の' . $drawCards[0]['prim'] . 'です' . PHP_EOL;
            echo 'ディーラーの引いた2枚目のカードは分かりません' . PHP_EOL;
        } elseif (count($drawCards) === 3 && $drawCards['name'] === 'player') {
            #初回ドロー　プレイヤー
            echo 'プレイヤーの引いたカードは' . $drawCards[0]['type'] . 'の' . $drawCards[0]['prim'] . 'です' . PHP_EOL;
            echo 'プレイヤーの引いたカードは' . $drawCards[1]['type'] . 'の' . $drawCards[1]['prim'] . 'です' . PHP_EOL;
        } elseif (count($drawCards) === 3 && $drawCards['name'] === 'dealer') {
            #初回ドロー　ディーラー
            echo 'ディーラーの引いたカードは' . $drawCards[0]['type'] . 'の' . $drawCards[0]['prim'] . 'です' . PHP_EOL;
            echo 'ディーラーの引いた2枚目のカードは分かりません' . PHP_EOL;
        } else {
            echo '条件に当てはまりません。処理を終了します' . PHP_EOL;
            exit;
        }
    }

    
    
}

$game = new Game();
$game->startGame();
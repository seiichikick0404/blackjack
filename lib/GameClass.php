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
        echo 'あなたの引いたカードは' . $PlayerFirstDrawCards[0]['type'] . 'の' . $PlayerFirstDrawCards[0]['prim'] . 'です' . PHP_EOL;
        echo 'あなたの引いたカードは' . $PlayerFirstDrawCards[1]['type'] . 'の' . $PlayerFirstDrawCards[1]['prim'] . 'です' . PHP_EOL;

        $DealerFirstDrawCards = $dealer->firstDrawCards();
        echo 'ディーラーの引いたカードは' . $DealerFirstDrawCards[0]['type'] . 'の' . $DealerFirstDrawCards[0]['prim'] . 'です' . PHP_EOL;
        echo 'ディーラーの引いた2枚目のカードは分かりません' . PHP_EOL;
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

    
    
}

$game = new Game();
$game->startGame();
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
        // 空白削除を対応
        $input = fgets(STDIN);
        $select = str_replace("\r\n", '', $input);
        var_dump($select);
        // ここまで
        $this->handleDraw($select, $player);
        echo 'あなたの現在の得点は' . $player->getScore() . 'です。カードを引きますか？（Y/N）' . PHP_EOL;
    }

    public function handleDraw(string $select, Player $player): void
    {
        $select = 'Y';
        var_dump($select);
        exit;
        if ($select === 'Y') {
            echo 'Yの場合';
            exit;
            $player->drawCards();
        } else {
            echo 'Nの場合';
            exit;
        }
    }
    
}

$game = new Game();
$game->startGame();
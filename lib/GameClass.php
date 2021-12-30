<?php

namespace BlackJack\lib;

require_once(__DIR__ . '/PlayerClass.php');
require_once(__DIR__ . '/Player2Class.php');
require_once(__DIR__ . '/DealerClass.php');
require_once(__DIR__ . '/HandEvaluatorClass.php');
require_once(__DIR__ . '/RuleInterface.php');
require_once(__DIR__ . '/TwoPlayerRuleClass.php');
require_once(__DIR__ . '/ThreePlayerRuleClass.php');

class Game
{
    private $PlayerInt = 1;
    private $ActivePlayers = [];

    public function __construct($players)
    {
        $this->PlayerInt = $players;
    }

    public function startGame()
    {
        # インスタンス生成
        $PlayerArr = $this->setPlayers();
        # ルール取得
        $rule = $this->getRule();

        echo 'ブラックジャックを開始します' . PHP_EOL;

        #初回ドロー
        foreach ($PlayerArr as $player) {
            $PlayerFirstDrawCards = $player->firstDrawCards($player);
            $this->displayCards($PlayerFirstDrawCards, $rule);
        }

        // カードを引くか判定
        while (true) {
            $input = $this->displayHandleDraw($PlayerArr[0]);

            if ($PlayerArr[0]->handleDraw($input) && $this->ActivePlayers[0]->getName() === 'player') {
                $PlayerDrawCards = $PlayerArr[0]->drawCards($PlayerArr[0]);
                $this->displayCards($PlayerDrawCards, $rule);
                #カードの判定
                $PlayerCheckHand = new HandEvaluator($rule);
                $PlayerCheckHand->checkOver($PlayerArr);
                # アクティブプレイヤー更新
                $this->updateActivePlayers($rule);
            } elseif ($PlayerArr[0]->handleDraw($input) === false || $this->ActivePlayers[0]->getName() !== 'player') {
                if ($this->ActivePlayers[0]->getName() === 'player') {
                    # 配列からプレイヤーを削除
                    $PlayerSliceArr = $this->ActivePlayers;
                    array_shift($PlayerSliceArr);
                    $players = $PlayerSliceArr;
                } else {
                    $players = $this->ActivePlayers;
                }

                foreach ($players as $player) {
                    $player->eachDrawCards($player);
                    #カードの判定
                    $PlayerCheckHand = new HandEvaluator($rule);
                    $PlayerCheckHand->checkOver($this->ActivePlayers);
                    $this->updateActivePlayers($rule);
                }
                break;
            }
        }

        // 結果判定処理
        $resulut = new HandEvaluator($rule);
        $resulut->checkWinner($this->ActivePlayers);
        exit;
    }

    public function displayCards(array $DrawCards, $rule): void
    {
        $rule->displayDrawCards($DrawCards);
    }

    public function displayHandleDraw(Player $player): string
    {
        if ($this->ActivePlayers[0]->getName() === 'player') {
            echo 'あなたの現在の得点は' . $player->getScore() . 'です。カードを引きますか？（Y/N）' . PHP_EOL;
            $input = fgets(STDIN);
            // 前後のスペース削除
            $input = trim($input, "\t\n\r\0\x0B");
            return $input;
        } elseif ($this->ActivePlayers[0]->getName() !== 'player') {
            return 'N';
        } else {
            $input = fgets(STDIN);
            // 前後のスペース削除
            $input = trim($input, "\t\n\r\0\x0B");
            return $input;
        }
    }

    public function updateActivePlayers($rule): void
    {
        $this->ActivePlayers = $rule->getActivePlayers();
    }

    public function setPlayers(): array
    {
        if ($this->PlayerInt === 1) {
            $player = new Player();
            $dealer = new Dealer();
            $this->ActivePlayers = [$player, $dealer];
            return [$player, $dealer];
        } elseif ($this->PlayerInt === 2) {
            $player = new Player();
            $player2 = new Player2();
            $dealer = new Dealer();
            $this->ActivePlayers = [$player, $player2, $dealer];
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



$game = new Game(2);
$game->startGame();

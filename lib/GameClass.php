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
    private int $PlayerInt = 1;
    private array $ActivePlayers = [];

    public function __construct($players)
    {
        $this->PlayerInt = $players;
    }

    /**
     * ブラックジャック実行
     * @return void
     */
    public function startGame(): void
    {
        # インスタンス生成
        $playerArr = $this->setPlayers();
        # ルール取得
        $rule = $this->getRule();
        $playerCheckHand = new HandEvaluator($rule);

        echo 'ブラックジャックを開始します' . PHP_EOL;

        #初回ドロー
        $this->firstDraw($playerArr, $rule);

        // カードを引くか判定
        while (true) {
            $input = $this->displayHandleDraw($playerArr[0]);

            if ($this->isHandleDraw($playerArr[0], $input)) {
                $playerDrawCards = $playerArr[0]->drawCards($playerArr[0]);
                $this->displayCards($playerDrawCards, $rule);
                # バースト判定判定
                $playerCheckHand->checkOver($playerArr);
                # アクティブプレイヤー更新
                $this->updateActivePlayers($rule);
            } elseif (!$this->isHandleDraw($playerArr[0], $input)) {
                # プレイヤー以外の動作実行
                $players = $this->getPlayerSliceArr($this->ActivePlayers);

                foreach ($players as $player) {
                    $player->eachDrawCards($player);
                    #カードの判定
                    $playerCheckHand->checkOver($this->ActivePlayers);
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

    /**
     * 初回ドロー
     * @param array $playerArr
     * @param Rule $rule
     * @return void
     */
    public function firstDraw($playerArr, $rule): void
    {
        foreach ($playerArr as $player) {
            $playerFirstDrawCards = $player->firstDrawCards($player);
            $this->displayCards($playerFirstDrawCards, $rule);
        }
    }

    /**
     * 引いた手札の表示
     * @param array $drawCards
     * @param Rule $rule
     * @return void
     */
    public function displayCards(array $drawCards, Rule $rule): void
    {
        $rule->displayDrawCards($drawCards);
    }

    /**
     * ドロー選択画面の表示
     * @param Player $player
     * @return string $input
     */
    public function displayHandleDraw(Player $player): string
    {
        if ($this->ActivePlayers[0]->getName() === 'player') {
            echo 'あなたの現在の得点は' . $player->getScore() . 'です。カードを引きますか？（Y/N）' . PHP_EOL;
            $input = fgets(STDIN);
            return $input;
        } elseif ($this->ActivePlayers[0]->getName() !== 'player') {
            return 'N';
        } else {
            $input = fgets(STDIN);
            return $input;
        }
    }

    /**
     * プレイヤー以外の参加者インスタンス配列を返す
     * @param array $activePlayers
     * @return array $players
     */
    public function getPlayerSliceArr(array $activePlayers): array
    {
        if ($this->ActivePlayers[0]->getName() === 'player') {
            # 配列からプレイヤーを削除
            $playerSliceArr = $this->ActivePlayers;
            array_shift($playerSliceArr);
            $players = $playerSliceArr;
        } else {
            $players = $this->ActivePlayers;
        }

        return $players;
    }

    /**
     * カードを引くか引かないかの判定
     * @param Player $player
     * @param string $input
     * @return bool
     */
    public function isHandleDraw(Player $player, string $input): bool
    {
        if ($player->handleDraw($input) && $this->ActivePlayers[0]->getName() === 'player') {
            return true;
        } elseif ($player->handleDraw($input) === false || $this->ActivePlayers[0]->getName() !== 'player') {
            return false;
        }
    }

    /**
     * アクティブプレイヤーの更新
     * @param Rule $rule
     * @return void
     */
    public function updateActivePlayers(Rule $rule): void
    {
        $this->ActivePlayers = $rule->getActivePlayers();
    }

    /**
     * 参加プレイヤーのセット
     * @return array
     */
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

    /**
     * ルール取得
     * @return Rule $rule
     */
    public function getRule(): object
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

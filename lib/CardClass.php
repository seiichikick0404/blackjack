<?php

namespace BlackJack\lib;

require_once(__DIR__ . '/PlayerClass.php');
require_once(__DIR__ . '/DealerClass.php');

class Card
{
    const CARD_RANKS = [
        [
            'prim' => '2',
            'rank' => 2,
            'type' => 'ハート'
        ],
        [   'prim' => '3',
            'rank' => 3,
            'type' => 'ハート'
        ],
        [
            'prim' => '4',
            'rank' => 4,
            'type' => 'ハート'
        ],
        [
            'prim' => '5',
            'rank' => '5',
            'type' => 'ハート'
        ],
        [
            'prim' => '6',
            'rank' => 6,
            'type' => 'ハート'
        ],
        [
            'prim' => '7',
            'rank' => 7,
            'type' => 'ハート'
        ],
        [
            'prim' => '8',
            'rank' => 8,
            'type' => 'ハート'
        ],
        [
            'prim' => '9',
            'rank' => 9,
            'type' => 'ハート'
        ],
        [
            'prim' => '10',
            'rank' => 10,
            'type' => 'ハート'
        ],
        [
            'prim' => 'J',
            'rank' => 10,
            'type' => 'ハート'
        ],
        [
            'prim' => 'Q',
            'rank' => 10,
            'type' => 'ハート'
        ],
        [
            'prim' => 'K',
            'rank' => 10,
            'type' => 'ハート'
        ],
        [
            'prim' => 'A',
            'rank' => 1,
            'type' => 'ハート'
        ],
        [
            'prim' => '2',
            'rank' => 2,
            'type' => 'ダイヤ'
        ],
        [   'prim' => '3',
            'rank' => 3,
            'type' => 'ダイヤ'
        ],
        [
            'prim' => '4',
            'rank' => 4,
            'type' => 'ダイヤ'
        ],
        [
            'prim' => '5',
            'rank' => '5',
            'type' => 'ダイヤ'
        ],
        [
            'prim' => '6',
            'rank' => 6,
            'type' => 'ダイヤ'
        ],
        [
            'prim' => '7',
            'rank' => 7,
            'type' => 'ダイヤ'
        ],
        [
            'prim' => '8',
            'rank' => 8,
            'type' => 'ダイヤ'
        ],
        [
            'prim' => '9',
            'rank' => 9,
            'type' => 'ダイヤ'
        ],
        [
            'prim' => '10',
            'rank' => 10,
            'type' => 'ダイヤ'
        ],
        [
            'prim' => 'J',
            'rank' => 10,
            'type' => 'ダイヤ'
        ],
        [
            'prim' => 'Q',
            'rank' => 10,
            'type' => 'ダイヤ'
        ],
        [
            'prim' => 'K',
            'rank' => 10,
            'type' => 'ダイヤ'
        ],
        [
            'prim' => 'A',
            'rank' => 1,
            'type' => 'ダイヤ'
        ],
        [
            'prim' => '2',
            'rank' => 2,
            'type' => 'スペード'
        ],
        [   'prim' => '3',
            'rank' => 3,
            'type' => 'スペード'
        ],
        [
            'prim' => '4',
            'rank' => 4,
            'type' => 'スペード'
        ],
        [
            'prim' => '5',
            'rank' => '5',
            'type' => 'スペード'
        ],
        [
            'prim' => '6',
            'rank' => 6,
            'type' => 'スペード'
        ],
        [
            'prim' => '7',
            'rank' => 7,
            'type' => 'スペード'
        ],
        [
            'prim' => '8',
            'rank' => 8,
            'type' => 'スペード'
        ],
        [
            'prim' => '9',
            'rank' => 9,
            'type' => 'スペード'
        ],
        [
            'prim' => '10',
            'rank' => 10,
            'type' => 'スペード'
        ],
        [
            'prim' => 'J',
            'rank' => 10,
            'type' => 'スペード'
        ],
        [
            'prim' => 'Q',
            'rank' => 10,
            'type' => 'スペード'
        ],
        [
            'prim' => 'K',
            'rank' => 10,
            'type' => 'スペード'
        ],
        [
            'prim' => 'A',
            'rank' => 1,
            'type' => 'スペード'
        ],
        [
            'prim' => '2',
            'rank' => 2,
            'type' => 'クラブ'
        ],
        [   'prim' => '3',
            'rank' => 3,
            'type' => 'クラブ'
        ],
        [
            'prim' => '4',
            'rank' => 4,
            'type' => 'クラブ'
        ],
        [
            'prim' => '5',
            'rank' => '5',
            'type' => 'クラブ'
        ],
        [
            'prim' => '6',
            'rank' => 6,
            'type' => 'クラブ'
        ],
        [
            'prim' => '7',
            'rank' => 7,
            'type' => 'クラブ'
        ],
        [
            'prim' => '8',
            'rank' => 8,
            'type' => 'クラブ'
        ],
        [
            'prim' => '9',
            'rank' => 9,
            'type' => 'クラブ'
        ],
        [
            'prim' => '10',
            'rank' => 10,
            'type' => 'クラブ'
        ],
        [
            'prim' => 'J',
            'rank' => 10,
            'type' => 'クラブ'
        ],
        [
            'prim' => 'Q',
            'rank' => 10,
            'type' => 'クラブ'
        ],
        [
            'prim' => 'K',
            'rank' => 10,
            'type' => 'クラブ'
        ],
        [
            'prim' => 'A',
            'rank' => 1,
            'type' => 'クラブ'
        ]
    ];

    private $CardArr = [];


    public function randomTwoCard(): void
    {
        $ArrayKey = (array_rand(self::CARD_RANKS, 2));

        foreach ($ArrayKey as $key) {
            $this->CardArr[] = self::CARD_RANKS[$key];
        }
    }

    public function randomCard(): void
    {
        $ArrayKey = (array_rand(self::CARD_RANKS, 1));
        $this->CardArr[] = self::CARD_RANKS[$ArrayKey];
    }

    public function getDrawCards()
    {
        return $this->CardArr;
    }
}

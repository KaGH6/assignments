<?php

//カード作成
class Cards
{
    public $cards = [];
    public function __construct()
    {
        $suits = ['ハート', 'ダイヤ', 'クラブ', 'スペード'];
        $cardNumbers = ["2", "3", "4", "5", "6", "7", "8", "9", "10", "J", "Q", "K", "A"];
        foreach ($suits as $suit) {
            foreach ($cardNumbers as $cardNumber) {
                $this->cards[] = new Rank($suit, $cardNumber);
            }
        }
    }

    //カードのデッキを取得するメソッド
    public function getKards()
    {
        return $this->cards;
    }
}

//カードの詳細
class Rank
{
    public $suit;
    public $cardNumber;

    public function __construct($suit, $cardNumber)
    {
        $this->suit = $suit; // マークを設定
        $this->cardNumber = $cardNumber; //番号を設定
    }

    //カードの強さを取得
    public function getRank()
    {
        $rank = ["2" => 2, "3" => 3, "4" => 4, "5" => 5, "6" => 6, "7" => 7, "8" => 8, "9" => 9, "10" => 10, "J" => 11, "Q" => 12, "K" => 13, "A" => 14];
        return $rank[$this->cardNumber];
    }

    //カード情報を文字列として出力するメソッド
    public function __toString()
    {
        return "{$this->suit}の{$this->cardNumber}";
    }
}

//プレイヤーを管理
class Player
{
    public $cards;
    public $cardsArray = [];
    public $playerHands1 = [];
    public $playerHands2 = [];

    public function __construct()
    {
        $this->cards = new Cards();
        $this->cardsArray = $this->cards->getKards(); //52枚入れる
        shuffle($this->cardsArray);
    }

    //手札を分配
    public function hand()
    {
        $this->playerHands1 = array_slice($this->cardsArray, 0, 26); //0番目から26個取り出す
        $this->playerHands2 = array_slice($this->cardsArray, 26, 26); //26番目から26個取り出す
    }

    //プレイヤー１：playerHands1から１枚場に出す
    public function setCard1()
    {
        return array_shift($this->playerHands1);
    }

    //プレイヤー２：playerHands2から１枚場に出す
    public function setCard2()
    {
        return array_shift($this->playerHands2);
    }
}

//ゲームを管理
class Game
{
    public function start()
    {
        echo "戦争を開始します。\n";
        //Playerクラスをインスタンス化して手札を取得
        $playerHands = new Player();
        $playerHands->hand(); //手札を配る
        echo "カードが配られました。\n";
        while (true) { //無限ループ
            echo "戦争！\n";

            $card1 = $playerHands->setCard1(); //プレイヤー1がカードを出す
            $card2 = $playerHands->setCard2(); //プレイヤー2がカードを出す
            echo "プレイヤー１のカードは" . $card1 . "です。\n";
            echo "プレイヤー２のカードは" . $card2 . "です。\n";
            if ($card1->getRank() > $card2->getRank()) {
                echo "プレイヤー1が勝ちました。\n";
                break; //もし勝ったら無限ループ止める
            } elseif ($card1->getRank() < $card2->getRank()) {
                echo "プレイヤー2が勝ちました。\n";
                break;
            } else {
                echo "引き分けです。\n";
            }
        }
    }
}


$game = new Game();
$game->start();

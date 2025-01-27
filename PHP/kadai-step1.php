<?php
class Cards
{
    public $cards = []; //カードを格納する配列。メンバー変数。array型。
    public function __construct()
    {
        $suits = ['ハート', 'ダイヤ', 'クラブ', 'スペード']; //カードのマーク
        $cardNumbers = ["2", "3", "4", "5", "6", "7", "8", "9", "10", "J", "Q", "K", "A"]; //カードの数字と強さを決める
        foreach ($suits as $suit) { //カードのマークと数字を全て組み合わせて、カード生成
            foreach ($cardNumbers as $cardNumber) {
                $this->cards[] = new Rank($suit, $cardNumber); //Rankクラスのインスタンスを作成し、cards配列に追加
            }
        }
    }

    //カードのデッキを取得するメソッド
    public function getKards()
    {
        return $this->cards; //カード５２枚の束。cardsArrayに入れる。作成したカードデッキを返す。
    }
}

class Rank //カード情報を管理
{
    public $suit; //カードのマークのプロパティ
    public $cardNumber; //カードの番号のプロパティ

    public function __construct($suit, $cardNumber) //rankが呼び出されたときにconstructが操作
    {
        $this->suit = $suit; // マークを設定
        $this->cardNumber = $cardNumber; //番号を設定
    }

    public function getRank() //カードの強さを取得するメソッド
    {
        $rank = ["2" => 2, "3" => 3, "4" => 4, "5" => 5, "6" => 6, "7" => 7, "8" => 8, "9" => 9, "10" => 10, "J" => 11, "Q" => 12, "K" => 13, "A" => 14];
        return $rank[$this->cardNumber]; //カードの強さを数値で返す
    }

    public function __toString() //カード情報を文字列として出力するメソッド。__toString：文字列にするメソッド。
    {
        return "{$this->suit}の{$this->cardNumber}";
    }
}

class Player //プレイヤーを管理するクラス
{
    public $cards; //メンバー変数
    public $cardsArray = []; //カード52枚の配列
    public $playerHands1 = []; //手札、シャッフルしたのをここに入れる
    public $playerHands2 = []; //手札、シャッフルしたのをここに入れる

    //Playerクラスのインスタンスが作成されたときに、カードのデッキを用意してシャッフル
    public function __construct()
    {
        $this->cards = new Cards(); //プレイヤーのカードをセット、インスタンス化
        $this->cardsArray = $this->cards->getKards(); //52枚入れる
        shuffle($this->cardsArray); //シャッフル
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

class Game //ゲームを管理するクラス
{
    public function start() //ゲーム開始メソッド
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

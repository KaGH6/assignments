<?php
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

    //カードのデッキを取得
    public function getKards()
    {
        return $this->cards;
    }

    //カードのデッキをシャッフル
    public function shuffleDeck()
    {
        shuffle($this->cards);
    }
}

//カード情報を管理
class Rank
{
    public $suit;
    public $cardNumber;

    public function __construct($suit, $cardNumber)
    {
        $this->suit = $suit;
        $this->cardNumber = $cardNumber;
    }

    //カードの強さを取得
    public function getRank()
    {
        $rank = ["2" => 2, "3" => 3, "4" => 4, "5" => 5, "6" => 6, "7" => 7, "8" => 8, "9" => 9, "10" => 10, "J" => 11, "Q" => 12, "K" => 13, "A" => 14];
        return $rank[$this->cardNumber];
    }

    public function __toString()
    {
        return "{$this->suit}の{$this->cardNumber}";
    }
}

//プレイヤーを管理
class Player
{
    public $cards;
    public $playerHand = [];

    //手札を設定
    public function hand($playerHand)
    {
        $this->playerHand = $playerHand;
    }

    //手札を取得
    public function getHand()
    {
        return $this->playerHand;
    }

    //手札から1枚カードを出す
    public function setCard()
    {
        return array_shift($this->playerHand); //配列の先頭のカードを取り出す
    }
}

//ゲームを管理
class Game
{
    public function start()
    {
        echo "戦争を開始します。\n";
        $player1 = new Player();
        $player2 = new Player();

        //カードデッキを作成してシャッフル
        $cards = new Cards();
        $cards->shuffleDeck();

        //カードをプレイヤーに配布
        $player1->hand(array_slice($cards->getKards(), 0, 26));
        $player2->hand(array_slice($cards->getKards(), 26, 26));
        echo "カードが配られました。\n";

        $deckCards = []; //場に出たカードを保存
        $count = 0;
        while (true) { //無限ループ
            echo "戦争！\n";

            //各プレイヤーがカードを1枚出す
            $card1 = $player1->setCard();
            $card2 = $player2->setCard();

            //場札に追加
            $deckCards = array_merge($deckCards, [$card1, $card2]);
            echo "プレイヤー１のカードは" . $card1 . "です。\n";
            echo "プレイヤー２のカードは" . $card2 . "です。\n";

            //カードの強さを比較
            if ($card1->getRank() > $card2->getRank()) {
                $player1->hand(array_merge($player1->getHand(), $deckCards)); //勝ったプレイヤーは場札を取得
                $deckCards = []; // 場札をリセット
                echo "プレイヤー1が勝ちました。\n";
            } elseif ($card1->getRank() < $card2->getRank()) {
                $player2->hand(array_merge($player2->getHand(), $deckCards)); //勝ったプレイヤーは場札を取得
                $deckCards = []; //場札をリセット
                echo "プレイヤー2が勝ちました。\n";
            } else {
                echo "引き分けです。\n";
            }

            //どちらかの手札がなくなったらゲーム終了
            if (empty($player1->getHand())) {
                echo "プレイヤー1の手札がなくなりました。\nプレイヤー2が1位、プレイヤー1が2位です。\n";
                break;
            }
            if (empty($player2->getHand())) {
                echo "プレイヤー2の手札がなくなりました。\nプレイヤー1が1位、プレイヤー2が2位です。\n";
                break;
            }
            $count++;
        }
    }
}

// ゲーム開始
$game = new Game();
$game->start();

?>

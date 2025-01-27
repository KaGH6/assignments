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

    //カードのデッキをシャッフルするメソッド
    public function shuffleDeck()
    {
        shuffle($this->cards); //配列をシャッフル
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
    public $playerHand = []; //プレイヤーの手札

    //手札を設定するメソッド
    public function hand($playerHand)
    {
        $this->playerHand = $playerHand;
    }

    //手札を取得するメソッド
    public function getHand()
    {
        return $this->playerHand;
    }

    //手札から1枚カードを出すメソッド
    public function setCard() //プレイヤーのハンドから１枚場に出す
    {
        return array_shift($this->playerHand); //配列の先頭のカードを取り出す
    }
}

class Game //ゲームを管理するクラス
{
    public function start()
    { //メソッド
        echo "戦争を開始します。\n";
        //プレイヤーを作成。Playerクラスをインスタンス化して手札を取得
        $player1 = new Player();
        $player2 = new Player();

        //カードデッキを作成してシャッフル
        $cards = new Cards();
        $cards->shuffleDeck(); //作られたデッキがシャッフルされる

        //カードをプレイヤーに配布
        $player1->hand(array_slice($cards->getKards(), 0, 26));
        $player2->hand(array_slice($cards->getKards(), 26, 26));
        echo "カードが配られました。\n";

        $deckCards = []; //場に出たカードを保存する配列。$card1, $card2を入れる。
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

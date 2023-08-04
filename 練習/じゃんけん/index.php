<?php

// 関数呼び出し
require_once "./function.php";

// 変数の初期化
$com = null;

// 相手の手のパターン
$a = [
    0 => 'グー',
    1 => 'チョキ',
    2 => 'パー'
];

// 相手の手をランダムに選ぶ
$com = $a[rand(0,2)];

// 結果を出力

    if (!empty($_POST['select'])) {

        // 
        $player = $_POST['select'];

        // // グーでの勝敗
        // if ($player === 'グー' && $com === 'チョキ') {
        //     win_message();
        // } elseif ($player === 'グー' && $com === 'パー') {
        //     loss_message();
        // } elseif ($player === 'グー' && $com === 'グー') {
        //     draw_message();
        // }

        // // チョキでの勝敗
        // if ($player === 'チョキ' && $com === 'パー') {
        //     win_message();
        // } elseif ($player === 'チョキ' && $com === 'グー') {
        //     loss_message();
        // } elseif ($player === 'チョキ' && $com === 'チョキ') {
        //     draw_message();
        // }

        // // パーでの勝敗
        // if ($player === 'パー' && $com === 'グー') {
        //     win_message();
        // } elseif ($player === 'パー' && $com === 'チョキ') {
        //     loss_message();
        // } elseif ($player === 'パー' && $com === 'パー') {
        //     draw_message();
        // }

        // 上のコードをｷﾞｭっとしたもの
        if ($player === $com) {
            draw_message();
        } elseif ( $player === 'グー' && $com === 'チョキ' || $player === 'チョキ' && $com === 'パー' || $player === 'パー' && $com === 'グー') {
            win_message();
        } else {
            loss_message();
        }
    }
?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>じゃんけんポン！</title>
</head>
<body>

    <form action="" method="post">

        <!-- グー -->
        <input type="radio" name="select" id="rock" value="グー">
        <label for="rock">グー</label>

        <!-- チョキ -->           
        <input type="radio" name="select" id="scissors" value="チョキ">
        <label for="scissors">チョキ</label>

        <!-- パー -->
        <input type="radio" name="select" id="paper" value="パー">
        <label for="paper">パー</label>

        <!-- 送信 -->
        <input type="submit" name="rock_paper_scissors" value="じゃんけん・・・">

    </form>

</body>
</html>
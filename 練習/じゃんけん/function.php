<?php
// 勝ち負けメッセージ
function win_message(){
    global $player, $com;
    echo "あなたの勝ち！" . "<br><br>" . "あなたは" . $player . "を<br>" . "相手は" . $com . "を選びました！";
}

function loss_message(){
    global $player, $com;
    echo "あなたの負け..." . "<br><br>" . "あなたは" . $player . "を<br>" . "相手は" . $com . "を選びました！";
}

function draw_message(){
    global $player, $com;
    echo "引き分け!" . "<br><br>" . "あなたは" . $player . "を<br>" . "相手は" . $com . "を選びました！";
}

?>
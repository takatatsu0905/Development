<?php
// 変数を使う

$greeting_japanese = "こんにちは";
$greeting_english = "Hello";

// HTML、画面上での改行をしたい場合は"<br>"、見た目を綺麗にしたいとき
echo $greeting_english . "<br>" . $greeting_japanese . "<br>";

// コード上で改行したいときは"\n"、コードを綺麗にしたいとき
echo $greeting_english . "\n" .  $greeting_japanese . "<br>";

// 数値を表示
$print = 100;
echo $print . "<br>";

// 型を表示する、stringは文字、intは数値、かっこの中身は長さ
$a = "おにぎりとお味噌汁";
$b = 1000;
echo var_dump($a) . "<br>";
echo var_dump($b) . "<br>";
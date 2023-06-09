// 問題1：ウィンドウの横幅を変数に入れよう
// const win_width = window.innerWidth;
// alert(win_width);

// 問題2：変数で計算をしてalert表示しよう
// let num1 = 5
// let num2 = 7
// alert(num1 + num2);

// 問題3：変数の中の文字列を置き換えよう
// let text1 = 'リンゴ・バナナ';
// let text2 = 'レモン';

// let fruit = (text1 + text2).replace('バナナ','');
// alert(fruit);

// 問題4：クラス名を取得しよう
let list = document.getElementsByName('list');

list(function(){
    list('li').on('click', function(){
        alert(list(this).attr('class'));
    });
});
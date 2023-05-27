// htmlのinput(id) = btnを定数buttonに代入
const button = document.getElementById("btn");

// 定数buttonを'click'するとアラートで"こんにてゃ！"と表示される。
button.addEventListener('click', function(){
    alert("こんにてゃ！");
});



const Time = document.getElementById("time");
const Box = document.getElementById('tBox');

Time.addEventListener('click', function(){
    let date = new Date();
    let year = date.getFullYear();
    let month = date.getMonth() + 1;
    let day = date.getDay();

    let message = '今日は' + year + '年' + month + '月' + day + '日です！';

    alert(message);
})
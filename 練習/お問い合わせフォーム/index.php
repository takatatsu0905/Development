<?php

var_dump($_POST);

// 変数の初期化
$page_flag = 0;

if (!empty($_POST['btn_confirm'])) {
    
    $page_flag = 1;

} elseif (!empty($_POST['btn_submit'])) {
    
    $page_flag = 2;

}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>お問い合わせフォーム</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>
        お問い合わせフォーム
    </h1>

    <?php if($page_flag === 1):?>

        <!-- 確認ページ -->
        <form action="" method="post">
            
            <div class="element_wrap">
                <label for="">氏名</label>
                <p><?php echo $_POST['your_name'];?></p>
            </div>

            <div class="element_wrap">
                <label for="">メールアドレス</label>
                <p><?php echo $_POST['email'];?></p>
            </div>

            <input type="submit" name="btn_back" value="戻る">
            <input type="submit" name="btn_submit" value="送信">
            <input type="hidden" name="your_name" value="<?php echo $_POST['your_name'];?>">
            <input type="hidden" name="email" value="<?php echo $_POST['email'];?>">

        </form>

    <?php elseif($page_flag === 2):?>

        <p>送信が完了しました。</p>

    <?php else:?>
        
        <form action="" method="post">

            <div class="element_wrap">
                <label for="">氏名</label>
                <input type="text" name="your_name" value="">
            </div>

            <div class="element_wrap">
                <label for="">メールアドレス</label>
                <input type="text" name="email">
            </div>

            <input type="submit" name="btn_confirm" value="入力内容を確認する">

        </form>
    <?php endif;?>
</body>
</html>
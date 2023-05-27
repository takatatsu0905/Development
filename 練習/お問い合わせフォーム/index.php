<?php

var_dump($_POST);

// 変数の初期化
$page_flag = 0;

if (!empty($_POST['btn_confirm'])) {
    
    $page_flag = 1;

} elseif (!empty($_POST['btn_submit'])) {
    
    $page_flag = 2;

    // 変数とタイムゾーンを初期化
    $header = null;
    $auto_reply_subject = null;
    $auto_reply_text = null;
    $admin_reply_subject = null;
    $admin_reply_text = null;
    date_default_timezone_set('Asia/Tokyo');

    // ヘッダー情報を設定
    $header = "MIME-Version: 1.0\n";
    $header .= "From: TAKATATSU事務所 <ideatakatatsu0905@gmail.com>\n";
    $header .= "Reply-TO: TAKATATSU事務所 <ideatakatatsu0905@gmail.com>\n";

    // 件名を設定
    $auto_reply_subject = 'お問い合わせありがとうございます。';

    // 本文を設定
    $auto_reply_text = "この度はお問い合わせ頂き誠にありがとうございます。下記の内容でお問い合わせを受け付けました。\n\n";
    $auto_reply_text .= "お問い合わせ日時:" . date("Y-m-d H:i") . "\n";
    $auto_reply_text .= "氏名:" . $_POST['your_name'] . "\n";
    $auto_reply_text .= "メールアドレス:" . $_POST['email'] . "\n\n";
    $auto_reply_text .= "TAKATATSU 事務所";

    // メール送信
    mb_send_mail($_POST['email'], $auto_reply_subject, $auto_reply_text, $header);

    // 運営側へ送るメール
    $admin_reply_subject = "お問い合わせを受け付けました";

    // 本文を設定
    $admin_reply_text = "下記の内容でお問い合わせがありました。\n\n";
    $admin_reply_text .= "お問い合わせ日時:" . date("Y-m-d H:i") . "\n";
    $admin_reply_text .= "氏名:" . $_POST['your_name'] . "\n";
    $admin_reply_text .= "メールアドレス:" . $_POST['email'] . "\n\n";

    // 運営側へメール送信
    mb_send_mail('ideatakatatsu0905@gmail.com', $admin_reply_subject, $admin_reply_text, $header);
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

    <!-- 完了ページ -->
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
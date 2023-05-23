<?php

// 管理ページのログインパスワード
define('PASSWORD', 'adminPassword');

// データベースの接続情報
define('DB_HOST', 'localhost');
define('DB_USER', 'takatatsu');
define('DB_PASS', '0905');
define('DB_NAME', 'board');

// タイムゾーン
date_default_timezone_set('Asia/Tokyo');

// 変数の初期化
$current_date = null;
$message = array();
$message_array = array();
$success_message = null;
$error_message = array();
$pdo = null;
$stmt = null;
$res = null;
$option = null;

session_start();

// データベース接続
try {
    $option = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_MULTI_STATEMENTS => false,
    );

    // データベース接続(= 離さない)
    $pdo = new PDO('mysql:charset=UTF8; dbname='.DB_NAME.'; host='.DB_HOST, DB_USER, DB_PASS, $option);
} catch(PDOException $e) {
    // 接続エラー時、エラー内容を取得
    $error_message[] = $e -> getMessage();

}

// ログイン判定チェック
if (!empty($_POST['btn_submit'])) {
    if (!empty($_POST['admin_password']) &&  $_POST['admin_password'] === PASSWORD) {
        $_SESSION['admin_login'] = true;
    } else {
        $error_message[] = 'ログインに失敗しました。'; 
    }
}

if (!empty($pdo)) {
    // メッセージのデータを取得する
    $sql = "SELECT view_name,message,post_date FROM message ORDER BY post_date DESC";
    $message_array = $pdo -> query($sql);
}

// データベースの接続を閉じる
$pdo = null;

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ひとこと掲示板 管理ページ</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>ひとこと掲示板 管理ページ</h1>

    <!-- エラーメッセージ -->
    <?php if(!empty($error_message)) :?>
        <ul class="error_message">
            <?php foreach($error_message as $value) :?>
                <li>・<?php echo $value ;?></li>
            <?php endforeach ;?>
        </ul>
    <?php endif ;?>

<?php if(!empty($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) :?>

    <section>
        <!-- 投稿メッセージ -->
        <?php if(!empty($message_array)) :?>
            <?php foreach($message_array as $value) :?>
                <article>
                    <div class="info">
                        <h2><?php echo htmlspecialchars($value['view_name'], ENT_QUOTES, 'UTF-8') ;?></h2>
                        <time>
                            <?php echo date('Y年m月d日 H:i', strtotime($value['post_date'])) ;?>
                        </time>
                    </div>
                    <p><?php echo nl2br(htmlspecialchars($value['message'], ENT_QUOTES, 'UTF-8')) ;?></p>
                </article>
            <?php endforeach ;?>
        <?php endif ;?>
    </section>
<?php else :?>
    <form action="" method="post">
        <div>
            <label for="admin_password">ログインパスワード</label>
            <input id="admin_password" type="password" name="admin_password" value="">
        </div>
        <input type="submit" name="btn_submit" value="ログイン">
    </form>

<?php endif ;?>

</body>
</html>
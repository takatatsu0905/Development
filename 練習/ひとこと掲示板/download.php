<?php

// db接続情報のファイル呼び出し
require 'db_config.php';

// 変数の初期化
$csv_date = null;
$sql = null;
$pdo = null;
$option = null;
$message_array = array();
$limit = null;
$stmt = null;

session_start();

// ダウンロードする件数を指定した場合の処理
if (!empty($_GET['limit'])) {
    
    if ($_GET['limit'] === "10") {
        $limit = 10;
    } elseif ($_GET['limit'] === "30") {
        $limit = 30;
    }

}

if (!empty($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) {

    // データベース接続
    try{

        $option = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_MULTI_STATEMENTS => false
        );

        $pdo = new PDO('mysql:charset=UTF8; dbname='.DB_NAME.'; host='.DB_HOST, DB_USER, DB_PASS, $option);

        // メッセージを取得する
        if (!empty($limit)) {
            
            // SQL作成(LIMITと:の間は開ける)
            $stmt = $pdo -> prepare("SELECT * FROM message ORDER BY post_date ASC LIMIT :limit");

            // 値をセット
            $stmt->bindValue( ':limit', $_GET['limit'], PDO::PARAM_INT);

        } else {
            $stmt = $pdo -> prepare("SELECT * FROM message ORDER BY post_date ASC");
        } 

        // SQLクエリの実行
        $stmt->execute();
        $message_array = $stmt->fetchAll();

        // データベースの接続を閉じる
        $stmt = null;
        $pdo = null;

    } catch(PDOException $e) {

        // 管理者ページへリダイレクト
        header("Location: ./admin.php");
        exit;

    }

    // 出力の設定
    header("Content-Type: text/csv");
    header("Content-Disposition: attachment; filename=メッセージデータ.csv");
    header("Content-Transfer-Encoding: binary");

    // csvファイルを作成
    if (!empty($message_array)) {
        
        // 1行目のラベル作成
        $csv_date .= ' "ID", "表示名", "メッセージ", "投稿日時" '."\n";

        foreach($message_array as $value) {

            // データを1業ずつcsvファイルに書き込む
            $csv_date .= '"' . $value['id'] . '","' . $value['view_name'] . '","' . $value['message'] . '","' . $value['post_date'] . "\"\n";
        }

    }

    // ファイルを出力
    echo $csv_date;


} else {

    // ログインページにリダイレクト
    header("Location: ./admin.php");
    exit;

}

return;

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

    <!-- ログインセッション確認 -->
    <?php if(!empty($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) :?>
    
    <form action="./download.php" method="get">
        <input type="submit" name="btn_download" value="ダウンロード">
    </form>

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
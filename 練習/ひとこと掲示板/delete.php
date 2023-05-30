<?php

// db接続情報のファイル呼び出し
require 'db_config.php';

// タイムゾーン
date_default_timezone_set('Asia/Tokyo');

// 変数の初期化
$view_name = null;
$message = array();
$message_data = null;
$error_message = array();
$pdo = null;
$stmt = null;
$res = null;
$option = null;

session_start();

// 管理者としてログインしているか確認
if(empty($_SESSION['admin_login']) || $_SESSION['admin_login'] !== true) {

    // ログインページへリダイレクト
    header("Location: ./admin.php");
    exit;
}

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

if (!empty($_GET['message_id']) && empty($_POST['message_id']) ) {
    // SQL作成
    $stmt = $pdo -> prepare("SELECT * FROM message WHERE id = :id");

    // 値をセット
    $stmt -> bindValue(':id', $_GET['message_id'], PDO::PARAM_INT);

    // SQLクエリの実行
    $stmt -> execute();

    // 表示するデータを取得
    $message_data = $stmt -> fetch();

    // 投稿データが取得出来なかった場合、管理ページに戻る
    if (empty($message_data)) {
        header("Location: ./admin.php");
        exit;
    }

} elseif(!empty($_POST['message_id'])) {

    // トランザクションを開始
    $pdo -> beginTransaction();

    try {

        // SQLを作成
        $stmt = $pdo -> prepare("DELETE FROM message WHERE id = :id");

        // 値をセット
        $stmt -> bindValue(':id', $_POST['message_id'], PDO::PARAM_INT);

        // SQLを実行
        $stmt -> execute();

        // コミット
        $res = $pdo -> commit();

    } catch(Exception $e) {

        // エアーが発生した場合ロールバック
        $pdo -> rollBack();
    }

    // 削除に成功したら一覧に戻る
    if($res) {
        header("Location: ./admin.php");
        exit;
    }

}

// データベースの接続を閉じる
$stmt = null;
$pdo = null;

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ひとこと掲示板 管理ページ（投稿の削除）</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .btn_cancel {
            display: inline-block;
            margin-right: 10px;
            padding: 10px 20px;
            color: #555;
            font-size: 86%;
            border-radius: 5px;
            border: 1px solid #999;
        }
        .btn_cancel:hover {
            color: #999;
            border-color: #999;
            text-decoration: none;
        }
        .text-confirm {
            margin-bottom: 20px;
            font-size: 86%;
            line-height: 1.6rem;
        }
    </style>
</head>
<body>
    <h1>ひとこと掲示板 管理ページ（投稿の削除）</h1>

    <!-- エラーメッセージ -->
    <?php if(!empty($error_message)) :?>
        <ul class="error_message">
            <?php foreach($error_message as $value) :?><li>・
                <?php echo $value ;?></li>
            <?php endforeach ;?>
        </ul>
    <?php endif ;?>

    <!-- 削除確認テキスト -->
    <p class="text-confirm">
        以下の投稿を削除します。<br>
        よろしければ「削除」ボタンを押してください。
    </p>

    <!-- 入力フォーム -->
    <form method="post" action="">

        <div>
            <label for="view_name">表示名</label>
            <input id="view_name" type="text" name="view_name" value="<?php if(!empty($message_data['view_name'])){echo $message_data['view_name']; }elseif(!empty($view_name)) {echo htmlspecialchars($view_name, ENT_QUOTES, 'UTF-8'); }?>" disabled>
        </div>

        <div>
            <label for="message">ひとことメッセージ</label>
            <textarea name="message" id="message" disabled><?php if(!empty($message_data['message'])) {echo $message_data['message']; }elseif(!empty($message)) {echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); }?></textarea>
        </div>

        <a class="btn_cancel" href="admin.php">キャンセル</a>
        <input type="submit" name="btn_submit" value="削除">
        <input type="hidden" name="message_id" value="
        <?php if(!empty($message_data['id'])){echo $message_data['id']; }elseif(!empty($_POST['message_id'])) {echo htmlspecialchars(($_POST['message_id']), ENT_QUOTES, 'UTF-8'); }?>">
    </form>
</body>
</html>
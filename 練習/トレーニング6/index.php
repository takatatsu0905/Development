<?php

// メッセージを保存するファイルパス設定
define('FILENAME', './message.txt');

// タイムゾーン
date_default_timezone_set('Asia/Tokyo');

// 変数の初期化
$current_date = null;
$data = null;
$file_handle = null;
$split_data = null;
$message = array();
$message_array = array();
$success_message = null;
$error_message = array();
$clean = array();
$pdo = null;
$stmt = null;
$res = null;
$option = null;

// データベース接続
try {
    $option = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_MULTI_STATEMENTS => false,
    );

    // データベース接続(= 離さない)
    $pdo = new PDO('mysql:charset=UTF8; dbname=board; host=localhost', 'takatatsu', '0905', $option);
} catch(PDOException $e) {
    // 接続エラー時、エラー内容を取得
    $error_message[] = $e -> getMessage();

}

// メッセージ書き込む処理
if (!empty($_POST['btn_submit'])) {

    // 空白除去
    $view_name = preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '', $_POST['view_name']);
    $message = preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '', $_POST['message']);
    
    // 表示名入力チェック
    if (empty($view_name)) {
        $error_message[] = '表示名を入力してください。';
    } else {
        $clean['view_name'] = htmlspecialchars($_POST['view_name'], ENT_QUOTES, 'UTF-8');
        $clean['view_name'] = preg_replace('/\\r\\n|\\n|\\r/', '', $clean['view_name']);
    }

    // メッセージの入力チェック
    if (empty($message)) {
        $error_message[] = 'ひとことメッセージを入力してください。';
    } else {
        $clean['message'] = htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8');
        $clean['message'] = preg_replace('/\\r\\n|\\n|\\r/', '<br>', $clean['message']);
    }

    // エラーがなければ書き込み処理実行
    if (empty($error_message)) {
        // // メッセージを書き込む
        // if($file_handle = fopen(FILENAME, "a")){
        //     // 書き込み日時
        //     $current_date = date("Y-m-d H:i:s");

        //     // 書き込むデータ作成
        //     $data = "'" . $clean['view_name'] . "','" . $clean['message'] . "','" . $current_date . "'\n";

        //     // 書き込み
        //     fwrite($file_handle, $data);

        //     // ファイルを閉じる
        //     fclose($file_handle);

        //     // メッセージ書き込み後のテキスト
        //     $success_message = 'メッセージを書き込みました。';
        // }

        // 書き込み日時を取得
        $current_date = date("Y-m-d H:i:s");
        
        // トランザクションを開始
        $pdo -> beginTransaction();

        try {

            // SQL作成
            $stmt = $pdo -> prepare("INSERT INTO message(view_name, message, post_date) VALUES(:view_name, :message, :current_date)");

            // 値をセット
            $stmt -> bindParam(':view_name', $view_name, PDO::PARAM_STR);
            $stmt -> bindParam(':message', $message, PDO::PARAM_STR);
            $stmt -> bindParam(':current_date', $current_date, PDO::PARAM_STR);

            // SQLクエリの実行
            $res = $stmt->execute();

            // コミット
            $res = $pdo -> commit();

        } catch(Exception $e) {

            // エラーが発生した時はロールバック
            $pdo -> rollBack();

        }

        if ($res) {
            $success_message = 'メッセージを書き込みました。';
        } else {
            $error_message[] = '書き込みに失敗しました。';
        }

        // プリペアードステートメントを削除
        $stmt = null;
    }
}

// データベースの接続を閉じる
$pdo = null;

// 書き込まれているメッセージを表示させる処理
if ($file_handle = fopen( FILENAME, 'r')) {
    // messageファイルにデータが入っていれば開く
    while ($data = fgets($file_handle)) {
        // message.txtからデータを取得
        $split_data = preg_split('/\'/', $data);

        // データを配列に格納
        $message = array(
            'view_name' => $split_data[1],
            'message' => $split_data[3],
            'post_date' =>  $split_data[5]
        );
        // $message_arrayに$messageごと格納
        array_unshift($message_array, $message);
    }
    // ファイルを閉じる
    fclose($file_handle);
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ひとこと掲示板</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>ひとこと掲示板</h1>

    <!-- 投稿完了メッセージ -->
    <?php if(!empty($success_message)) :?>
        <p class="success_message">
            <?php echo $success_message ;?>
        </p>
    <?php endif ;?>

    <!-- エラーメッセージ -->
    <?php if(!empty($error_message)) :?>
        <ul class="error_message">
            <?php foreach($error_message as $value) :?>
                <li>・<?php echo $value ;?></li>
            <?php endforeach ;?>
        </ul>
    <?php endif ;?>

    <!-- 入力フォーム -->
    <form method="post" action="">
        <div>
            <label for="view_name">表示名</label>
            <input id="view_name" type="text" name="view_name" value="">
        </div>
        <div>
            <label for="message">ひとことメッセージ</label>
            <textarea name="message" id="message"></textarea>
        </div>
        <input type="submit" name="btn_submit" value="書き込む">
    </form>
    <hr>

    <section>
        <!-- 投稿メッセージ -->
        <?php if(!empty($message_array)) :?>
            <?php foreach($message_array as $value) :?>
                <article>
                    <div class="info">
                        <h2><?php echo $value['view_name'] ;?></h2>
                        <time>
                            <?php echo date('Y年m月d日 H:i', strtotime($value['post_date'])) ;?>
                        </time>
                    </div>
                    <p><?php echo $value['message'] ;?></p>
                </article>
            <?php endforeach ;?>
        <?php endif ;?>
    </section>

</body>
</html>
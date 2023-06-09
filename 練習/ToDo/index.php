<?php 

// 変数の初期化
// $error_message = array();
$option = null;
$pdo = null;
$sql = null;
$query = null;
$text = null;
$now = null;
$stmt = null;
$id = null;
$DATE = null;

// データベース接続関数
function dbConnect() {

    // db接続情報呼び出し
    require 'db_config.php';

    try {

        $pdo = new PDO('mysql:charset=UTF8; dbname='.DB_NAME.'; host'.DB_USER, DB_USER, DB_PASS,[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

        return $pdo;

    } catch(PDOException $e) {

        // 接続エラー時に、エラーメッセージを取得
        echo "データベース接続エラーです。" .  $e -> getMessage();
        exit();
    }
}

// TODO呼び出し関数
function fetchALL() {

    // SQL作成
    $sql = "SELECT * FROM list";
    $query = dbConnect() -> query($sql);

    // TODO呼び出し実行
    return $query -> fetchALL(PDO::FETCH_ASSOC);
}


// TODO作成関数
function create($text){

    // 作成時の時間
    $now = date('Y/m/d H:i:s');
    // SQL作成
    $sql = 'INSERT INTO list (text, created_at, updated_at) VALUES(?, ?, ?)';
    $stmt = dbConnect() -> prepare($sql);

    // sql実行&ステートメント
    $stmt -> execute([$text, $now, $now]);
}


// TODOアップデート関数
function update($id, $text){

    // SQL作成
    $sql = 'UPDATE list SET text = ?, updated_at = ? WHERE id = ?';
    $stmt = dbConnect() -> prepare($sql);

    // sql実行&ステートメント
    $stmt -> execute([$text, date('Y/m/d H:i:s'), $id]);
}


// TODO消去関数
function delete($id) {
    
    // SQL作成
    $sql = 'DELETE FROM list WHERE id = ?';
    $stmt = dbConnect() -> prepare($sql);

    // sql実行&ステートメント
    $stmt -> execute([$id]);
}

// 各処理実行（create,update,delete）
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!empty($_POST['submit'])) {

        create($_POST['submit']);

    } elseif(isset($_POST['update'])) {

        update($_POST['id'], $_POST['text']);

    } elseif (isset($_POST['delete'])) {
    
        delete($_POST['id']);
    
    }

    header('Location: ./');
    exit;
}

$DATE = fetchALL();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TODOアプリ</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>TODOアプリ！</h1>

    <section>

        <form action="" method="post" class="create_todo">
            <input type="text" name="submit" require>
            <button type="submit">作成する</button>
        </form>

        <!-- todoリスト-->
        <table>

            <?php if($DATE):?>
            
                <tr class="table_style">
                    <th rowspan="2">TODO</th>
                    <th rowspan="2">作成日</th>
                    <th colspan="2" id="action">操作</th>
                </tr>

                <tr class="table_style">
                    <th headers="action">更新</th>
                    <th headers="action">削除</th>
                </tr>
            <?php endif ;?>

            <?php foreach((array) $DATE as $row):?>
                <form action="" method="post">
                    <tr>

                        <input type="hidden" name="id" value="<?php echo $row['id'] ;?>">

                        <td>
                            <input type="text" name="text" value="<?php echo $row['text'];?>" require>
                        </td>

                        <td>
                            <?php echo $row['created_at'] ;?>
                        </td>

                        <td>
                            <button type="submit" name="update">更新する</button>
                        </td>

                        <td>
                            <button type="submit" name="delete">削除する</button>
                        </td>
                        
                    </tr>
                </form>
            <?php endforeach ;?>
        </table>
        
    </section>
</body>
</html>
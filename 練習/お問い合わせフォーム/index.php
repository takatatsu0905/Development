<?php

var_dump($_POST);

// 変数の初期化
$page_flag = 0;
$clean = array();
$error = array();

// サニタイズ
if (!empty($_POST)) {
    foreach ($_POST as $key => $value) {
        $clean[$key] = htmlspecialchars($value, ENT_QUOTES);
    }
}

if (!empty($_POST['btn_confirm'])) {
    
    $error = validation($clean);

    if (empty($error)) {
        $page_flag = 1;
    }

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
    $header .= "From: TAKATATSU事務所 <TAKATATSUtest@gmail.com>\n";
    $header .= "Reply-TO: TAKATATSU事務所 <TAKATATSUtest@gmail.com>\n";

    // 件名を設定
    $auto_reply_subject = 'お問い合わせありがとうございます。';

    // 本文を設定
    $auto_reply_text = "この度はお問い合わせ頂き誠にありがとうございます。下記の内容でお問い合わせを受け付けました。\n\n";
    $auto_reply_text .= "お問い合わせ日時:" . date("Y-m-d H:i") . "\n";
    $auto_reply_text .= "氏名:" . $_POST['your_name'] . "\n";
    $auto_reply_text .= "メールアドレス:" . $_POST['email'] . "\n";
    
    if ($_POST['gender'] === "male") {
        $auto_reply_text .= "性別:男性\n";
    } else {
        $auto_reply_text .= "性別:女性\n";
    }

    if ($_POST['age'] === "1") {
        $auto_reply_text .= "年齢:~19歳\n";
    } elseif ($_POST['age'] === "2") {
        $auto_reply_text .= "年齢:20歳~29歳\n";
    } elseif ($_POST["age"] === "3") {
        $auto_reply_text .= "年齢:30歳~39歳\n";
    } elseif ($_POST['age'] === "4") {
        $auto_reply_text .= "年齢:40歳~49歳\n";
    } elseif ($_POST['age'] === "5") {
        $auto_reply_text .= "年齢:50歳~59歳\n";
    } elseif ($_POST['age'] === "6") {
        $auto_reply_text .= "年齢:60歳~\n";
    }

    $auto_reply_text .= "お問い合わせ内容:". nl2br($_POST['contact']) ."\n\n";

    $auto_reply_text .= "TAKATATSU 事務所";

    // メール送信
    mb_send_mail($_POST['email'], $auto_reply_subject, $auto_reply_text, $header);

    // 運営側へ送るメール
    $admin_reply_subject = "お問い合わせを受け付けました";

    // 本文を設定
    $admin_reply_text = "下記の内容でお問い合わせがありました。\n\n";
    $admin_reply_text .= "お問い合わせ日時:" . date("Y-m-d H:i") . "\n";
    $admin_reply_text .= "氏名:" . $_POST['your_name'] . "\n";
    $admin_reply_text .= "メールアドレス:" . $_POST['email'] . "\n";
    
    if ($_POST['gender'] === "male") {
        $admin_reply_text .= "性別:男性\n";
    } else {
        $admin_reply_text .= "性別:女性\n";
    }

    if ($_POST['age'] === "1") {
        $admin_reply_text .= "年齢:~19歳\n";
    } elseif ($_POST['age'] === "2") {
        $admin_reply_text .= "年齢:20歳~29歳\n";
    } elseif ($_POST["age"] === "3") {
        $admin_reply_text .= "年齢:30歳~39歳\n";
    } elseif ($_POST['age'] === "4") {
        $admin_reply_text .= "年齢:40歳~49歳\n";
    } elseif ($_POST['age'] === "5") {
        $admin_reply_text .= "年齢:50歳~59歳\n";
    } elseif ($_POST['age'] === "6") {
        $admin_reply_text .= "年齢:60歳~\n";
    }

    $admin_reply_text .= "お問い合わせ内容:". nl2br($_POST['contact']) ."\n\n";

    // 運営側へメール送信
    mb_send_mail('TAKATATSUtest@gmail.com', $admin_reply_subject, $admin_reply_text, $header);
}

function validation($date) {
    
    $error = array();

    // 氏名のバリデーション
    if (empty($date['your_name'])) {
        $error[] = "「氏名」は必ず入力してください。";
    } 
    
    // メールアドレスのバリデーション
    if (empty($date['email'])) {
        $error[] = "「メールアドレス」は必ず入力してください。";
    }

    // 性別のバリデーション
    if (empty($date['gender'])) {
        $error[] = "「性別」は必ず入力してください。";
    }

    // 年齢のバリデーション
    if (empty($date['age'])) {
        $error[] = "「年齢」は必ず入力してください。";
    }

    // お問い合わせ内容のバリデーション
    if (empty($date['contact'])) {
        $error[] = "「お問い合わせ内容」は必ず入力してください。";
    }

    // プライバシーポリシーのバリデーション
    if (empty($date['agreement'])) {
        $error[] = "「プライバシーポリシー」は必ず入力してください。";
    }

    return $error;

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

            <div class="element_wrap">
                <label>性別</label>
                <p><?php if ($_POST['gender'] === "male") {
                    echo "男性";
                } else {
                    echo "女性";
                }?></p>
            </div>

            <div class="element_wrap">
                <label>年齢</label>
                <p><?php if ($_POST['age'] === "1") {
                    echo "~19歳";
                } elseif ($_POST['age'] === "2") {
                    echo "20歳~29歳";
                } elseif ($_POST['age'] === "3") {
                    echo "30歳~39歳";
                } elseif ($_POST['age'] === "4") {
                    echo "40歳~49歳";
                } elseif ($_POST['age'] === "5") {
                    echo "50歳~59歳";
                } elseif ($_POST['age'] === "6") {
                    echo "60歳~";
                }?></p>
            </div>

            <div class="element_wrap">
                <label>お問い合わせ内容</label>
                <p><?php echo nl2br($_POST['contact'])?></p>
            </div>

            <div class="element_wrap">
                <label>プライバシーポリシーに同意する</label>
                <p><?php if ($_POST['agreement'] === "1") {
                    echo "同意する";
                } else {
                    echo "同意しない";
                }?></p>
            </div>

            <input type="submit" name="btn_back" value="戻る">
            <input type="submit" name="btn_submit" value="送信">
            <input type="hidden" name="your_name" value="<?php echo $_POST['your_name'];?>">
            <input type="hidden" name="email" value="<?php echo $_POST['email'];?>">
            <input type="hidden" name="gender" value="<?php echo $_POST['gender'];?>">
            <input type="hidden" name="age" value="<?php echo $_POST['age'];?>">
            <input type="hidden" name="contact" value="<?php echo $_POST['contact'];?>">
            <input type="hidden" name="agreement" value="<?php echo $_POST['agreement'];?>">

        </form>

    <!-- 完了ページ -->
    <?php elseif($page_flag === 2):?>

        <p>送信が完了しました。</p>

    <?php else:?>

        <!-- エラーメッセージ -->
        <?php if (!empty($error)) :?>
            <ul class="error_list">
                <?php foreach($error as $value) :?>
                    <li><?php echo $value ;?></li>
                <?php endforeach ;?>
            </ul>
        <?php endif ;?>
        
        <!-- 入力ページ -->
        <form method="post">
            
            <!-- 名前 -->
            <div class="element_wrap">
                <label>氏名</label>
                <input type="text" name="your_name" value="<?php if (!empty($_POST['your_name'])) {
                    echo $_POST['your_name'];
                } ?>">
            </div>

            <!-- メールアドレス -->
            <div class="element_wrap">
                <label>メールアドレス</label>
                <input type="text" name="email" value="<?php if (!empty($_POST['email'])) {
                    echo $_POST['email'];
                } ?>">
            </div>

            <!-- 性別 -->
            <div class="element_wrap">
                <label>性別</label>
                <label for="gender_male">
                    <input type="radio" name="gender" id="gender_male" value="male" <?php if (!empty($_POST['gender']) && $_POST['gender'] === "male") {
                        echo "checked";
                    }?>>
                    男性
                </label>
                <label for="gender_female">
                    <input type="radio" name="gender" id="gender_female" value="female" <?php if (!empty($_POST['gender']) && $_POST['gender'] === "female") {
                        echo "checked";
                    }?>>
                    女性
                </label>
            </div>

            <!-- 年齢 -->
            <div class="element_wrap">
                <label>年齢</label>
                <select name="age">
                    <option value="">選択してください</option>
                    <option value="1" <?php if (!empty($_POST['age']) && $_POST['age'] === "1") {
                        echo "selected";
                    }?>>~19歳</option>
                    <option value="2" <?php if (!empty($_POST['age']) && $_POST['age'] === "2") {
                        echo "selected";
                    }?>>20歳~29歳</option>
                    <option value="3" <?php if (!empty($_POST['age']) && $_POST['age'] === "3") {
                        echo "selected";
                    }?>>30歳~39歳</option>
                    <option value="4" <?php if (!empty($_POST['age']) && $_POST['age'] === "4") {
                        echo "selected";
                    }?>>40歳~49歳</option>
                    <option value="5" <?php if (!empty($_POST['age']) && $_POST['age'] === "5") {
                        echo "selected";
                    }?>>50歳~59歳</option>
                    <option value="6" <?php if (!empty($_POST['age']) && $_POST['age'] === "6") {
                        echo "selected";
                    }?>>60歳~</option>
                </select>
            </div>

            <!-- お問い合わせ内容 -->
            <div class="element_wrap">
                <label>お問い合わせ内容</label>
                <textarea name="contact"><?php if (!empty($_POST['contact'])) {
                    echo $_POST['contact'];
                }?></textarea>
            </div>

            <!-- プライバシーポリシー -->
            <div class="element_wrap">
                <label for="agreement">
                    <input type="checkbox" name="agreement" id="agreement" value="1" <?php if (!empty($_POST['agreement']) && $_POST['agreement'] === "1") {
                        echo "checked";
                    }?>>
                    プライバシーポリシーに同意する
                </label>
            </div>

            <input type="submit" name="btn_confirm" value="入力内容を確認する">

        </form>
    <?php endif;?>
</body>
</html>
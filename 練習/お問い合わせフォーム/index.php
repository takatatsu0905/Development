<?php

define("FILE_DIR", "images/test/");

// 変数の初期化
$page_flag = 0;
$clean = array();
$error = array();

// サニタイズ処理
if (!empty($_POST)) {
    foreach ($_POST as $key => $value) {
        $clean[$key] = htmlspecialchars($value, ENT_QUOTES);
    }
}

if (!empty($clean['btn_confirm'])) {
    
    $error = validation($clean);

	// ファイルのアップロード
	if( !empty($_FILES['attachment_file']['tmp_name']) ) {

		$upload_res = move_uploaded_file( $_FILES['attachment_file']['tmp_name'], FILE_DIR.$_FILES['attachment_file']['name']);

		if( $upload_res !== true ) {
			$error[] = 'ファイルのアップロードに失敗しました。';
		} else {
			$clean['attachment_file'] = $_FILES['attachment_file']['name'];
		}
	}

    if (empty($error)) {
        $page_flag = 1;

        // セッションの書き込み
        session_start();
        $_SESSION['page'] = true;
    }

} elseif (!empty($clean['btn_submit'])) {
    
    // 多重送信防止
    session_start();
    
    if (!empty($_SESSION['page'] && $_SESSION['page'] === true)) {
        
        // セッションの削除
        unset($_SESSION['page']);
    

        $page_flag = 2;

        // 変数とタイムゾーンを初期化
        $header = null;
        $body = null;
        $auto_reply_subject = null;
        $auto_reply_text = null;
        $admin_reply_subject = null;
        $admin_reply_text = null;
        date_default_timezone_set('Asia/Tokyo');

        // 日本語の使用宣言&文字コード指定
        mb_language("ja");
        mb_internal_encoding("UTF-8");

        // ヘッダー情報を設定
        $header = "MIME-Version: 1.0\n";
        $header = "Content-Type: multipart/mixed;boundary=\"__BOUNDARY__\"\n";
        $header .= "From: TAKATATSU事務所 <TAKATATSUtest@gmail.com>\n";
        $header .= "Reply-TO: TAKATATSU事務所 <TAKATATSUtest@gmail.com>\n";

        // 件名を設定
        $auto_reply_subject = 'お問い合わせありがとうございます。';

        // 本文を設定（送信者に送信）
        $auto_reply_text = "この度はお問い合わせ頂き誠にありがとうございます。下記の内容でお問い合わせを受け付けました。\n\n";
        $auto_reply_text .= "お問い合わせ日時:" . date("Y-m-d H:i") . "\n";
        $auto_reply_text .= "氏名:" . $clean['your_name'] . "\n";
        $auto_reply_text .= "メールアドレス:" . $clean['email'] . "\n";
        
        if ($clean['gender'] === "male") {
            $auto_reply_text .= "性別:男性\n";
        } else {
            $auto_reply_text .= "性別:女性\n";
        }

        if ($clean['age'] === "1") {
            $auto_reply_text .= "年齢:~19歳\n";
        } elseif ($clean['age'] === "2") {
            $auto_reply_text .= "年齢:20歳~29歳\n";
        } elseif ($clean["age"] === "3") {
            $auto_reply_text .= "年齢:30歳~39歳\n";
        } elseif ($clean['age'] === "4") {
            $auto_reply_text .= "年齢:40歳~49歳\n";
        } elseif ($clean['age'] === "5") {
            $auto_reply_text .= "年齢:50歳~59歳\n";
        } elseif ($clean['age'] === "6") {
            $auto_reply_text .= "年齢:60歳~\n";
        }

        $auto_reply_text .= "お問い合わせ内容:". nl2br($clean['contact']) ."\n\n";

        $auto_reply_text .= "TAKATATSU 事務所";

        // テキストメッセージをセット
        $body = "--__BOUNDARY__\n";
        $body .= "Content-type: text/plain; charset=\"ISO-2022-JP\"\n\n";
        $body .= $auto_reply_text . "\n";
        $body .= "--__BOUNDARY__\n";

        // ファイルを添付
        if (!empty($clean['attachment_file'])) {
            $body .= "Content-Type: application/octet-stream; name=\"{$clean['attachment_file']}\"\n";
            $body .= "Content-Disposition: attachment; filename=\"{$clean['attachment_file']}\"\n";
            $body .= "Content-Transfer-Encoding: base64\n";
            $body .= "\n";
            $body .= chunk_split(base64_encode(file_get_contents(FILE_DIR . $clean['attachment_file'])));
            $body .= "--__BOUNDARY__\n";
        }

        // メール送信
        mb_send_mail($clean['email'], $auto_reply_subject, $body, $header);

        // 運営側へ送るメール
        $admin_reply_subject = "お問い合わせを受け付けました";


        // 本文を設定(運営者に送信)
        $admin_reply_text = "下記の内容でお問い合わせがありました。\n\n";
        $admin_reply_text .= "お問い合わせ日時:" . date("Y-m-d H:i") . "\n";
        $admin_reply_text .= "氏名:" . $clean['your_name'] . "\n";
        $admin_reply_text .= "メールアドレス:" . $clean['email'] . "\n";
        
        if ($clean['gender'] === "male") {
            $admin_reply_text .= "性別:男性\n";
        } else {
            $admin_reply_text .= "性別:女性\n";
        }

        if ($clean['age'] === "1") {
            $admin_reply_text .= "年齢:~19歳\n";
        } elseif ($clean['age'] === "2") {
            $admin_reply_text .= "年齢:20歳~29歳\n";
        } elseif ($clean["age"] === "3") {
            $admin_reply_text .= "年齢:30歳~39歳\n";
        } elseif ($clean['age'] === "4") {
            $admin_reply_text .= "年齢:40歳~49歳\n";
        } elseif ($clean['age'] === "5") {
            $admin_reply_text .= "年齢:50歳~59歳\n";
        } elseif ($clean['age'] === "6") {
            $admin_reply_text .= "年齢:60歳~\n";
        }

        $admin_reply_text .= "お問い合わせ内容:". nl2br($clean['contact']) ."\n\n";

        // テキストメッセージをセット
        $body = "--__BOUNDARY__\n";
        $body .= "Content-type: text/plain; charset=\"ISO-2022-JP\"\n\n";
        $body .= $admin_reply_text . "\n";
        $body .= "--__BOUNDARY__\n";

        // ファイルを添付
        if (!empty($clean['attachment_file'])) {
            $body .= "Content-Type: application/octet-stream; name=\"{$clean['attachment_file']}\"\n";
            $body .= "Content-Disposition: attachment; filename=\"{$clean['attachment_file']}\"\n";
            $body .= "Content-Transfer-Encoding: base64\n";
            $body .= "\n";
            $body .= chunk_split(base64_encode(file_get_contents(FILE_DIR . $clean['attachment_file'])));
            $body .= "--__BOUNDARY__\n";
        }

        // 運営側へメール送信
        mb_send_mail('TAKATATSUtest@gmail.com', $admin_reply_subject, $body, $header);

    } else {
        $page_flag = 0;
        $error[] = "読み込み時にエラーが発生しました。もう一度入力してください。";
    }
}

function validation($date) {
    
    $error = array();

    // 氏名のバリデーション
    if (empty($date['your_name'])) {
        $error[] = "「氏名」は必ず入力してください。";
    } elseif (20 < mb_strlen($date['your_name'])) {
        $error[] = "「氏名」は20文字で入力してください。";
    }
    
    // メールアドレスのバリデーション
    if (empty($date['email'])) {
        $error[] = "「メールアドレス」は必ず入力してください。";
    } elseif (!preg_match('/^[0-9a-z_.\/?-]+@([0-9a-z-]+\.)+[0-9a-z-]+$/', $date['email'])) {
        $error[] = "「メールアドレス」は正しい形式で入力してください。";
    }

    // 性別のバリデーション
    if (empty($date['gender'])) {
        $error[] = "「性別」は必ず入力してください。";
    } elseif ($date['gender'] !== 'male' && $date['gender'] !== 'female') {
        $error[] = "「性別」は必ず入力してください。";
    }

    // 年齢のバリデーション
    if (empty($date['age'])) {
        $error[] = "「年齢」は必ず入力してください。";
    } elseif ((int)$date['age'] < 1 || 6 < (int)$date['age']) {
        $error[] = "「年齢」は必ず入力してください。";
    }

    // お問い合わせ内容のバリデーション
    if (empty($date['contact'])) {
        $error[] = "「お問い合わせ内容」は必ず入力してください。";
    }

    // プライバシーポリシーのバリデーション
    if (empty($date['agreement'])) {
        $error[] = "「プライバシーポリシー」をご確認ください。";
    } elseif ((int)$date['agreement'] !== 1) {
        $error[] = "「プライバシーポリシー」をご確認ください。";
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
                <p><?php echo $clean['your_name'];?></p>
            </div>

            <div class="element_wrap">
                <label for="">メールアドレス</label>
                <p><?php echo $clean['email'];?></p>
            </div>

            <div class="element_wrap">
                <label>性別</label>
                <p><?php if ($clean['gender'] === "male") {
                    echo "男性";
                } else {
                    echo "女性";
                }?></p>
            </div>

            <div class="element_wrap">
                <label>年齢</label>
                <p><?php if ($clean['age'] === "1") {
                    echo "~19歳";
                } elseif ($clean['age'] === "2") {
                    echo "20歳~29歳";
                } elseif ($clean['age'] === "3") {
                    echo "30歳~39歳";
                } elseif ($clean['age'] === "4") {
                    echo "40歳~49歳";
                } elseif ($clean['age'] === "5") {
                    echo "50歳~59歳";
                } elseif ($clean['age'] === "6") {
                    echo "60歳~";
                }?></p>
            </div>

            <div class="element_wrap">
                <label>お問い合わせ内容</label>
                <p><?php echo nl2br($clean['contact'])?></p>
            </div>

            <?php if(!empty($clean['attachment_file'])) :?>
                <div class="element_wrap">
                    <label>画像ファイルの添付</label>
                    <p><img src="<?php echo FILE_DIR.$clean['attachment_file'] ;?>" alt="" width = "500"></p>
                </div>
            <?php endif ;?>

            <div class="element_wrap">
                <label>プライバシーポリシーに同意する</label>
                <p><?php if ($clean['agreement'] === "1") {
                    echo "同意する";
                } else {
                    echo "同意しない";
                }?></p>
            </div>

            <input type="submit" name="btn_back" value="戻る">
            <input type="submit" name="btn_submit" value="送信">
            <input type="hidden" name="your_name" value="<?php echo $clean['your_name'];?>">
            <input type="hidden" name="email" value="<?php echo $clean['email'];?>">
            <input type="hidden" name="gender" value="<?php echo $clean['gender'];?>">
            <input type="hidden" name="age" value="<?php echo $clean['age'];?>">
            <input type="hidden" name="contact" value="<?php echo $clean['contact'];?>">
            <input type="hidden" name="agreement" value="<?php echo $clean['agreement'];?>">
            <?php if(!empty($clean['attachment_file'])) :?>
                <input type="hidden" name="attachment_file" value="<?php echo $clean['attachment_file'];?>">
            <?php endif ;?>

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
        <form method="post" action="" enctype="multipart/form-data">
            
            <!-- 名前 -->
            <div class="element_wrap">
                <label>氏名</label>
                <input type="text" name="your_name" value="<?php if (!empty($clean['your_name'])) {
                    echo $clean['your_name'];
                } ?>">
            </div>

            <!-- メールアドレス -->
            <div class="element_wrap">
                <label>メールアドレス</label>
                <input type="text" name="email" value="<?php if (!empty($clean['email'])) {
                    echo $clean['email'];
                } ?>">
            </div>

            <!-- 性別 -->
            <div class="element_wrap">
                <label>性別</label>
                <label for="gender_male">
                    <input type="radio" name="gender" id="gender_male" value="male" <?php if (!empty($clean['gender']) && $clean['gender'] === "male") {
                        echo "checked";
                    }?>>
                    男性
                </label>
                <label for="gender_female">
                    <input type="radio" name="gender" id="gender_female" value="female" <?php if (!empty($clean['gender']) && $clean['gender'] === "female") {
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
                    <option value="1" <?php if (!empty($clean['age']) && $clean['age'] === "1") {
                        echo "selected";
                    }?>>~19歳</option>
                    <option value="2" <?php if (!empty($clean['age']) && $clean['age'] === "2") {
                        echo "selected";
                    }?>>20歳~29歳</option>
                    <option value="3" <?php if (!empty($clean['age']) && $clean['age'] === "3") {
                        echo "selected";
                    }?>>30歳~39歳</option>
                    <option value="4" <?php if (!empty($clean['age']) && $clean['age'] === "4") {
                        echo "selected";
                    }?>>40歳~49歳</option>
                    <option value="5" <?php if (!empty($clean['age']) && $clean['age'] === "5") {
                        echo "selected";
                    }?>>50歳~59歳</option>
                    <option value="6" <?php if (!empty($clean['age']) && $clean['age'] === "6") {
                        echo "selected";
                    }?>>60歳~</option>
                </select>
            </div>

            <!-- お問い合わせ内容 -->
            <div class="element_wrap">
                <label>お問い合わせ内容</label>
                <textarea name="contact"><?php if (!empty($clean['contact'])) {
                    echo $clean['contact'];
                }?></textarea>
            </div>

            <!-- ファイル添付 -->
            <div class="element_wrap">
                <label>画像ファイルの添付</label>
                <input type="file" name="attachment_file">
            </div>

            <!-- プライバシーポリシー -->
            <div class="element_wrap">
                <label for="agreement">
                    <input type="checkbox" name="agreement" id="agreement" value="1" <?php if (!empty($clean['agreement']) && $clean['agreement'] === "1") {
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
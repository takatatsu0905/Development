<?php
// ローカル環境でのメール送信テスト確認用
if (mb_send_mail('TAKATATSUtest@gmail.com', 'メール送信テスト:テスト', 'これはメールテストです。')) {
echo '送信完了';
} else {
echo '送信失敗';
}
?>
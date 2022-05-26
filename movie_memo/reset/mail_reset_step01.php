<?php
session_start();

//DB接続
try{
    $pdo=new PDO('XXXXXXXX;
    dbname=XXXXXXXX',
    'ID',
    'PW');
}catch(PDOException $e){
echo '接続できませんでした。';
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/mail_reset_step02.css">
    <title>Document</title>
</head>
<body>
<?php
$button = filter_input(INPUT_POST,'button_send');
$mail = filter_input(INPUT_POST,'mail');

echo '<h1>パスワードリセット</h1>';
echo '<form method="post">';
echo '<div class="input_position">';
echo '<input type="mail" name="mail" pattern=".+\.[a-zA-Z0-9][a-zA-Z0-9-]{0,61}[a-zA-Z0-9]" required>';
echo '<button type="submit" name="button_send">メールを送る</button>';
echo '</div>';
echo '</form>';

    //メールアドレス登録チェック
    if(isset($mail)){
        $sql=$pdo->prepare('select * from user where mail=?');
        $sql -> bindvalue(1,$_POST['mail']);
        $sql->execute();
            foreach($sql as $result){
        //セッションに格納
                $_SESSION['user_reset'] = ['user_id'=>$result['user_id'],'user_name'=>$result['user_name'],'password'=>$result['password'],'mail'=>$result['mail']];
        }
    }
        //該当無し
        if(!isset($_SESSION['user_reset']) && isset($button)){
            echo '<div class="message_err">';
            echo 'このメールアドレスは登録されていません','<br>';
            echo '</div>';
        //該当あり
        }else if(isset($_SESSION['user_reset'])){
            echo '<div class="message_ok">';
            echo 'パスワード変更のメールを送りました','<br>';
            echo '</div>';
    }

    //メールアドレス送信
    if(isset($_SESSION['user_reset'])){
        mb_language('Japanese');
        mb_internal_encoding('UTF-8');
        $to = $_SESSION['user_reset']['mail'];
        $title = 'パスワードリセットについて';
        $message =
        '下記にパスワードリセットのURLを送りました。
        http://aso2001378.boo.jp/Movie_memo/reset/mail_reset_step02.php';
        $header = 'From:映画Memo';
        mb_send_mail($to,$title,$message,$header);
    }

    //ログイン画面に遷移
    echo '<div class="button_login_position">';
    echo '<a href="../login/login.php" class="button_login">ログイン画面に戻る</a>';
    echo '</div>';
?>
</body>
</html>
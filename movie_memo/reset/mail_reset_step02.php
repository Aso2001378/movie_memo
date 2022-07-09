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

//PHP空白判定
$button = filter_input(INPUT_POST,'button');
$password = filter_input(INPUT_POST,'password');
$password_02 = filter_input(INPUT_POST,'password_02');
if(isset($button)){
    if(empty($password) && !empty($button))
    $message = '入力してください';
}

//パスワードをアップデート
if(isset($button) && ($password == $password_02)){
    $sql = $pdo->prepare('update user set password=? where user_name =  "'.$_SESSION['user_reset']['user_name'].'"');
    $sql -> bindvalue(1,$_POST['password']);
    $sql -> execute();
    session_destroy();
    echo '<script>location.href="../reset/mail_reset_step03.php";</script>';
}

//パスワード一致チェック
if(isset($button)){
    if($password != $password_02)
        $pass_result = 'パスワードが一致しません';
    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/mail_reset_step02.css">
    <title>mail_result_step-02</title>
</head>
<body>
<?php
if(isset($_SESSION['user_reset'])){
    echo '<div class="user_name">';
    echo $_SESSION['user_reset']['user_name'],'さんの新しいパスワード','<br>';
    echo '</div>';
    echo '<form method="post">';
    echo '<div class="input_position">';
    echo '<input type="password" name="password" required>','<br>';
    echo '<input type="password" name="password_02" required>','<br>';
    echo '</div>';
    //入力確認メッセージ
    if(isset($message)){
        echo '<div class="message">';
        echo $message,'<br>';
        echo '</div>';
    }
    //パスワード一致エラー
    if(isset($pass_result)){
        echo '<div class="message">';
        echo $pass_result,'<br>';
        echo '</div>';
    }
        echo '<div class="button_send">';
        echo '<button type="submit" name="button">決定</button>';
        echo '</div>';
        echo '</form>';
}else{
    echo 'セッションに値が入っていません。','<br>';
    echo '<div class="button_login_position">';
    echo '<a href="../login/login.php" class="button_login">ログイン画面に戻る</a>';
    echo '</div>';
}

?>
</body>
</html>
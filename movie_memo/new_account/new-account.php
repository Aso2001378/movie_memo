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

<?php
//PHP空白判定
$add = filter_input(INPUT_POST,'add');
$user_name = filter_input(INPUT_POST,'user_name');
$password_01 = filter_input(INPUT_POST,'password_01');
$password_02 = filter_input(INPUT_POST,'password_02');
$mail = filter_input(INPUT_POST,'mail');
if(isset($add)){
    if(empty($user_name))
    echo 'ユーザー名が入力されていません','<br>';
    if(empty($password_01))
    echo 'パスワードが入力されていません','<br>';
    if(empty($password_02))
    echo 'パスワードが入力されていません','<br>';
    if(empty($mail))
    echo 'メールアドレスが入力されていません','<br>';
}

//ユーザー名重複チェック
if(isset($add)){
    $sql = $pdo->prepare('select * from user where user_name="'.$user_name.'"');
    $sql -> execute();
    foreach($sql as $name){
        if($name == true)
        $user_name_result = 'このユーザー名はすでに登録されています。';
        }
    }

//パスワード一致チェック
if(isset($add)){
if($password_01 != $password_02)
    $pass_result = 'パスワードが一致しません';
}

//メールアドレス重複チェック
if(isset($add)){
$sql = $pdo->prepare('select * from user where mail="'.$mail.'"');
$sql -> execute();
foreach($sql as $address){
    if($address == true)
    $mail_result = 'このメールアドレスはすでに登録されています。';
    }
}

//DBに情報を登録
//str_replaceで空白消去
if(isset($add)){
if(!isset($mail_result) && !isset($pass_result) && !isset($user_name_result))
$user_name = str_replace(array(" ", "　"), "", $user_name);
$password_02 = str_replace(array(" ", "　"), "", $password_02);
$mail = str_replace(array(" ", "　"), "", $mail);
    $sql = $pdo->prepare('insert into user (user_name,password,mail) values(?,?,?)');
    $sql -> bindvalue(1,$user_name);
    $sql -> bindvalue(2,$password_02);
    $sql -> bindvalue(3,$mail);
    $sql -> execute();
}

//内容をセッションに保持
if(isset($add)){
$sql=$pdo->prepare('select * from user where user_name=? and password=?');
$sql -> bindvalue(1,$user_name);
$sql -> bindvalue(2,$password_02);
$sql->execute();
foreach($sql as $push){
$_SESSION['user']=['user_id'=>$push['user_id'],'user_name'=>$push['user_name'],'password'=>$push['password'],'mail'=>$push['mail']];
    }
}

//セッションが保持されたら
if(isset($_SESSION['user'])){
    echo '<script>location.href="../index/index.php";</script>';
}
?>



<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0">
    <link rel="stylesheet" href="../css/account.css">
    <title>New account</title>
</head>
<body>
<h1>新規登録</h1>
<div class="text">
<p>※ユーザー名(英数字4~12文字以内)<br>※パスワード(英数字4~8文字以内)</p>
</div>
<div class="new_account">
<form method="post">
<!-- 英数字4~12文字以内 -->
<input type="text" name="user_name" value="" pattern="[0-9A-Za-z0-9]{4,12}"  placeholder="ユーザー名" required>
<?php
if(isset($user_name_result)){
    echo '<div class="add_err">';
    echo $user_name_result;
    echo '</div>';
}
?>
<br>
<!-- 英数字4~8文字以内 -->
<input type="password" name="password_01" value="" pattern="[0-9A-Za-z0-9]{4,8}" placeholder="パスワード" required><br>
<input type="password" name="password_02" value="" pattern="[0-9A-Za-z0-9]{4,8}" placeholder="パスワード(確認用)" required>
<?php
if(isset($pass_result)){
    echo '<div class="add_err">';
    echo $pass_result;
    echo '</div>';
}
?>
<br>
<!-- 普通の形式 -->
<input type="email" name="mail" value="" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" placeholder="メールアドレス" required>
<?php
if(isset($mail_result)){
    echo '<div class="add_err">';
    echo $mail_result;
    echo '</div>';
}
?>
<br>
    <button type="submit" class="button" name="add">登録</button>
</form>
</div>
</body>
</html>

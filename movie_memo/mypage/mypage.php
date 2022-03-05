<?php
session_start();
//最新版

try{
    $pdo=new PDO('mysql:host=mysql154.phy.lolipop.lan;
    dbname=LAA1290628-upup;charset=utf8',
    'LAA1290628',
    'Shion0724');
}catch(PDOException $e){
echo '接続できませんでした。';
}
?>




<?php



if(isset($_POST['logout'])){
session_destroy();
echo '<script>location.href="../login/login.php";</script>';
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/mypage.css">
    <title>Document</title>
</head>
<body>
<?php
require('../header/header.php');
?>
<h1 class="title_mypage">マイページ</h1>

<?php


//ユーザー名を変更の場合
if(!empty($_POST['user_name'])){
    $sql = $pdo->prepare('update user set user_name=? where user_id = "'.$_SESSION['user']['id'].'"');
    $sql -> bindvalue(1,$_POST['user_name']);
    $sql -> execute();
        $result = '<p>ユーザー名を変更しました</p>';
        echo '<hr>';
        echo $result;
}

if(!empty($_POST['user_name'])){
    echo '<div class="change_info">';
    echo '変更後のユーザー名：'.$_POST['user_name'],'<br>';
    echo '</div>';
    echo '<hr>';
}



//パスワードを変更の場合
if(!empty($_POST['password'])){
    $sql = $pdo->prepare('update user set password=? where user_id =  "'.$_SESSION['user']['id'].'"');
    $sql -> bindvalue(1,$_POST['password']);
    $sql -> execute();
        $result = '<p>パスワードを変更しました</p>';
        echo '<hr>';
        echo $result;
}


if(!empty($_POST['password'])){
    echo '<div class="change_info">';
    echo '変更後のパスワード：'.$_POST['password'],'<br>';
    echo '</div>';
    echo '<hr>';
}


//PHP空白判定
$button = filter_input(INPUT_POST,'button');
$user_name = filter_input(INPUT_POST,'user_name',);
$password = filter_input(INPUT_POST,'password',);
if(isset($button)){
    if(empty($user_name) || empty($password))
    echo '<div class="message">';
    echo '入力してください','<br>';
    echo '</div>';
}


//セッションに保存されている場合
if(isset($_SESSION['user'])){
echo '<form method="post">';
echo '<div class="user_id">';
echo '<p>ユーザーID</p>';
echo $_SESSION['user']['id'],'<br>';
echo '</div>';
//英字4~12文字以内
echo '<p>英数字4~12文字以内で入力</p>';
echo '<div class="user_name">';
echo '<label for="user_name">ユーザー名</label><input type="text" name="user_name" id="user_name" value="" pattern="[0-9A-Za-z0-9]{4,12}" placeholder="入力してください" >';
echo '</div>';
//英数字4~8文字以内
echo '<p>英数字4~8文字以内で入力</p>';
echo '<div class="password">';
echo '<label for="password">パスワード</label><input type="password" name="password" id="password" value="" pattern="[0-9A-Za-z0-9]{4,8}" placeholder="入力してください" >';
echo '</div>';
echo '<p>メールアドレス</p>';
echo '<div class="mail">';
echo $_SESSION['user']['mail'],'<br>';
echo '</div>';
echo '<div class="button_01">';
echo '<button type="submit" class="change" name="button">変更</button>','<br>';
echo '</div>';
echo '<div class="button_02">';
echo '<button type="submit" class="logout" name="logout">ログアウト</button>';
echo '</div>';
echo '</form>';
//セッションに保存されていない場合
}else{
    echo '<div class="menu">';
    echo '<a class="login" href="../login/login.php">ログイン</a>','<br>';
    echo '</div>';
    echo '<div class="menu">';
    echo '<a class="new_account" href="../new_account/account.php">新規登録</a>';
    echo '</div>';
}
?>




</body>
</html>


<?php
session_start();
?>

<?php
if(isset($_POST['logout'])){
session_destroy();
echo '<script>location.href="../login/login.php";</script>';
}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/mypage.css">
    <title>My page</title>
</head>
<body>
<?php
require('../header/header.php');
?>

<h1 class="title">マイページ</h1>
<?php
//PHP空白判定
$button = filter_input(INPUT_POST,'button');
$user_name = filter_input(INPUT_POST,'user_name');
$password = filter_input(INPUT_POST,'password');
$mail = filter_input(INPUT_POST,'mail');
if(isset($button)){
    if(empty($user_name) || empty($password) || empty($mail))
    echo '<div class="message">';
    echo '入力してください','<br>';
    echo '</div>';
}

//ユーザー名を変更の場合
if(!empty($user_name)){
    //ユーザー名の重複チェック
    $sql = $pdo->prepare('select * from user where user_name="'.$user_name.'"');
    $sql -> execute();
    foreach($sql as $name){
    if($name == true)
    $user_name_result = 'このユーザー名はすでに登録されています';
    }
}
    if(empty($user_name_result) && !empty($user_name)){
        $user_name = str_replace(array(" ", "　"), "", $user_name);
        $sql = $pdo->prepare('update user set user_name=? where user_id =  "'.$_SESSION['user']['user_id'].'"');
        $sql -> bindvalue(1,$user_name);
        $sql -> execute();
        echo '<hr>';
        echo '<p>ユーザー名を変更しました</p>';
        echo '<div class="change_info">';
        echo '変更後のユーザー名：'.$user_name,'<br>';
        echo '</div>';
        echo '<hr>';
    }

//パスワードを変更の場合
if(!empty($password)){
    $password = str_replace(array(" ", "　"), "", $password);
    $sql = $pdo->prepare('update user set password=? where user_id =  "'.$_SESSION['user']['user_id'].'"');
    $sql -> bindvalue(1,$password);
    $sql -> execute();
    echo '<hr>';
    echo '<p>パスワードを変更しました</p>';
    echo '<div class="change_info">';
    echo '変更後のパスワード：'.$password,'<br>';
    echo '</div>';
    echo '<hr>';
}

//メールアドレスを変更の場合
if(!empty($mail)){
//メールアドレス重複チェック
    $sql = $pdo->prepare('select * from user where mail="'.$mail.'"');
    $sql -> execute();
    foreach($sql as $mail){
        if($mail == true)
        $mail_result = 'このメールアドレスはすでに登録されています';
    }
}
        if(empty($mail_result) && !empty($mail)){
            $sql = $pdo->prepare('update user set mail=? where user_id =  "'.$_SESSION['user']['user_id'].'"');
            $sql -> bindvalue(1,$_POST['mail']);
            $sql -> execute();
            echo '<hr>';
            echo '<p>メールアドレスを変更しました</p>';
            echo '<div class="change_info">';
            echo '変更後のメールアドレス：'.$mail,'<br>';
            echo '</div>';
            echo '<hr>';
        }

//セッションに保存されている場合
if(isset($_SESSION['user'])){
echo '<form method="post">';
echo '<div class="user_id">';
echo '<p>ユーザーID</p>';
echo $_SESSION['user']['user_id'],'<br>';
echo '</div>';
//ユーザー名
echo '<label for="user_name"><p>英数字4~12文字以内で入力</p></label>';
echo '<div class="input_text">';
echo '<input type="text" name="user_name" id="user_name" value="" pattern="[0-9A-Za-z0-9]{4,12}" placeholder="ユーザー名" >';
echo '</div>';
if(isset($user_name_result)){
    echo '<div class="message">';
    echo $user_name_result;
    echo '</div>';
}
//パスワード
echo '<label for="password"><p>英数字4~8文字以内で入力</p></label>';
echo '<div class="input_text">';
echo '<input type="password" name="password" id="password" value="" pattern="[0-9A-Za-z0-9]{4,8}" placeholder="パスワード" >';
echo '</div>';
echo '<br>';
//メールアドレス
echo '<div class="mail">';
echo '<input type="mail" name="mail" value="" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" placeholder="メールアドレス" >';
echo '</div>';
if(isset($mail_result)){
    echo '<div class="message">';
    echo $mail_result;
    echo '</div>';
}

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


<?php
session_start();
//最新版
//エラー非表示(再度メアドを入力した場合表示される)//
// error_reporting(0);
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
//PHP空白判定
$add = filter_input(INPUT_POST,'add');
$user_name = filter_input(INPUT_POST,'user_name');
$password_01 = filter_input(INPUT_POST,'password_01');
$password_02 = filter_input(INPUT_POST,'password_02');
$mail = filter_input(INPUT_POST,'mail',);
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

//パスワード一致チェック
if(isset($add)){
if($password_01 != $password_02)
    $pass_result = 'パスワードが一致しません';
}



//メールアドレス重複チェック
if(isset($add)){
$sql = $pdo->prepare('select * from user where mail="'.$_POST['mail'].'"');
$sql -> execute();
foreach($sql as $row){
    if($row == true)
    $mail_result = 'このメールアドレスはすでに登録されています。別のメールアドレスで登録お願いします';
    }
}


//DBに情報を登録
if(isset($add)){
if(!isset($result) && !isset($pass_result))
    $sql = $pdo->prepare('insert into user (user_name,password,mail) values(?,?,?)');
    $sql -> bindvalue(1,$_POST['user_name']);
    $sql -> bindvalue(2,$_POST['password_02']);
    $sql -> bindvalue(3,$_POST['mail']);
    $sql -> execute();
}


//内容をセッションに保持
if(isset($_POST['add'])){
$sql=$pdo->prepare('select * from user where user_name=? and password=?');
$sql->execute([$_POST['user_name'],$_POST['password_02']]);
foreach($sql as $row){
$_SESSION['user']=['id'=>$row['user_id'],'user'=>$row['user_name'],'password'=>$row['password'],'mail'=>$row['mail']];
}
}


//セッションが保持されたら
if(isset($_SESSION['user'])){
    echo '<script>location.href="../index/index.php";</script>';
}

?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0">
    <link rel="stylesheet" href="../css/account.css">
    <title>Document</title>
</head>
<body>
<h1>新規登録</h1>
<p class="text_01">メールアドレスは登録後、変更できません</p>
<?php
if(isset($pass_result)){
    echo '<div class="pass_err">';
    echo $pass_result,'<br>';
    echo '</div>';
}
if(isset($mail_result)){
    echo '<div class="mail_err">';
    echo $mail_result,'<br>';
    echo '</div>';
}
?>
<div class="new_account">
<form method="post">
<!-- 英数字4~12文字以内 -->
<p class="text">ユーザー名<span>(英数字4~12文字以内)</span></p>
<input type="text" class="input" name="user_name" value="" pattern="[0-9A-Za-z0-9]{4,12}"  placeholder="入力してください" required>
<!-- 英数字4~8文字以内 -->
<p class="text">パスワード<span>(英数字4~8文字以内)</span></p>
<input type="password" class="input" name="password_01" value="" pattern="[0-9A-Za-z0-9]{4,8}" placeholder="入力してください" required><br>
<p class="text">パスワード<span>(確認用)</span></p>
<input type="password" class="input" name="password_02" value="" pattern="[0-9A-Za-z0-9]{4,8}" placeholder="入力してください" required><br>
<!-- 普通の形式 -->
<p class="text">メールアドレス</p>
<input type="email" class="input" name="mail" value="" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" placeholder="入力してください" required><br>
    <button type="submit" class="button" name="add">登録</button>
</form>
</div>
</body>
</html>

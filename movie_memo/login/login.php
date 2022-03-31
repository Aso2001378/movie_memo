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


//POSTが入っている場合[ユーザー名][パスワード]
if(isset($_POST['user_name']) || isset($_POST['password'])){
    try{
    $sql=$pdo->prepare('select * from user where user_name=? and password=?');
    $sql->execute([$_POST['user_name'],$_POST['password']]);
    foreach($sql as $push){
    //セッションに格納
    $_SESSION['user']=['user_id'=>$push['user_id'],'user_name'=>$push['user_name'],'password'=>$push['password'],'mail'=>$push['mail']];
    }
    //格納無し
    if(!isset($_SESSION['user'])){
        $message = 'ユーザー名かパスワードが違います';
    }
}catch(PDOException $e){
    echo 'エラー';
    }
}
//セッション格納している場合
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
<link rel="stylesheet" href="../css/login.css">
<title>Document</title>
</head>
<body>
    <h1>映画<br>Memo</h1>
        <div class="img">
            <img src="../img/cat.jpg" alt="">
        </div>
<form  method="post">
<?php
if(isset($message)){
    echo '<div class="message_err">';
    echo $message;
    echo '</div>';
}
?>
<div class="login">
    <label for="user"><p>ユーザー名</p></label>
    <p><input type="text" name="user_name" id="user" value="meetboy" placeholder="入力してください" required></p>
    <label for="password"><p>パスワード</p></label>
    <p><input type="password" name="password" id="password" value="12345" placeholder="入力してください" required></p>
    <div class="button_push">
    <button type="submit" class="button" name="login">ログイン</button>
</div>
</div>
</form>
<div class="margin">
    <p><a class="skip" href="../index/index.php">スキップする</a></p>
</div>
</body>
</html>
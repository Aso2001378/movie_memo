<?php
session_start();

try{
    $pdo=new PDO('mysql:host=mysql154.phy.lolipop.lan;
    dbname=LAA1290628-upup;charset=utf8',
    'LAA1290628',
    'Shion0724');
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
    <link rel="stylesheet" href="../css/comment.css">
    <title>Document</title>
</head>

<?php
require('../header/header.php');
?>

<body>

<div class="box">
    <label for="check"><span class="click">説明</span></label>
    <input type="checkbox" id="check">
    <div class="message">
<p>※未ログインの場合、名前にゲストと表示されます</p>
<p>※ログイン済みの場合、ユーザー名が表示されます</p>
    </div>
</div>

<?php
echo '<div class="contents">';
echo '<p>名前</p>';
echo '<form method="post">';
//セッションが保持されている場合
if(isset($_SESSION['user'])){
echo '<input id="user_name" type="text" class="user" name="user_name"  value="'.$_SESSION['user']['user'].'" readonly><br>';
}else{
echo '<input id="user_name" type="text" class="user" name="user_name" value="ゲスト" readonly><br>';
}
echo '<p>内容(140文字以内)</p>';
echo '<textarea id="contents" name="contents" cols="40" rows="8" pattern="{1,140}" placeholder="内容を入力してください" required></textarea>','<br>';
echo '<button type="submit" class="button" name="submit">投稿</button>';
echo '</form>';
echo '</div>';
?>
<?php
//内容が有る場合
if(!empty($_POST['contents'])){
$sql = $pdo->prepare('insert into comment(user_name,contents) values(?,?)');
$sql -> bindvalue(1,$_POST['user_name']);
$sql -> bindvalue(2,$_POST['contents']);
$sql -> execute();
echo '<div class="result">';
echo '入力完了しました';
echo '</div>';
}


echo '<hr>';
//最新50件まで表示
    $sql=$pdo->prepare("select * from comment order by post_at desc limit 50");
    $sql->execute();
        foreach($sql as $row){
    echo '<div class="comment">';
    echo '<div class="name">';
    echo $row['user_name'],'：';
    echo $row['post_at'],'<br>';
    echo '</div>';
    echo $row['contents'];
    echo '</div>';
    }



$pdo = null;


?>
<div class="margin"></div>
</body>
</html>



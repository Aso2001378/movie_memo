<?php
session_start();
?>

<?php
//PHP空白判定
$contents_err = '入力されていません';
$contents_add = '入力完了しました';
$contents = filter_input(INPUT_POST,'contents');
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/comment.css">
    <title>Comment</title>
</head>
<body>
<?php
require('../header/header.php');
?>

<div class="text_box">
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
echo '<input id="user_name" type="text" class="user" name="user_name"  value="'.$_SESSION['user']['user_name'].'" readonly><br>';
}else{
echo '<input id="user_name" type="text" class="user" name="user_name" value="ゲスト" readonly><br>';
}
echo '<p>内容(140文字以内)</p>';
echo '<textarea id="contents" name="contents" cols="40" rows="8" maxlength="140" placeholder="内容を入力してください" required></textarea>','<br>';
echo '<button type="submit" class="button" name="submit">投稿</button>';
echo '</form>';
echo '</div>';
?>

<?php
//内容が有る場合
if(!empty($contents)){
$sql = $pdo->prepare('insert into comment(user_name,contents) values(?,?)');
$sql -> bindvalue(1,$_POST['user_name']);
$sql -> bindvalue(2,$_POST['contents']);
$sql -> execute();
echo '<div class="result">';
echo $contents_add;
echo '</div>';
}

//内容がない場合
if(isset($submit)){
    if(isset($contents_err))
        echo '<div class="result">';
        echo $contents_err;
        echo '</div>';
}


echo '<hr>';
//最新50件まで表示
    $sql=$pdo->prepare("select * from comment order by post_at desc limit 50");
    $sql -> bindvalue(1,$contents);
    $sql->execute();
        foreach($sql as $result){
    echo '<div class="comment">';
    echo '<div class="name">';
    echo $result['user_name'],'：';
    echo $result['post_at'],'<br>';
    echo '</div>';
    echo $result['contents'];
    echo '</div>';
    }


?>
<div class="margin"></div>
</body>
</html>



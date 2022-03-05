<?php
session_start();

//DB接続//
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="stylesheet" href="../css/style.css">
    <title>Document</title>
</head>
<body>
<?php
require('../header/header.php');
?>

<label for="name"><h1 class="title">映画リスト</h1></label>

<?php
//PHP空白判定//
$add = filter_input(INPUT_POST,'add');
$delete = filter_input(INPUT_POST,'delete');
$contents = filter_input(INPUT_POST,'contents',);
$check = filter_input(INPUT_POST,'check',);
if(isset($add)){
    if(empty($contents))
    echo '<div class="message">';
    echo '内容を入力してください';
    echo '</div>';
}
if(isset($delete)){
    if(empty($check))
    echo '<div class="message">';
    echo 'チェックを入れてください';
    echo '</div>';
}


echo '<form method="post">';
//セッションが入っている場合
if(isset($_SESSION['user'])){
echo '<div class="user_id_none">';
echo 'ユーザーID：<input type="text" name="login_id" value="'.$_SESSION['user']['id'].'" readonly>','<br>';
echo '</div>';
}

//内容追加
echo '<div class="movie_name">';
echo '<input type="text" name="contents" id="name" value="" placeholder="入力してください">';
echo '</div>';
echo '<div class="button_click">';
echo '<button type="submit" class="add" name="add"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" stroke-width="1.5" stroke="#000000" fill="none" class="duration-302 transform transition-all" style="width: 38px; height: 38px;"><path d="M32 7v50M7 32h50"></path></svg></button>';
echo '</form>';

//内容消去
echo '<form id="check" method="post">';
echo '<button type="submit" class="delete" name="delete"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" stroke-width="1.5" stroke="#000000" fill="none" class="duration-302 transform transition-all" style="width: 38px; height: 38px;"><path d="M45.49 54.87h-27a1 1 0 01-1-1l-2-36h32.97l-2 36a1 1 0 01-.97 1zM51 17.86H13c-.28 0-.5-.16-.5-.35l.93-4.35a.49.49 0 01.5-.3h36.14a.49.49 0 01.5.3l.93 4.35c0 .19-.22.35-.5.35zM24 23.44v25M32 23.44v25M40 23.44v25"></path><path d="M25.73 12.86V7.57a1 1 0 011-1h10.54a1 1 0 011 1v5.29"></path></svg></button>';
if(isset($_POST['check'])){
    $check =  $_POST['check'];
    foreach($check as $name){
        //チェックされている
        $sql=$pdo->prepare('delete from text where login_id = "'.$_SESSION['user']['id'].'" and check_id = "'.$name.'"');
        $sql -> bindvalue(1,$name);
        $sql -> execute();
    }
}
echo '</form>';
echo '</div>';
?>

<?php
//ログイン中のIDと書き込み内容をDBに登録//
if(isset($_SESSION['user']) && isset($_POST['add']) && !empty($_POST['contents'])){
$sql = $pdo->prepare('insert into text(login_id,contents) values(?,?)');
$sql -> bindvalue(1,$_POST['login_id']);
$sql -> bindvalue(2,$_POST['contents']);
$sql -> execute();
}


//ユーザーIDによって違う内容を表示//
echo '<hr>';
if(isset($_SESSION['user']['id'])){
$sql=$pdo->prepare('select * from text where login_id = "'.$_SESSION['user']['id'].'" order by check_id desc');
$sql->execute();
foreach($sql as $row){
// echo '<form method="post">';
echo '<div class="contents_name">';
echo $row['contents'];
echo '<input type="checkbox" name="check[]" id="check_box" form="check" value="'.$row['check_id'].'" >';
echo '</div>';
echo '<br>';
    }
}


//未登録でPOSTされた場合
if(!isset($_SESSION['user'])){
    echo '<p>未ログインの場合、内容は保存されません</p>';
    if(isset($_POST['contents']))
        echo $_POST['contents'];
}



?>

<div class="margin"></div>
</body>
</html>

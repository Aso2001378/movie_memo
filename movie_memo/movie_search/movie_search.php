<?php
//TMDbのAPIキー
$api_key = 'XXXXXXXXXXXXXXXXX';
//URL
$url = 'https://api.themoviedb.org';
//GETでURLから取得
if(isset($_GET['title'])){
$contents =  file_get_contents($url.'/3/search/movie?api_key='.$api_key.'&language=ja-JA&query='.$_GET['title'].'&page=1&include_adult=false');
$movie = json_decode($contents, true);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0">
<link rel="stylesheet" href="../css/movie_search.css">
<title>Document</title>
</head>
<body>

<?php
require('../header/header.php');
?>

<h1 class="search_title">映画検索</h1>
<form>
<div class="movie">
    <label for="movie"><p>映画タイトル</p></label>
    <input type="text" name="title" id="movie"  value="" placeholder="入力してください" maxlength="30" required>
    <button type="submit" class="button" name="submit">検索</button>
</div>
</form>
<hr>

<?php
if(isset($movie)){
    foreach($movie['results'] as $result){
    $title = $result['title'];
    echo '<div class="movie_title">';
    echo $title,'<br>';
    echo '</div>';
    }
}
?>

<div class="margin"></div>
</body>
</html>
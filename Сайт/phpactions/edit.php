<?php
$dbinfo = 'mysql:host=localhost;dbname=forum';
$forum = new PDO($dbinfo, 'root');

if((isset($_POST['Title']) && $_POST['Title'] == '') || $_POST['Content'] == '') {
    echo 'Ошибка. Пожалуйста, введите название и содержание темы.';
    exit();
}

$sql='';

if($_POST['is_post'])
    $sql = 'UPDATE `ForumPosts` SET Content = :new_content, Title = :new_title WHERE post_id = :id';
else
    $sql = 'UPDATE `Comments` SET ComContent = :new_content WHERE com_id = :id';

$query = $forum->prepare($sql);

if($_POST['is_post'])
    $query->execute(['id' => $_POST['id'], 'new_content' => nl2br($_POST['Content']), 'new_title' => $_POST['Title']]);
else
    $query->execute(['id' => $_POST['id'], 'new_content' => nl2br($_POST['Content'])]);

$path = 'Location: /forums/post.php?id='.$_POST['postid'];
header($path);
?>
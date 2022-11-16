<?php


$dbinfo = 'mysql:host=localhost;dbname=forum';
$forum = new PDO($dbinfo, 'root');

if($_POST['Title'] == '' || $_POST['Content'] == '') {
    echo 'Ошибка. Пожалуйста, введите название и содержание темы.';
    exit();
}

$sqlc = 'INSERT INTO forumposts(Title, Content, PostDate, LastComment, topic_id, u_id) VALUES(:title, :content, :postd, :lcom, :topid, :poster)';

date_default_timezone_set('Europe/Moscow');
$curdate = new DateTime();

$query = $forum->prepare($sqlc);
$query->execute(['title' => $_POST['Title'], 'content' => nl2br($_POST['Content']), 'postd' => date_format($curdate, 'Y-m-d H:i:s'), 'lcom' => date_format($curdate, 'Y-m-d H:i:s'), 'topid' => $_POST['id'], 'poster' => $_COOKIE["id"]]);

$path = 'Location: /forums/topics.php?id='.$_POST['id'];
header($path);
?>
<?php

$dbinfo = 'mysql:host=localhost;dbname=forum';
$forum = new PDO($dbinfo, 'root');

if($_POST['Content'] == '') {
    echo 'Ошибка. Пожалуйста, введите название и содержание темы.';
    exit();
}

date_default_timezone_set('Europe/Moscow');
$curdate = new DateTime();

$sqlc = 'INSERT INTO comments(ComContent, ComDate, post_id, u_id) VALUES(:content, :comd, :postid, :poster)';
$query = $forum->prepare($sqlc);
$query->execute(['content' => nl2br($_POST['Content']), 'comd' => date_format($curdate, 'Y-m-d H:i:s'), 'postid' => $_POST['id'], 'poster' => $_COOKIE["id"]]);

$sqlpc = 'UPDATE `forumposts` SET `lastcomment` = :comdate WHERE post_id =:postid';
$query1 = $forum->prepare($sqlpc);
$query1->execute(['comdate' => date_format($curdate, 'Y-m-d H:i:s'), 'postid' => $_POST['id']]);

$path = 'Location: /forums/post.php?id='.$_POST['id'];
header($path);
?>
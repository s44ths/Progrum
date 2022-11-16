<?php
$dbinfo = 'mysql:host=localhost;dbname=forum';
$forum = new PDO($dbinfo, 'root');

$comdel = 'DELETE FROM `comments` WHERE com_id = :comid';
$query = $forum->prepare($comdel);
$query->execute(['comid' => $_POST['comid']]);

$path = 'Location: '.($_POST['urladress']);
header($path);
?>
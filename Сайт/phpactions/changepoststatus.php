<?php
$dbinfo = 'mysql:host=localhost;dbname=forum';
$forum = new PDO($dbinfo, 'root');

$sql = 'UPDATE `forumposts` SET isClosed = :newstatus WHERE post_id = :p_id';
$query = $forum->prepare($sql);
$query->execute(['newstatus' => !($_POST['post_status']), 'p_id' => $_POST['postid'] ]);

$path = 'Location: /forums/topics.php?id='.$_POST['gtopicid'];
header($path);
?>
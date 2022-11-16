<?php
$dbinfo = 'mysql:host=localhost;dbname=forum';
$forum = new PDO($dbinfo, 'root');

$selectallcomments = 'SELECT com_id FROM `comments` WHERE post_id = :postid';
$querycomslist = $forum->prepare($selectallcomments);
$querycomslist->execute(['postid' => $_POST['postid']]);

while($row = $querycomslist->fetch(PDO::FETCH_OBJ)) {
    $deletecomments = 'DELETE FROM `comments` WHERE com_id = :commentid';
    $querydelcom = $forum->prepare($deletecomments);
    $querydelcom->execute(['commentid' => $row->com_id]);
}

$deletepost = 'DELETE FROM `forumposts` WHERE post_id = :postid';
$querydelpost = $forum->prepare($deletepost); 
$querydelpost->execute(['postid' => $_POST['postid']]);

$path = 'Location: /forums/topics.php?id='.$_POST['gtopicid'];
header($path);
?>
<?php
$dbinfo = 'mysql:host=localhost;dbname=forum';
$forum = new PDO($dbinfo, 'root');

if($_POST['Reason'] == ''){
    echo 'Пожалуйста, опишите причину блокировки.';
    exit();
}

$getcntbans = 'SELECT COUNT(*) FROM `bans` WHERE banned_id = :cur_user';
$querycntbans = $forum->prepare($getcntbans);
$querycntbans->execute(['cur_user' => $_POST['banned']]);
$cntbans = $querycntbans->fetch(PDO::FETCH_ASSOC);

date_default_timezone_set('Europe/Moscow');
$curdate = new DateTime();
$curdate_form = date_format($curdate, 'Y-m-d H:i:s');
$block_end;

if(isset($_POST['isperma']) && $_POST['isperma'] == 'perma')
    $block_end = date('Y-m-d H:i:s', strtotime($curdate_form.'+ 1000 years'));
else if(current($cntbans) == 0)
    $block_end = date('Y-m-d H:i:s', strtotime($curdate_form.'+ 10 minutes'));
else if(current($cntbans) == 1)
    $block_end = date('Y-m-d H:i:s', strtotime($curdate_form.'+ 1 days'));
else if(current($cntbans) == 2)
    $block_end = date('Y-m-d H:i:s', strtotime($curdate_form.'+ 1 weeks'));
else if (current($cntbans) == 3)
    $block_end = date('Y-m-d H:i:s', strtotime($curdate_form.'+ 1 mounts'));
else 
    $block_end = date('Y-m-d H:i:s', strtotime($curdate_form.'+ 1000 years'));

$sql = 'INSERT INTO bans(banned_id, moder_id, BlockEnd, Explaination) VALUES(:banned, :moder, :BE, :reason)';
$query = $forum->prepare($sql);
$query->execute(['banned' => $_POST['banned'], 'moder' => $_POST['moder'], 'BE' => $block_end, 'reason' => $_POST['Reason']]);

header('Location: /userpage.php?id='.$_POST['banned'].'');
?>
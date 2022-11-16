<?php
if(!isset($_POST['Receiver']) || !isset($_POST['Topic']) || !isset($_POST['Msg_text'])){
    echo 'Ошибка. Введите имя получателя, тему сообщения и его содержание.';
    exit();
}

$dbinfo = 'mysql:host=localhost;dbname=forum';
$forum = new PDO($dbinfo, 'root');

$checkuser = 'SELECT u_id FROM `user` WHERE uLogin = :ulog';
$query_check = $forum->prepare($checkuser);
$query_check->execute(['ulog' => $_POST['Receiver']]);
$uinfo = $query_check->fetch(PDO::FETCH_ASSOC);

if(!is_countable($uinfo) || count($uinfo) == 0){
    echo 'Ошибка. Такого пользователя не существует.';
    exit();
}

date_default_timezone_set('Europe/Moscow');
$curdate = new DateTime();

$sql_msg = 'INSERT INTO `message`(Title, Content, isRead, u_id_s, u_id_r, MessageSent) VALUES(:title, :content, :readfalse, :sender, :receiver, :msdate)';
$query_sendmsg = $forum->prepare($sql_msg);
$query_sendmsg->execute(['title' => $_POST['Topic'], 'content' => nl2br($_POST['Msg_text']), 'readfalse' => 0, 'sender' => $_POST['Sender'], 'receiver' => current($uinfo), 'msdate' => date_format($curdate, 'Y-m-d H:i:s')]);

header('Location: /community/messages.php');

?>
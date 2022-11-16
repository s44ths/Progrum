<?php
$dbinfo = 'mysql:host=localhost;dbname=forum';
$forum = new PDO($dbinfo, 'root');

$comand = 'SELECT uPassword, u_id, Moder, Avatar FROM `user` WHERE uLogin = :ulog';
$query = $forum->prepare($comand);
$query->bindValue(":ulog", $_POST['Login'], PDO::PARAM_STR);
$query->execute();
$row = $query->fetch(PDO::FETCH_ASSOC);

if(!is_countable($row) || count($row) == 0 || current($row) != $_POST['Password']) {
    echo 'Ошибка, введены неверные данные';
    exit();
}

$isblocked = 'SELECT MAX(BlockEnd) FROM `bans` WHERE banned_id = :curuser';
$querycheckblock = $forum->prepare($isblocked);
$querycheckblock->execute(['curuser' => next($row)]);
$dateend = $querycheckblock->FETCH(PDO::FETCH_ASSOC);
                   
date_default_timezone_set('Europe/Moscow');
$datecheck = new DateTime();
$datecheck = date_format($datecheck, 'Y-m-d H:i:s');

$userid = current($row);

if(current($dateend) == null || $datecheck >= current($dateend)) {
    setcookie("Login", $_POST['Login'], time() + 3600*24);
    setcookie("id", current($row), time() + 3600*24);
    setcookie("moder", next($row), time() + 3600*24);
    setcookie("avatar", next($row), time() + 3600*24);
}

$path = 'Location: /userpage.php?id='.$userid;
header($path);
?>
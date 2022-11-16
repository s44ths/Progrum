<?php
$dbinfo = 'mysql:host=localhost;dbname=forum';
$forumposts = new PDO($dbinfo, 'root');

if($_POST['Password'] == '' || $_POST['Login'] == '') {
    echo 'Ошибка. Пожалуйста, введите логин и пароль.';
    exit();
}

if($_POST['Password'] != $_POST['PasswordConfirm']) {
    echo 'Пароли не совпадают';
    exit();
}

$comand = 'SELECT COUNT(*) FROM `user` WHERE uLogin = :ulog';
$query = $forumposts->prepare($comand);
$query->bindValue(":ulog", $_POST['Login'], PDO::PARAM_STR);
$query->execute();
$row = $query->fetch(PDO::FETCH_ASSOC);

if(current($row) > 0) {
    echo 'Данное имя пользователя уже занято. Выберите другой ник.';
    exit();
}

date_default_timezone_set('Europe/Moscow');
$curdate = new DateTime();

$sqlc = 'INSERT INTO user(uLogin, uPassword, Moder, Avatar, LastSeen) VALUES(:ulogin, :pass, :mod, :ava, :ls)';

$query1 = $forumposts->prepare($sqlc);
$query1->execute(['ulogin' => $_POST['Login'], 'pass' => $_POST['Password'], 'mod' => 0, 'ava' => 15, 'ls' => date_format($curdate, 'Y-m-d H:i:s')]);

$comand1 = 'SELECT u_id, Moder FROM `user` WHERE uLogin = :ulog';
$query1 = $forumposts->prepare($comand1);
$query1->bindValue(":ulog", $_POST['Login'], PDO::PARAM_STR);
$query1->execute();
$row1 = $query1->fetch(PDO::FETCH_OBJ);

setcookie("Login", $_POST['Login'], time() + 3600*24);
setcookie("id", $row1->u_id, time() + 3600*24);
setcookie("avatar", 15, time() + 3600*24);
setcookie("moder", 0, time() + 3600*24);

$path = 'Location: /userpage.php?id='.$row1->u_id;
header($path);
?>
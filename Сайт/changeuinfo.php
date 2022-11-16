<?php
$dbinfo = 'mysql:host=localhost;dbname=forum';
$forum = new PDO($dbinfo, 'root');

if(isset($_POST['Avatar'])) {
    $sql = 'UPDATE `user` SET Avatar = :ava WHERE u_id = :userid';
    $query = $forum->prepare($sql);
    $query->execute(['userid' => $_COOKIE['id'], 'ava' => $_POST['Avatar']]);
    setcookie ("avatar", "", time() - 3600*24);
    setcookie ("avatar", $_POST['Avatar'], time() + 3600*24);
}

else if($_POST['OldPassword'] != '' || $_POST['Password'] != '' || $_POST['Login'] != '') {

    if($_POST['Login'] == '' && $_POST['Password'] == ''){
        echo 'Ошибка. Введите данные для смены логина или пароля.';
        exit();
    }
    if($_POST['OldPassword'] == '') {
        echo 'Ошибка. Введите текущий пароль для подтверждения смены.';
        exit();
    }

    $comandpass = 'SELECT uPassword FROM `user` WHERE u_id = :userid';
    $querycheckp = $forum->prepare($comandpass);
    $querycheckp->execute(['userid' => $_COOKIE['id']]);
    $rowpass = $querycheckp->fetch(PDO::FETCH_ASSOC);

    if(current($rowpass) != $_POST['OldPassword']) {
        echo 'Ошибка. Неправильно введён текущий пароль.';
        exit();
    }
    
    if($_POST['Login'] != '') {
        $comandlogin = 'SELECT COUNT(*) FROM `user` WHERE uLogin = :ulog';
        $querycheck = $forum->prepare($comandlogin);
        $querycheck->execute(['ulog' => $_POST['Login']]);
        $rowlogin = $querycheck->fetch(PDO::FETCH_ASSOC);

        if(!is_countable($rowlogin) || current($rowlogin) > 0){
            echo 'Данный логин уже занят. Выберите другой логин.';
            exit();
        }

        $sql = 'UPDATE `user` SET uLogin = :userl WHERE u_id = :userid';
        $query = $forum->prepare($sql);
        $query->execute(['userid' => $_COOKIE['id'], 'userl' => $_POST['Login']]);

        setcookie ("Login", "", time() - 3600*24);
        setcookie ("Login", $_POST['Login'], time() + 3600*24);
    }
    
    if($_POST['Password'] != '') {
        if($_POST['Password'] != $_POST['PasswordConfirm']) {
            echo 'Ошибка. Пароли не совпадают.';
            exit();
        }

        $sql = 'UPDATE `user` SET uPassword = :userp WHERE u_id = :userid';
        $query = $forum->prepare($sql);
        $query->execute(['userid' => $_COOKIE['id'], 'userp' => $_POST['Password']]);
    }
}

else {
    echo 'Ошибка. Вы не можете отправить пустую форму.';
    exit();
}

$path = 'Location: /userpage.php?id='.$_COOKIE['id'];
header($path);
?>
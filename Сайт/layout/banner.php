<div class="banner">
    <script>
        function confirmClick(){
            var sure = confirm('Вы уверены?'); 
            if(sure) {
                window.location="/logout.php";
            }
        }
    </script>
    <div class="logo">
        <a href="/"><img src = "/img/logo_img.png" alt ="Hobby world"></a>
    </div>
    <div class="infoarea" id="infoarea">
        <div class="infotext">
            <script language="JavaScript">
                showTime(); 
            </script>

            <?php
            $comand_u = 'SELECT COUNT(*) FROM `user`';
            $result = $forum->prepare($comand_u);
            $result->execute();
            $cntusers_res = $result->fetch(PDO::FETCH_ASSOC);

            echo '
            <div class="users-banner">
                <a href="/community/allusers.php" style="color: #e8cc9f;">Зарегистрировано '.current($cntusers_res).' пользователей</a>
            </div>';
            ?>

            <div class="userinfo" style=<?php if(isset($_COOKIE["Login"])) {echo '"left: 600px;"';} else {echo '"left: 800px;"';}?>>
            <?php
            if(!isset($_COOKIE["Login"])) {
                echo '<a href="/login.php" style="color: #e8cc9f;">Вход/Регистрация</a>';
            }
            ?>  
            </div>
        </div>
        <?php if(isset($_COOKIE["Login"])){
            echo '<div class="user-controls">
            <a title="Мой профиль" href="/userpage.php?id='.$_COOKIE['id'].'"><img src="/img/user.png"></a>
            <a title="Cообщения" style="margin-left: 32px;" href="/community/messages.php"><img src="/img/mess.png"></a>';
            $sql_getmsgs = 'SELECT COUNT(*) FROM `message` WHERE u_id_r = :cur_res AND isRead = 0';
            $query_getmsgs = $forum->prepare($sql_getmsgs);
            $query_getmsgs->execute(['cur_res' => $_COOKIE['id']]);
            $cntmsgs = $query_getmsgs->fetch(PDO::FETCH_ASSOC);

            echo '<a href="/community/messages.php"><div style="margin-left: 6px;';
            if(current($cntmsgs) > 0)
            echo ' font-weight: bold; color: #b90e0a;';
            else echo ' color: #e8cc9f;';
            echo'">'.current($cntmsgs).'</div></a>';

            echo '<a title="Выход" style="margin-left: 20px;" onclick="confirmClick();"><img src="/img/ex.png"></a>
            </div>';
        }
        ?>
    </div>
</div>
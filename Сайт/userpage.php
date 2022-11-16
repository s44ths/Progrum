<?php require "layout/globalscripts.php" ?>

<?php

$comand1 = 'SELECT uLogin, moder, avatar FROM `user` WHERE u_id = :posterid';
$query1 = $forum->prepare($comand1);
$query1->bindValue(":posterid", $_GET["id"], PDO::PARAM_STR);
$query1->execute();
$row1 = $query1->fetch(PDO::FETCH_OBJ);

$comand2 = 'SELECT COUNT(*) FROM `forumposts` WHERE u_id = :posterid';
$query2 = $forum->prepare($comand2);
$query2->bindValue(":posterid", $_GET["id"], PDO::PARAM_STR);
$query2->execute();
$row2 = $query2->fetch(PDO::FETCH_ASSOC);

$comand3 = 'SELECT COUNT(*) FROM `comments` WHERE u_id = :posterid';
$query3 = $forum->prepare($comand3);
$query3->bindValue(":posterid", $_GET["id"], PDO::PARAM_STR);
$query3->execute();
$row3 = $query3->fetch(PDO::FETCH_ASSOC);

$countuserposts = current($row2) + current($row3);
?>

<html>
    <?php require "D:/Stuff/XXX/htdocs/layout/head.php" ?>
    <title>Профиль пользователя</title>
    <body>
       <div class="container">
           <?php require "layout/banner.php" ?>
           <div class="flexarea">
           <?php require "layout/leftmenu.php" ?>
           <div class="mainfullarea">
           <div class="main">
               <div class="content">
               <?php
               if(!isset($row1->uLogin)){
               echo 'Ошибка. Данный пользователь либо не создан, либо удалён.';
               exit();
               }
               ?>
               <a class="header">
                    Профиль пользователя <?php echo $row1->uLogin;?> 
               </a>
               <div class="userpage-maininfo">
                   <span class="smaller-header">
                   <?php 
                   echo 'Пользователь оставил '.$countuserposts.' сообщений, из них
                   <div style="margin-left: 332px;">'.current($row2).' постов <br>и '.current($row3).' комментариев</div>'; 

                   $isblocked = 'SELECT MAX(BlockEnd) FROM `bans` WHERE banned_id = :curuser';
                   $querycheckblock = $forum->prepare($isblocked);
                   $querycheckblock->execute(['curuser' => $_GET['id']]);
                   $dateend = $querycheckblock->FETCH(PDO::FETCH_ASSOC);
                   
                   date_default_timezone_set('Europe/Moscow');
                   $datecheck = new DateTime();
                   $datecheck = date_format($datecheck, 'Y-m-d H:i:s');

                   if(count($dateend) > 0 && $datecheck < current($dateend))
                   {
                       echo '<div style="font-size: 20px; color: #a50404;">Пользователь заблокирован';
                       if(current($dateend) > date('Y-m-d H:i:s', strtotime($datecheck.'+ 1 years')))
                          echo ' навсегда.';
                        else 
                          echo '.</br> Дата окончания блокировки: '.current($dateend).'';
                       echo '</div>';
                   }
                   ?>
                   </span>
                   <?php
                   if(count($dateend) > 0 && $datecheck < current($dateend))
                   {
                    echo 'Посмотрите историю блокировок для подробностей.';
                   }
                   ?>
                   <div class="userpage-block">
                       <div class="userpage-avatar">
                           <?php
                           echo '<img src="/img/avatar'.$row1->avatar.'.png" height="75" width="75">';
                           ?>
                       </div>
                       <div class="userpage-info">
                           <?php
                           echo '<div class="post-author-username" style="font-size: 16px;">'.$row1->uLogin.'</div>';
                           if($row1->moder) {
                               echo '<div class="post-moder" style="font-size: 14px;">Модератор</div>';
                           }
                           else {
                               echo '<div class="post-user" style="font-size: 14px;">Пользователь</div>';
                           }
                           $starsnumber = floor(min($countuserposts/2, 6)+ 1);
                           echo '<img src="/img/'.$starsnumber.'star.png" style="margin-top: 5px;" height="21">';
                           ?>
                       </div>
                       <div class="userpage-controls">
                <dialog id="ShowAllBans">
                    <div class="userdata-change-form" id="table">
                       <div class="userdata-info">
                           История блокировок пользователя
                       </div>
                       <div class="userdata-area">
                           <?php
                                $getcntbans = 'SELECT COUNT(*) FROM `bans` WHERE banned_id = :cur_user';
                                $querycntbans = $forum->prepare($getcntbans);
                                $querycntbans->execute(['cur_user' => $_GET['id']]);
                                $cntbans = $querycntbans->fetch(PDO::FETCH_ASSOC);

                           if(current($cntbans) == 0)
                           echo '<div style="font-size: 16px; margin-bottom: 35px; margin-top: 10px;">У пользователя нет блокировок.</div>';
                           
                           else {
                           echo '<table style="margin-left: auto; margin-right: auto; margin-bottom: 35px;">
                            <thead style = "color: #1a075f;">
                               <tr style="font-size: 14px;">
                               <td width="100">Модератор</td>
                               <td width="165">Время окончания</td>
                               <td width="180">Причина</td>
                               </tr>
                           </thread>';
                           $get_all_u_bans =  'SELECT * FROM `bans` WHERE banned_id = :curuser';
                           $querygetallbans = $forum->prepare($get_all_u_bans);
                           $querygetallbans->execute(['curuser' => $_GET['id']]);

                           while($rowbans = $querygetallbans->fetch(PDO::FETCH_OBJ)){
                               echo '<tr style="font-size: 12px; color: #000;"><td>';
                               $getmoderlogin = 'SELECT uLogin FROM `user` WHERE u_id = :moder';
                               $querygetmoderlogin = $forum->prepare($getmoderlogin);
                               $querygetmoderlogin->execute(['moder' => $rowbans->moder_id]);
                               $moderlogin = $querygetmoderlogin->fetch(PDO::FETCH_OBJ);

                               echo '<a href = "/userpage.php?id='.$rowbans->moder_id.'">'.$moderlogin->uLogin.'</a></td>
                               <td>';
                               if($rowbans->BlockEnd > date('Y-m-d H:i:s', strtotime($datecheck.'+ 1 years')))
                                  echo '-';
                                else echo $rowbans->BlockEnd;
                               echo '</td>
                               <td>'.$rowbans->Explaination.'</td></tr>';
                           }
                           echo '</table>';}
                           ?>
                           <div class="userdata-controls">
                               <button class="beigebutton" type="button" id="closebans">Закрыть</button>
                            </div>  
                        </div>     
                    </div>
                </dialog>
               <dialog id="ChangeAvatar">
                   <div class="userdata-change-form">
                       <div class="userdata-info">
                           <span class="avatar-info-text">Изменить аватар</span>
                       </div>
                       <form id="AvatarForm" method="POST" action="/changeuinfo.php">
                       <?php 
                            echo '<input id="Avatar" name="Avatar" type="hidden" value="'.$row1->avatar.'">';
                       ?>
                       <div class="userdata-area">
                           <div class="explanation">
                           <em>Аватары используются для представления вас другим участникам форума. Щелкните на картинку ниже, чтобы назначить её своим аватаром. Когда вы закончите, нажмите <b>«Сохранить аватар»</b>.</em>
                           </div>
                           <?php
                           for($i = 1; $i < 16; $i++) {
                               echo '<img class="avatar-list-frame" id="avatar'.$i.'" border="1" height="65" width="65" src="/img/avatar'.$i.'.png" onclick="changeAvatarId('.$i.');">';
                           }
                           ?>
                       </div>
                       <div class="userdata-controls">
                           <button class="bluebutton" type="submit" >Сохранить</button>
                           <button class="beigebutton" type="button" id="cancel" onclick="destroyCurAvatar();">Отмена</button>
                       </div>
                       </form>
                    </div>
                </dialog>
                <dialog id="CangeLogpass">
                    <div class="userdata-change-form">
                       <div class="userdata-info">
                           Изменить логин или пароль
                       </div>
                       <div class="userdata-area">
                           <div class="explanation">
                               <em>Вы можете поменять ваше имя на сайте и ваш пароль. Введите новые данные в поле, которое вы хотите заменить. Если вы не хотите менять один из параметров, не вводите ничего в соответсвующее поле. Для подтверждения замены требуется ввести текущий пароль от аккаунта. <br/> Когда вы закончите, нажмите <b>«Сохранить»</b>.</em>
                           </div>
                       <form id="LogpassForm" method="POST" action="/changeuinfo.php">
                           <div class="logpasschange-area">
                                <input id="Login" class="input_reg" style="width: 200px;" maxlength="15" placeholder="Новый логин" name="Login" type="text"><br/>
                                <input id="Password" type="password" class="input_reg" style="width: 200px; margin-top: 5px;" maxlength="25" placeholder="Новый пароль" name="Password" type="text"><br/>
                                <input id="PasswordConfirm" type="password" class="input_reg" style="width: 200px; margin-top: 5px;" maxlength="25" placeholder="Повторите новый пароль" name="PasswordConfirm" type="text"><br/>
                                <input id="OldPassword" type="password" class="input_reg" style="width: 200px; margin-top: 15px;" maxlength="25" placeholder="Текущий пароль" name="OldPassword" type="text">
                           </div>
                           <div class="userdata-controls">
                               <button class="bluebutton" type="submit" >Сохранить</button>
                               <button class="beigebutton" type="button" id="cancellp">Отмена</button>
                            </div>
                       </form>   
                        </div>     
                    </div>
                </dialog>
                <?php
                
                if(isset($_COOKIE['moder']) && $_COOKIE['moder'] == 1 && $row1->moder == 0)
                {
                    $newban = current($cntbans) + 1;
                echo '<dialog id="BanUserForm">
                    <div class="userdata-change-form">
                       <div class="userdata-info">
                            Забанить пользователя
                       </div>
                       <div class="userdata-area">
                           <div class="explanation">
                               Вы можете заблокировать пользователю доступ к сайту. <b>Обратите внимание, это его '.$newban.' блокировка. Данный пользователь будет забанен на ';
                               if(current($cntbans) == 0)
                                   echo '10 минут'; 
                                else if(current($cntbans) == 1)
                                   echo '1 день';
                                else if(current($cntbans) == 2)
                                   echo '1 неделю';
                                else if (current($cntbans) == 3)
                                   echo '1 месяц';
                                else 
                                   echo 'навсегда';
                               echo '.</b></br></br>Пожалуйста, убедитесь, что выдаёте бан заслуженно и доходчиво опишите причину.
                           </div>
                       <form id="BanForm" method="POST" action="/phpactions/banuser.php">
                           <div class="logpasschange-area">
                               <input type="hidden" name="banned" value="'.$_GET['id'].'">
                               <input type="hidden" name="moder" value="'.$_COOKIE['id'].'">
                               <textarea class="input_reg" style="width: 350px; height: 90px; resize: vertical;" name="Reason" placeholder="Опишите причину блокировки"></textarea>
                               </br>
                               <input type="checkbox" id="checkperma" name="isperma" value="perma">
                               <label for="checkperma">Заблокировать навсегда?</label>
                           </div>
                           <div class="userdata-controls">
                               <button class="bluebutton" type="submit">Заблокировать</button>
                               <button class="beigebutton" type="button" id="cancelban">Отмена</button>
                            </div>
                       </form>   
                        </div>     
                    </div>
                </dialog>';
                }
                ?>
                <?php
                echo '<button class="userbutton" id="ShowBanHistory">История блокировок (';
                if(current($cntbans) > 0)
                    echo '<span style="color: #a50404;">'.current($cntbans).'</span>';
                else 
                    echo current($cntbans);
                echo')</button>';
                if(isset($_COOKIE['id'])){
                if($_COOKIE['id'] == $_GET['id']){
                    echo '<button class="userbutton" id="ShowAvatarMenu" onclick="setOriginalAvatar('.$row1->avatar.');">Изменить аватар</button>';
                    echo '<button class="userbutton" id="ShowLogpassMenu">Изменить логин или пароль</button>';
                }
                else {
                    echo 
                    '<form method="GET" action="/community/newmessage.php" style="margin-bottom: 0px;">
                    <input type="hidden" name="to" value='.$row1->uLogin.' />
                    <button class="userbutton" type="submit">Сообщение</button>
                    </form>';
                    if($_COOKIE['moder'] == 1 && $row1->moder == 0)
                    echo '<button class="userbutton" id="BanUser" style="color: #a50404;">Забанить пользователя</button>';
                }
                }
                ?>
                <script> //avatar
                 var showb = document.getElementById('ShowAvatarMenu');
                 var cancelb = document.getElementById('cancel');
                 var avatarDialog = document.getElementById('ChangeAvatar');
                 var curAvatar;
                 
                 showb.addEventListener('click', function() {
                    avatarDialog.showModal();});

                 cancelb.addEventListener('click', function() {
                    avatarDialog.close();});

                 function setOriginalAvatar(number) {
                     curAvatar = number;
                     var avaid = 'avatar' + String(number);
                     var avaframe = document.getElementById(avaid);
                     avaframe.setAttribute("border", 6);
                }
                 function destroyCurAvatar(number) {
                    var oldava = 'avatar' + String(curAvatar)
                     var oldframe = document.getElementById(oldava);
                     oldframe.setAttribute("border", 1);
                 }
                 function changeAvatarId(number){
                     var oldava = 'avatar' + String(curAvatar)
                     var oldframe = document.getElementById(oldava);
                     oldframe.setAttribute("border", 1);

                     var ava = document.querySelector('#Avatar');
                     ava.setAttribute("value", number);
                    
                     curAvatar = number;
                     var newava = 'avatar' + String(number); 
                     var avaframe = document.getElementById(newava);
                     avaframe.setAttribute("border", 6);
                 }
                </script>

                <script> //logpass
                 var showb_lp = document.getElementById('ShowLogpassMenu');
                 var cancel_lp = document.getElementById('cancellp');
                 var Dialog_lp = document.getElementById('CangeLogpass');

                 showb_lp.addEventListener('click', function() {
                     Dialog_lp.showModal();});

                 cancel_lp.addEventListener('click', function() {
                     Dialog_lp.close();});
                </script>

                <script> //ban!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
                 var showb_ban = document.getElementById('BanUser');
                 var cancel_ban = document.getElementById('cancelban');
                 var Dialog_ban = document.getElementById('BanUserForm');

                 showb_ban.addEventListener('click', function() {
                     Dialog_ban.showModal();});

                 cancel_ban.addEventListener('click', function() {
                     Dialog_ban.close();});
                </script>
                
                <script> //bans
                 var show_hban = document.getElementById('ShowBanHistory');
                 var cancel_hban = document.getElementById('closebans');
                 var Dialog_hban = document.getElementById('ShowAllBans');

                 show_hban.addEventListener('click', function() {
                     Dialog_hban.showModal();});

                 cancel_hban.addEventListener('click', function() {
                     Dialog_hban.close();});
                </script>
                </div>
                </div>
                </div>
            </div>
            </div>
            </div>
       </div> 
    </body>
</html>
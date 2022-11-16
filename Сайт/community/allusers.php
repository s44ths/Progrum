<?php require "D:/Stuff/XXX/htdocs/layout/globalscripts.php" ?>

<html>
    <?php require "D:/Stuff/XXX/htdocs/layout/head.php" ?>
    <title>Пользователи</title>
    <body>
       <div class="container">
           <?php require "D:/Stuff/XXX/htdocs/layout/banner.php" ?>
           <div class="flexarea">
           <?php require "D:/Stuff/XXX/htdocs/layout/leftmenu.php" ?>
           <div class="mainfullarea">
           <div class="main">
               <div class="content">
                   <div class="user-search-area">
                       <div class="header" style="margin-bottom: 12px; font-size: 18px;">Поиск пользователей</div> 
                       <form method="GET" action="/community/allusers.php">

                           <input class="input_reg" style="width: 200px;" maxlength="15" <?php if(isset($_GET['user'])) echo 'value="'.$_GET['user'].'"'?> placeholder="Имя пользователя" name="user" type="text"><br>

                           <div class="input-select-area">
                               <div class = "smaller-header" style="font-size: 16px; margin-left: 0px;">Сортировать по: </div>
                               <div class = "smaller-header" style="font-size: 16px; margin-left: 50px;">В порядке: </div>
                            </div>
                                  <select name="sort" size="1">
                                   <option value="u_id" <?php if(!isset($_GET['sort']) || $_GET['sort'] == 'u_id') echo 'selected';?>>id пользователя</option>
                                   <option value="uLogin" <?php if(isset($_GET['sort']) && $_GET['sort'] == 'uLogin') echo 'selected';?>>Имени пользователя</option>
                                   <option value="LastSeen" <?php if(isset($_GET['sort']) && $_GET['sort'] == 'LastSeen') echo 'selected';?>>Дате посещения</option>
                               <select>
                               <select name="by" size="1" style="margin-left: 22px; margin-top: 5px;">
                                   <option value="ASC" <?php if(!isset($_GET['by']) || $_GET['by'] == 'ACS') echo 'selected';?>>Возрастания</option>
                                   <option value="DESC" <?php if(isset($_GET['by']) && $_GET['by'] == 'DESC') echo 'selected';?>>Убывания</option>
                               <select>
                            </br>
                            <input type="submit" style="margin-top: 15px;" value="Поиск" class="beigebutton">
                       </form>
                   </div>
                   <table id="userlist" cellspacing="0" >
                       <thead id="allusers">
                           <tr style="font-size: 16px;">
                               <td width="20"></td>
                               <td width="160">Имя пользователя</td>
                               <td width="105">Роль</td>
                               <td width="70">Статус</td>
                               <td width="180">Последняя активность</td>
                               <td width="80" style="text-align: center;">Звёзды</td>
                           </tr>
                       </thead>
                       <tbody>
                           <?php
                           $get_user_list ='';
                           if(isset($_GET['sort']))
                                $get_user_list = 'SELECT u_id, uLogin, Moder, LastSeen FROM `user` WHERE uLogin LIKE \'%'.$_GET['user'].'%\' ORDER BY '.$_GET['sort'].' '.$_GET['by'].'';
                            else
                                $get_user_list = 'SELECT u_id, uLogin, Moder, LastSeen FROM `user`';
                           $userlist = $forum->prepare($get_user_list);
                           $userlist->execute();
                           $color = 0;

                           while($row = $userlist->fetch(PDO::FETCH_OBJ))
                           {
                                echo '<tr border="0"'; if($color%2 == 0) echo ' style="background-color: #ddd4bf;"';  echo '>';

                                date_default_timezone_set('Europe/Moscow');
                                $last_seen_u = $row->LastSeen;
                                $is_online = date('Y-m-d H:i:s', strtotime($last_seen_u.'+ 5 minutes'));
                                $is_idle = date('Y-m-d H:i:s', strtotime($last_seen_u.'+ 10 minutes'));

                                $curdate = new DateTime();
                                $curdate_form = date_format($curdate, 'Y-m-d H:i:s');

                                if($curdate_form <= $is_online)
                                    echo'<td><p style="text-align: center;"><img src="/img/online.png"></p></td>';
                                else if($curdate_form <= $is_idle)
                                    echo'<td><p style="text-align: center;"><img src="/img/idle.png"></p></td>';
                                 else echo '<td><p style="text-align: center;"><img src="/img/offline.png"></p></td>';
                                        
                                echo '<td><a href="/userpage.php?id='.$row->u_id.'">'.$row->uLogin.'</a></td>';
                                
                                $color++;
                                if($row->Moder)
                                    echo'<td><span style="color: green;">Модератор</span></td>';
                                else
                                    echo'<td>Пользователь</td>';
                                
                                //Онлайн
                                
                                if($curdate_form <= $is_online)
                                    echo'<td><span style="color: green;">Онлайн</span></td>';
                                else if($curdate_form <= $is_idle)
                                    echo'<td><span style="color: #ee9a4d;">Отошел</span></td>';
                                else echo '<td><span style="color: #731d08;">Офлайн</span></td>';

                                //echo '<td>'.$row->LastSeen.'</td>';
                                $lastseen_date= date('H:i d/m/Y', strtotime($row->LastSeen));
                                echo '<td><span style="margin-left: 30px;">'.$lastseen_date.'</span></td>';

                                $comandcntp = 'SELECT COUNT(*) FROM `forumposts` WHERE u_id = :posterid';
                                $querycntp = $forum->prepare($comandcntp);
                                $querycntp->bindValue(":posterid", $row->u_id, PDO::PARAM_STR);
                                $querycntp->execute();
                                $cntp_res = $querycntp->fetch(PDO::FETCH_ASSOC);

                                $comandcntc = 'SELECT COUNT(*) FROM `comments` WHERE u_id = :posterid';
                                $querycntc = $forum->prepare($comandcntc);
                                $querycntc->bindValue(":posterid", $row->u_id, PDO::PARAM_STR);
                                $querycntc->execute();
                                $cntc_res = $querycntc->fetch(PDO::FETCH_ASSOC);
                                
                                $countuserposts = current($cntp_res) + current($cntc_res);
                                $starsnumber = floor(min($countuserposts/2, 6)+ 1);
                                
                                echo '<td><p style="text-align: center;"><img src="/img/'.$starsnumber.'star.png" height="21"></p></td>';
                           }
                           ?>
                       </tbody>
                   </table>
               </div>
            </div>
            </div>
            </div>
       </div> 
    </body>
</html>
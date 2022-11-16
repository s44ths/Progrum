<?php require "D:/Stuff/XXX/htdocs/layout/globalscripts.php" ?>

<html>
    <?php require "D:/Stuff/XXX/htdocs/layout/head.php" ?>
    <title>Мои сообщения</title>
    <body>
       <div class="container">
           <?php require "D:/Stuff/XXX/htdocs/layout/banner.php" ?>
           <div class="flexarea">
           <?php require "D:/Stuff/XXX/htdocs/layout/leftmenu.php" ?>
           <div class="mainfullarea">
           <div class="main">
               <div class="content">
                   <div style="display: flex; margin-top: 15px;">
                    <div class="header" style="font-size: 25px; margin-left: 53px;">
                     <em>Ваши личные сообщения</em>
                    </div>
                    <div class="editor-text-footer" style="width: 275px;">
                        <input type="button" value="Новое сообщение" name="button" class="bluebutton" id="cancel" onclick="window.location=path;">
                    </div>
                    </div>
                    <div style="margin-left: 50px;">
                        <a href="/community/messages.php?order=received" <?php if(!isset($_GET['order']) || $_GET['order'] != 'sent') echo 'style="font-weight: bold;"';?>>Полученные</a> | <a href="/community/messages.php?order=sent" <?php if(isset($_GET['order']) && $_GET['order'] == 'sent') echo 'style="font-weight: bold;"';?>>Отправленные</a>
                    </div>
                    <script language="JavaScript">
                        var path = '/community/newmessage.php';
                    </script>
                   <div class="tableheader" id="message" style="margin-top: 10px;">
                       <div style="margin-top: 3px; ">
                       <span style="margin-left: 44px;">Тема сообщения</span>
                       <span style="margin-left: 276px;"><?php if(isset($_GET['order']) && $_GET['order'] == 'sent') {echo 'Получатель';} else {echo 'Отправитель';}?></span>
                       </div>
                   </div>
                   <table id="msglist">
                       <?php
                       $getmessages = '';
                       if(!isset($_GET['order']) || $_GET['order'] != 'sent')
                            $getmessages = 'SELECT * FROM `message` WHERE u_id_r = :curuser ORDER BY m_id DESC';
                        else
                            $getmessages = 'SELECT * FROM `message` WHERE u_id_s = :curuser ORDER BY m_id DESC';
                       $query_getmessages = $forum->prepare($getmessages);
                       $query_getmessages->execute(['curuser' => $_COOKIE['id']]);
                       while($row = $query_getmessages->FETCH(PDO::FETCH_OBJ)){
                           echo '<tr><td class="status">';
                           if($row->isRead == 0)
                           echo '<img src="/img/newmessage.png" style="margin-left: 8px;">';
                           else
                           echo '<img src="/img/checked.png" style="margin-left: 10px;">';
                           echo '</td><td class="title"><a href="/community/message.php?id='.$row->m_id.'">'.$row->Title.'</a></td>';
                           
                           $getsenderlog = 'SELECT uLogin FROM `user` WHERE u_id = :sender';
                           $querygetlog = $forum->prepare($getsenderlog);
                           $neededid;
                           if(isset($_GET['order']) && $_GET['order'] == 'sent')
                                $neededid = $row->u_id_r;
                            else
                                $neededid = $row->u_id_s;
                           $querygetlog->execute(['sender' => $neededid]);
                           $sender = $querygetlog->fetch(PDO::FETCH_ASSOC);

                           echo '<td class="sender"><a href="/userpage.php?id=';
                           if(isset($_GET['order']) && $_GET['order'] == 'sent') echo $row->u_id_r;
                           else echo $row->u_id_s;
                           echo'">'.current($sender).'</a></td>';
                       }
                       ?>
                   </table>
               </div>
            </div>
            </div>
            </div>
       </div> 
    </body>
</html>
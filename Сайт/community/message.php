<?php require "D:/Stuff/XXX/htdocs/layout/globalscripts.php" ?>

<?php
if(!isset($_GET['id'])){
    header('Location: /');
}

$msginfo = 'SELECT * FROM `message` WHERE m_id = :mid';
$querymsg = $forum->prepare($msginfo);
$querymsg->execute(['mid' => $_GET['id']]);
$message = $querymsg->fetch(PDO::FETCH_OBJ);

if($message->u_id_s != $_COOKIE['id'] && $message->u_id_r != $_COOKIE['id']){
    header('Location: /');
}

if($message->isRead == 0 && $_COOKIE['id'] == $message->u_id_r)
{
    $changestatus = 'UPDATE `message` SET isRead = 1 WHERE m_id = :mid';
    $updatestatus = $forum->prepare($changestatus);
    $updatestatus->execute(['mid' => $_GET['id']]);
}

?>

<html>
    <?php require "D:/Stuff/XXX/htdocs/layout/head.php" ?>
    <title>Сообщение</title>
    <body>
       <div class="container">
           <?php require "D:/Stuff/XXX/htdocs/layout/banner.php" ?>
           <div class="flexarea">
           <?php require "D:/Stuff/XXX/htdocs/layout/leftmenu.php" ?>
           <div class="mainfullarea">
           <div class="main">
               <div class="content">
                    <div class="messageheader" style="width: 674px;">
                        <?php echo $message->Title; 
                        echo '<div style="margin-left: 465px;">'.$message->MessageSent.'</div>'; ?>
                    </div>
                    <div id="msg-show">
                        <?php
                        $getsinfo = 'SELECT uLogin, Avatar FROM `user` WHERE u_id = :sender';
                        $querysinfo = $forum->prepare($getsinfo);
                        $querysinfo->execute(['sender' => $message->u_id_s]);
                        $sender = $querysinfo->fetch(PDO::FETCH_OBJ);
                        
                        echo '<div id="msg-avatar">
                        <div id="msg-info">
                           <div class="post-author-avatar">
                               <img src="/img/avatar'.$sender->Avatar.'.png" style="height: 60px;">
                           </div>
                           <div class="post-author-username"><a href="/userpage.php?id='.$message->u_id_s.'" style="color: white;">'.$sender->uLogin.'</a></div>
                        </div>
                        </div>
                        <div id="msg-text">
                        '.$message->Content.'
                        </div>';
                        ?>
                    </div>
                    <?php
                    if($_COOKIE['id'] == $message->u_id_r)
                    {echo '<form method="POST" action="/phpactions/sendmessage.php" style="margin-top: 20px;">
                       <div class="messageheader">
                           Быстрый ответ
                       </div>
                       <div id="msg-editor">
                           <span class="editorlabel">Получатель: </span>
                           <input class="input_reg" name="Receiver" style="width: 250px; font-size: 13px;" value="'.$sender->uLogin.'" type="text">
                           <br/>
                           <span class="editorlabel">Тема: </span>
                           <input class="input_reg" maxlength="30" name="Topic" style="width: 250px; font-size: 13px;" value="Re: '.$message->Title.'" type="text">
                           <br/>
                           <span class="editorlabel" style="vertical-align: top;">Сообщение: </span>
                           <textarea class="input_reg" name="Msg_text" id="message" rows="10"></textarea>
                           <input type="hidden" name="Sender" value="'.$_COOKIE['id'].'">
                       </div>
                       <div class="editor-text-footer">
                            <input type="submit" value="Отправить" name="button" class="beigebutton" id="submit">
                            <input type="button" value="Отмена" name="button" class="bluebutton" id="cancel" onclick="window.location=path;">
                        </div>
                        
                   </form>';}
                   ?>
                   <script language="JavaScript">
                        var path = '/';
                    </script>
               </div>
            </div>
            </div>
            </div>
       </div> 
    </body>
</html>
<?php require "D:/Stuff/XXX/htdocs/layout/globalscripts.php" ?>

<?php
if(!isset($_COOKIE['id']))
{
    header('Location: /');
}
?>

<html>
    <?php require "D:/Stuff/XXX/htdocs/layout/head.php" ?>
    <title>Новое сообщение</title>
    <body>
       <div class="container">
           <?php require "D:/Stuff/XXX/htdocs/layout/banner.php" ?>
           <div class="flexarea">
           <?php require "D:/Stuff/XXX/htdocs/layout/leftmenu.php" ?>
           <div class="mainfullarea">
           <div class="main">
               <div class="content">
                   <form method="POST" action="/phpactions/sendmessage.php" style="margin-top: 20px;">
                       <div class="messageheader">
                           Новое сообщение
                       </div>
                       <div id="msg-editor">
                           <span class="editorlabel">Получатель: </span>
                           <?php
                           echo '<input class="input_reg" name="Receiver" style="width: 250px; font-size: 13px;" ';
                           if(isset($_GET['to'])){
                               echo 'value="'.$_GET['to'].'"';
                           }
                           echo ' type="text">';
                           ?>
                           <br/>
                           <span class="editorlabel">Тема: </span>
                           <input class="input_reg" maxlength="30" name="Topic" style="width: 250px; font-size: 13px;" type="text">
                           <br/>
                           <span class="editorlabel" style="vertical-align: top;">Сообщение: </span>
                           <textarea class="input_reg" name="Msg_text" id="message" rows="10"></textarea>
                           <?php
                           echo '<input type="hidden" name="Sender" value="'.$_COOKIE['id'].'">';?>
                       </div>
                       <div class="editor-text-footer">
                            <input type="submit" value="Отправить" name="button" class="beigebutton" id="submit">
                            <input type="button" value="Отмена" name="button" class="bluebutton" id="cancel" onclick="window.location=path;">
                        </div>
                        <script language="JavaScript">
                            var path = '/';
                        </script>
                   </form>
               </div>
            </div>
            </div>
            </div>
       </div> 
    </body>
</html>
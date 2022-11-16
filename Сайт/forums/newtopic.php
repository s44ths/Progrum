<?php require "D:/Stuff/XXX/htdocs/layout/globalscripts.php" ?>

<?php
if(is_null($_GET['id']) or !(isset($_COOKIE["Login"]))) {
    header('Location: /');
}
?>

<script language="JavaScript">
    var path = '/forums/topics.php' + window.location.search;
</script>

<html>
    <?php require "D:/Stuff/XXX/htdocs/layout/head.php" ?>
    <title>Новая тема</title>
    <body>
       <div class="container">
           <?php require "D:/Stuff/XXX/htdocs/layout/banner.php" ?>
           <div class="flexarea">
           <?php require "D:/Stuff/XXX/htdocs/layout/leftmenu.php" ?>
           <div class="mainfullarea">
           <div class="main">
               <div class="content">
                   <div  style="position: relative; margin-top: 10px; margin-bottom: 10px; line-height: 20px; font-size: 20px;">
                        <em>Создание новой темы</em>
                    </div>
                   <form method="POST" action="/phpactions/add.php">
                   <div class = "commoncolumn">
                       <input id="Title" class="input_reg" maxlength="45" placeholder="Название темы..." name="Title" type="text">
                   </div>
                   <div class="editor">
                        <?php
                           echo '<div class="editor-author" style="width: 90px;">
                           <div class="editor-author-avatar"><img style="border: 0px;" width="60" height="60" src="/img/avatar'.$_COOKIE["avatar"].'.png"></div>
                           <div class="post-author-username">'.$_COOKIE["Login"].'</div>
                           </div>';
                        ?>
                       <div class="editor-text">
                           <div class="editor-text-content">
                               <textarea id="Content" class="input_reg" cols="50" rows="25" name="Content" style="margin-top: 0px; margin-bottom: 0px"></textarea>
                           </div>
                           <?php
                           echo '<input type="hidden" name="id" value='.$_GET['id'].' />'
                           ?>
                           <div class="editor-text-footer" id="post">
                               <input type="submit" value="Отправить" name="button" class="beigebutton" id="submit">
                               <input type="button" value="Отмена" name="button" class="bluebutton" id="cancel" onclick="window.location=path;">
                           </div>
                       </div>
                   </div>
                   </form>
               </div>
           </div>
           </div>
           </div>
       </div> 
    </body>
</html>
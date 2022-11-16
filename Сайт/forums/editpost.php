<?php require "D:/Stuff/XXX/htdocs/layout/globalscripts.php" ?>

<html>
    <?php require "D:/Stuff/XXX/htdocs/layout/head.php" ?>
    <title>Редактировать</title>
    <body>
       <div class="container">
           <?php require "D:/Stuff/XXX/htdocs/layout/banner.php" ?>
           <div class="flexarea">
           <?php require "D:/Stuff/XXX/htdocs/layout/leftmenu.php" ?>
           <div class="mainfullarea">
           <div class="main">
               <div class="content">
                   <div  style="position: relative; margin-top: 10px; margin-bottom: 10px; line-height: 20px; font-size: 20px;">
                        <em>Редактировать сообщение</em>
                    </div>
                   <form method="POST" action="/phpactions/edit.php">
                   <div class = "commoncolumn">
                        <input id="Title" class="input_reg" maxlength="45" value="<?php echo $_POST['Title'];?>" name="Title" type="text" <?php if(!$_POST['is_post']) echo 'disabled';?>>
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
                               <?php echo '<textarea id="Content" class="input_reg" cols="50" rows="25" name="Content" style="margin-top: 0px; margin-bottom: 0px">'.str_replace("<br />", "", $_POST['Content']).'</textarea>';?>
                           </div>
                           <?php
                           echo '<input type="hidden" name="postid" value="'.$_POST['postid'].'">';
                           echo '<input type="hidden" name="is_post" value='.$_POST['is_post'].' />';
                           echo '<input type="hidden" name="id" value='.$_POST['id'].' />';
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
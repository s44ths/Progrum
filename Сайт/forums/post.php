<?php require "D:/Stuff/XXX/htdocs/layout/globalscripts.php" ?>

<?php
if(is_null($_GET['id'])) {
    header('Location: /');
}
?>

<script>
        function confirmcomClick(){
            var sure = confirm('Вы уверены?'); 
            return sure;
        }
</script>

<html>
    <?php require "D:/Stuff/XXX/htdocs/layout/head.php" ?>
    <title>Тема</title>
    <body>
       <div class="container">
           <?php require "D:/Stuff/XXX/htdocs/layout/banner.php" ?>
           <div class="flexarea">
           <?php require "D:/Stuff/XXX/htdocs/layout/leftmenu.php" ?>
           <div class="mainfullarea">
           <div class="main">
               <div class="content forumcontent">
                   <div id="forumheader">
                       <?php
                       $comand_post = 'SELECT * FROM `forumposts` WHERE post_id = :postid';
                       $query = $forum->prepare($comand_post);
                       $query->execute(['postid' => $_GET['id']]);
                       $row = $query->fetch(PDO::FETCH_OBJ);
                       echo $row->Title;

                       $comand1 = 'SELECT uLogin, Moder, Avatar FROM `user` WHERE u_id = :posterid';
                       $query1 = $forum->prepare($comand1);
                       $query1->bindValue(":posterid", $row->u_id, PDO::PARAM_STR);
                       $query1->execute();
                       $row1 = $query1->fetch(PDO::FETCH_OBJ);

                       $comand2 = 'SELECT COUNT(*) FROM `forumposts` WHERE u_id = :posterid';
                       $query2 = $forum->prepare($comand2);
                       $query2->bindValue(":posterid", $row->u_id, PDO::PARAM_STR);
                       $query2->execute();
                       $row2 = $query2->fetch(PDO::FETCH_ASSOC);

                       $comand3 = 'SELECT COUNT(*) FROM `comments` WHERE u_id = :posterid';
                       $query3 = $forum->prepare($comand3);
                       $query3->bindValue(":posterid", $row->u_id, PDO::PARAM_STR);
                       $query3->execute();
                       $row3 = $query3->fetch(PDO::FETCH_ASSOC);

                       $countuserposts = current($row2) + current($row3);
                       ?>
                   </div>
                   <div class="postframe" id="main">
                       <div class="postauthor">
                           <div class="post-author-avatar">
                                <?php
                                echo '<img style="border: 0px;" width="60" height="60" src="/img/avatar'.$row1->Avatar.'.png">'
                                ?>
                           </div>
                           <?php
                           echo '<div class="post-author-username"><a href="/userpage.php?id='.$row->u_id.'" style="color: white;">'.$row1->uLogin.'</a></div>';
                           if($row1->Moder) {
                               echo '<div class="post-moder">Модератор</div>';
                           }
                           echo '<div class="post-author-stat">Активность:<br/>'.$countuserposts.' сообщений</div>';
                           ?>
                       </div>
                       <div class="posttext">
                           <div class="postheader">
                               <span style="margin-left: 15px;">Опубликовано: 
                               <?php
                               echo $row->PostDate;
                               ?>
                               </span>
                               <?php
                               if(isset($_COOKIE["Login"]) && ($_COOKIE["moder"] == 1 || $_COOKIE["id"] == $row->u_id))
                               {
                                   echo '<div class="post-actions">';

                                   if($_COOKIE['moder'] == 1){
                                    echo '<form method="POST" action="/phpactions/changepoststatus.php" onsubmit="return confirmcomClick();">
                                    <input type="hidden" name="postid" value="'.$_GET['id'].'">
                                    <input type="hidden" name="gtopicid" value="'.$row->topic_id.'">
                                    <input type="hidden" name="post_status" value="'.$row->isClosed.'">
                                    <button type="submit" class="postico"><img src="/img/lockpost.png"></button>
                                    </form>';
                                   }

                                   $curdate = new DateTime();
                                   $curdate_form = date_format($curdate, 'Y-m-d H:i:s');
                                   $is_aviable_to_edit = date('Y-m-d H:i:s', strtotime($curdate_form.'- 1 day'));

                                   if(($_COOKIE["id"] == $row->u_id && $row->PostDate >= $is_aviable_to_edit) || $_COOKIE["moder"] == 1){
                                    echo '<form method="POST" action="/forums/editpost.php">
                                    <input type="hidden" name="is_post" value="1">
                                    <input type="hidden" name="id" value="'.$_GET['id'].'">
                                    <input type="hidden" name="postid" value="'.$_GET['id'].'">
                                    <input type="hidden" name="Title" value="'.$row->Title.'">
                                    <input type="hidden" name="Content" value="'.str_replace("\"", "&#34;", $row->Content).'">
                                    <button type="submit" class="postico"><img src="/img/edit.png"></button>
                                    </form>';
                                   }

                                   echo '<form method="POST" action="/phpactions/deletepost.php" name="delpost" onsubmit="return confirmcomClick();">
                                   <input type="hidden" name="postid" value="'.$_GET['id'].'">
                                   <input type="hidden" name="gtopicid" value="'.$row->topic_id.'">
                                   <button type="submit" class="postico"><img src="/img/delete.png"></button>
                                   </form>
                                   </div>';
                               }
                               ?>
                           </div>
                           <div class="posttextcontent">
                           <?php
                            echo $row->Content;
                            ?>
                           </div>
                       </div>
                   </div>
                   <?php
                   $sql_comments = 'SELECT * FROM `comments` WHERE post_id = :postid';
                   $querycom = $forum->prepare($sql_comments);
                   $querycom->execute(['postid' => $row->post_id]);

                   while($comrow = $querycom->fetch(PDO::FETCH_OBJ)) {
                       echo '
                       <div class="postframe">
                       <div class="postauthor">
                       <div class="post-author-avatar">';
                       $comandcom1 = 'SELECT uLogin, Moder, Avatar FROM `user` WHERE u_id = :posterid';
                       $querycom1 = $forum->prepare($comandcom1);
                       $querycom1->bindValue(":posterid", $comrow->u_id, PDO::PARAM_STR);
                       $querycom1->execute();
                       $rowcom1 = $querycom1->fetch(PDO::FETCH_OBJ);

                       $comandcom2 = 'SELECT COUNT(*) FROM `forumposts` WHERE u_id = :posterid';
                       $querycom2 = $forum->prepare($comandcom2);
                       $querycom2->bindValue(":posterid", $comrow->u_id, PDO::PARAM_STR);
                       $querycom2->execute();
                       $rowcom2 = $querycom2->fetch(PDO::FETCH_ASSOC);

                       $comandcom3 = 'SELECT COUNT(*) FROM `comments` WHERE u_id = :posterid';
                       $querycom3 = $forum->prepare($comandcom3);
                       $querycom3->bindValue(":posterid", $comrow->u_id, PDO::PARAM_STR);
                       $querycom3->execute();
                       $rowcom3 = $querycom3->fetch(PDO::FETCH_ASSOC);

                       $countcomposts = current($rowcom2) + current($rowcom3);

                       echo '<img style="border: 0px;" width="60" height="60" src="/img/avatar'.$rowcom1->Avatar.'.png"></div>';
                       echo '<div class="post-author-username"><a href="/userpage.php?id='.$comrow->u_id.'" style="color: white;">'.$rowcom1->uLogin.'</a></div>';
                           if($rowcom1->Moder) {
                               echo '<div class="post-moder">Модератор</div>';
                           }
                       echo '<div class="post-author-stat">Активность:<br/>'.$countcomposts.' сообщений</div>';
                       echo '</div>
                       <div class="posttext">
                           <div class="postheader">
                               <span style="margin-left: 15px;">Опубликовано: '.$comrow->ComDate.'</span>';
                               
                               if(isset($_COOKIE["Login"]) && ($_COOKIE["moder"] == 1 || $_COOKIE["id"] == $comrow->u_id)){
                               echo '<div class="post-actions">';
                                $curdate = new DateTime();
                                $curdate_form = date_format($curdate, 'Y-m-d H:i:s');
                                $is_aviable_to_edit = date('Y-m-d H:i:s', strtotime($curdate_form.'- 1 day'));

                                if(($_COOKIE["id"] == $comrow->u_id && $comrow->ComDate >= $is_aviable_to_edit) || $_COOKIE["moder"] == 1){
                                    echo '<form method="POST" action="/forums/editpost.php">
                                    <input type="hidden" name="is_post" value="0">
                                    <input type="hidden" name="id" value="'.$comrow->com_id.'">
                                    <input type="hidden" name="postid" value="'.$_GET['id'].'">
                                    <input type="hidden" name="Title" value="'.$row->Title.'">
                                    <input type="hidden" name="Content" value="'.str_replace("\"", "&#34;", $comrow->ComContent).'">
                                    <button type="submit" class="postico"><img src="/img/edit.png"></button>
                                    </form>';
                                   }
                               echo   '<form method="POST" action="/phpactions/deletecomment.php" name="delcom" onsubmit="return confirmcomClick();">
                                   <input type="hidden" name="comid" value="'.$comrow->com_id.'">
                                   <input type="hidden" name="urladress" value="'.$_SERVER['PHP_SELF'].'?id='.$_GET['id'].'">
                                   <button type="submit" class="postico"><img src="/img/delete.png"></button>
                                   </form>
                               </div>';
                               }
                               
                           echo '</div>
                           <div class="posttextcontent">'
                           .$comrow->ComContent.'
                           </div>
                       </div>
                       </div>';
                   }?>
                   <form method="POST" action="/phpactions/addcomment.php">
                   <div class="editor" style="margin-top: 20px;">
                   <?php
                        if(isset($_COOKIE["id"]) && !($row->isClosed)) {

                        echo '<div class="editor-text-comment">
                            <em>Добавить новый комментарий</em>
                        </div>
                        <div class="editor-author">
                            <div class="editor-author-avatar"><img style="border: 0px;" width="60" height="60" src="/img/avatar'.$_COOKIE["avatar"].'.png"></div>
                            <div class="post-author-username">'.$_COOKIE["Login"].'</div>
                        </div>
                       <div class="editor-text" id="comment">

                           <div class="editor-text-content">
                               <textarea id="Content-com" class="input_reg-com" cols="50" rows="15" name="Content" style="margin-top: 0px; margin-bottom: 0px"></textarea>
                           </div>
                           <input type="hidden" name="id" value='.$_GET['id'].'>
                           <div class="editor-text-footer">
                               <input type="submit" value="Отправить" name="button" class="beigebutton" id="submit">
                           </div>
                       </div>';
                        }
                        else if($row->isClosed){ 
                            echo '<div class="editor-text-comment">
                            <em>Данный пост закрыт для обсуждения</em>
                        </div>';
                        }
                        else{
                            echo '<div class="editor-text-comment">
                            <em><a href="/login.php">Войдите или зарегистрируйтесь</a>, чтобы оставлять комментарии</em>
                        </div>';
                        }
                    ?>
                   </div>
                   </form>
               </div>
           </div>
           </div>
           </div>
       </div> 
    </body>
</html>
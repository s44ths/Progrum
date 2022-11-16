<?php require "D:/Stuff/XXX/htdocs/layout/globalscripts.php" ?>

<html>
    <?php require "D:/Stuff/XXX/htdocs/layout/head.php" ?>
    <title>Progrum</title>
    <body>
       <div class="container">
           <?php require "D:/Stuff/XXX/htdocs/layout/banner.php" ?>
           <div class="flexarea">
           <?php require "D:/Stuff/XXX/htdocs/layout/leftmenu.php" ?>
           <div class="mainfullarea">
           <div class="main">
               <div class="content">
                   <br>
                <div class="header" style="text-align: center;">
                <em>Добро пожаловать на форум для программистов!</em>
                <div style="margin-top: 15px; margin-bottom: 30px; font-size: 22px;">Последние новости:</div>
                </div>
                <?php
                $getlastnews = 'SELECT * FROM `forumposts` WHERE topic_id = 8 ORDER BY post_id DESC LIMIT 3';
                $querylastnews = $forum->prepare($getlastnews);
                $querylastnews->execute();

                while($row = $querylastnews->fetch(PDO::FETCH_OBJ))
                {
                    echo '<div id="forumheader" style="font-size: 21px;">'.$row->Title.'</div>';
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

                    echo '<div class="postframe" id="main">
                       <div class="postauthor">
                           <div class="post-author-avatar">
                           <img style="border: 0px;" width="60" height="60" src="/img/avatar'.$row1->Avatar.'.png">
                           </div>
                           <div class="post-author-username"><a href="/userpage.php?id='.$row->u_id.'" style="color: white;">'.$row1->uLogin.'</a></div>';
                           if($row1->Moder) {
                               echo '<div class="post-moder">Модератор</div>';
                           }
                           echo '<div class="post-author-stat">Активность:<br/>'.$countuserposts.' сообщений</div>';
                    echo '</div>
                       <div class="posttext">
                           <div class="postheader">
                               <span style="margin-left: 15px;">Опубликовано: '.$row->PostDate.'
                               </span>
                           </div>
                           <div class="posttextcontent">'.$row->Content.'
                           </div>
                       </div>
                   </div>
                   <div class="index-link"><a href="/forums/post.php?id='.$row->post_id.'">Перейти к новости на форуме</a></div>';
                }
                ?>
               </div>
            </div>
            </div>
            </div>
       </div> 
    </body>
</html>
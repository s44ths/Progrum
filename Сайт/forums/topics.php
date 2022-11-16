<?php require "D:/Stuff/XXX/htdocs/layout/globalscripts.php" ?>

<?php
if(is_null($_GET['id'])) {
    header('Location: /');
}
?>

<html>
    <?php require "D:/Stuff/XXX/htdocs/layout/head.php" ?>
    <title>Форумы</title>
    <body>
       <div class="container">
           <?php require "D:/Stuff/XXX/htdocs/layout/banner.php" ?>
           <div class="flexarea">
           <?php require "D:/Stuff/XXX/htdocs/layout/leftmenu.php" ?>
           <div class="mainfullarea">
           <div class="main">
               <div class="content">
                   <div style="position:relative; width:705px; height:69px; left:0; top: 11px;">
                        <a class="header">
                            <?php
                            $sqltopics = 'SELECT * FROM `globaltopics` WHERE topic_id = :cur_t_id';
                            $query_t = $forum->prepare($sqltopics);
                            $query_t->execute(['cur_t_id' => $_GET['id']]);
                            $row_t = $query_t->fetch(PDO::FETCH_OBJ);
                            echo $row_t->Name;
                            ?>
                        </a>
                   </div>
                   <?php 
                   if(isset($_COOKIE['Login']) && ($_GET['id'] != 8 || $_COOKIE['moder'] == 1)) {
                   echo '<div id="forum-controls">
                        <form method="GET" action="/forums/newtopic.php">
                            <input type="hidden" name="id" value='.$_GET['id'].'>
                            <input type="submit" value="Новая тема" class="bluebutton">
                        </form>
                   </div>';
                   }
                   ?>
                   <div class="forumcontent">
                       <div class="tableheader">
                            <div style="margin-top: 3px;">
                            <span style="margin-left:15px;">Тема</span>
                            <span style="margin-left:354px">Ответы</span>
                            <span style="margin-left:20px">Последний комментарий</span>
                            </div>
                        </div>
                        <table id="postlist">
                        <?php
                        $sqlposts = 'SELECT * FROM `forumposts` WHERE topic_id = :cur_t_id ORDER BY lastcomment DESC';
                        $query = $forum->prepare($sqlposts);
                        $query->execute(['cur_t_id' => $_GET['id']]);

                        while($row = $query->fetch(PDO::FETCH_OBJ)) {
                            $sqlcoms = $forum->query('SELECT COUNT(*) FROM `comments` WHERE post_id ='.$row->post_id);
                            $countc = $sqlcoms->fetchColumn();
                            echo '<tr><td class="status-post">';
                            if($row->isClosed)
                               echo'<img style="padding-left:4px;" src="/img/locked-ico.png">';
                            echo '</td>';
                            echo'<td class="topic"><a href="/forums/post.php?id='.$row->post_id.'">'.$row->Title.'</a><br> <div style="font-size: 12px;">Автор: ';
                            
                            $comand1 = 'SELECT uLogin FROM `user` WHERE u_id = :posterid';
                            $query1 = $forum->prepare($comand1);
                            $query1->bindValue(":posterid", $row->u_id, PDO::PARAM_STR);
                            $query1->execute();
                            $row1 = $query1->fetch(PDO::FETCH_OBJ);
                            
                            echo '<a href="/userpage.php?id='.$row->u_id.'">'.$row1->uLogin.'</a></div></td>
                            <td class="activity"><img class="column-divider-left" src="/img/graydot.gif" width="1" height="25"><img class="column-divider-right" src="/img/graydot.gif" width="1" height="25"> <div class="common-text">'.$countc.
                            '</div></td>
                            <td class="lastpost"><div class="common-text">'.$row->LastComment.'</div></td>
                            </tr>';
                        }
                        ?>
                        </table>
                   </div>
                          
               </div>
            </div>
            </div>
            </div>
       </div> 
    </body>
</html>
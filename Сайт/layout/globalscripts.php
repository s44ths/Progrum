<script language="JavaScript">
    function showTime(){
        var Now = new Date();
        var str="";
        var actualMounth = Now.getMonth() + 1;
        str += Now.getDate()+"."+ actualMounth + "." + Now.getFullYear() + " ";
        str += Now.getHours() + ":" + Now.getMinutes();
        document.write(str);
        }
</script>

<?php
$timestamp = date("YmdHis"); 
?>

<?php
$dbinfo = 'mysql:host=localhost;dbname=forum';
$forum = new PDO($dbinfo, 'root');

if(isset($_COOKIE['id']))
{
    $updateonlinesql = 'UPDATE `user` SET LastSeen = :curtime WHERE u_id = :userid';

    date_default_timezone_set('Europe/Moscow');
    $curdate_online = new DateTime();

    $updateonline = $forum->prepare($updateonlinesql);
    $updateonline->execute(['curtime' => date_format($curdate_online, 'Y-m-d H:i:s'), 'userid' => $_COOKIE['id']]);
}
?>
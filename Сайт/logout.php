<?php
setcookie ("Login", "", time() - 3600*24);
setcookie ("id", "", time() - 3600*24);
setcookie ("moder", "", time() - 3600*24);
setcookie ("avatar", "", time() - 3600*24);

header('Location: /');
?>
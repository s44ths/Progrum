<?php require "layout/globalscripts.php" ?>

<html>
    <?php require "D:/Stuff/XXX/htdocs/layout/head.php" ?>
    <title>Вход</title>
    <body>
        <?php
        if(isset($_COOKIE['Login'])) {
            header('Location: /');
        }
        ?>
       <div class="container">
           <?php require "layout/banner.php" ?>
           <div class="flexarea">
           <?php require "layout/leftmenu.php" ?>
           <div class="mainfullarea">
           <div class="main">
               <div class="content">
                   <div class="logintext-area">
                       <div class="logintext-text">
                           <div style="margin-left: 220px;">
                           <em>Добро пожаловать!</em></div>
                           <div class="logintext-reg"> 
                               <div style="margin-left: 110px;">
                                    Вход
                               </div>
                               <div style="margin-left: 280px;"> 
                                    Регистрация
                               </div>
                           </div>
                        </div>
                    </div>
                    <div class="regforms">
                        <div style="margin-left: 50px;">
                        <form method="POST" action="/auth.php">
                        <div class = "commoncolumn">
                            <input id="Login" class="input_reg" style="width: 200px;" maxlength="15" placeholder="Логин" name="Login" type="text"><br>
                            <input id="Password" type="password" class="input_reg" style="width: 200px; margin-top: 5px;" maxlength="25" placeholder="Пароль" name="Password" type="text">
                        </div>
                        <br> <input type="submit" style="margin-left: 60px;" value="Вход" name="button" class="bluebutton" id="submit">
                        </form>
                        </div>
                        <div style="margin-left: 150px;">
                        <form method="POST" action="/register.php">
                        <div class = "commoncolumn" style="margin-bottom: 10px;">
                            <input id="Login" class="input_reg" style="width: 200px;" maxlength="15" placeholder="Логин" name="Login" type="text"><br>
                            <input id="Password" type="password" class="input_reg" style="width: 200px; margin-top: 5px;" maxlength="25" placeholder="Пароль" name="Password" type="text">
                            <input id="PasswordConfirm" type="password" class="input_reg" style="width: 200px; margin-top: 5px;" maxlength="25" placeholder="Повторите пароль" name="PasswordConfirm" type="text">
                        </div>
                        <br> <input type="submit" style="margin-left: 42px;" value="Регистрация" name="button" class="bluebutton" id="submit">
                        </form>
                        </div>
                    </div>
                </div>
            </div>
            </div>
       </div> 
    </body>
</html>
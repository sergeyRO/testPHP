<?php
include_once('header.php');
include_once('db.php');
?>
<?php
session_start();
?>
<?php

if(isset($_SESSION["session_login"])){
    header("Location: intropage.php");
}

if(isset($_POST["sb_login"]))
{
    $pdo = (new db())->connect();
    $login = $_POST['login'];
    $pass = $_POST['pass'];
    $data = $pdo->query("SELECT * FROM users WHERE login='" . $login . "' AND pass='" . $pass . "'")->fetchAll(PDO::FETCH_UNIQUE);
    if ($data)
    {
        foreach ($data as $k => $v) {
            $dblogin = $v['login'];
            $dbpass = $v['pass'];

            if ($login == $dblogin && $pass == $dbpass) {
                $email = $v['email'];
                $id = $v['id'];
                $_SESSION['session_login'] = [$login, $pass, $email,$id];
                header("Location: intropage.php");
            }
        }
    }
    else echo "Неверный логин или пароль!";

}
?>
    <div>
        <h1>Вход</h1>
        <form action="" method="post">
            <p><label for="login">Логин<br>
                    <input class="input" id="login" name="login" size="20" type="text" value=""></label></p>
            <p><label for="pass">Пароль<br>
                    <input class="input" id="password" name="pass" size="20" type="password" value=""></label></p>
            <p class="submit"><input class="button" name="sb_login" type= "submit" value="Вход"></p>
            <p class="regtext">Еще не зарегистрированы?<a href= "register.php">Регистрация</a>!</p>
        </form>
    </div>
<?php
include_once('footer.php');
?>
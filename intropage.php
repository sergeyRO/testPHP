<?php
session_start();
if(!isset($_SESSION["session_login"])):
    header("location:/");
else:
    if(isset($_POST['update']))
    {
        include_once('db.php');
        $pdo = (new db())->connect();
        $login = $_POST['login'];
        $email = $_POST['email'];
        $pass = $_POST['pass'];
        $id  = $_SESSION['session_login'][3];
        $data = $pdo->query('SELECT * FROM users where login="'.$login.'"')->fetchAll(PDO::FETCH_UNIQUE);
        if(!$data) {
            $ins = $pdo->prepare('UPDATE users SET email=:email, login=:login, pass=:pass WHERE id=:id');
            $ins->execute([
                'email' => $email,
                'login' => $login,
                'pass' => $pass,
                'id' => $id
            ]);
            if ($ins) {
                $message = "<p style='color: green;'><b>Данные по пользователю обновлены!</b>";
            } else {
                $message = "<p style='color: red;'><b>Не удалось обновить информацию о данных!</b></p>";
            }
        }
        else {$message = "<p style='color: red;'><b>Введёный логин существует, попробуйте изменить!</b></p>";}
            }
    ?>
    <?php include("header.php"); ?>
    <?php if (!empty($message)) {echo $message;} ?>
    <div id="welcome">
        <h2>Добро пожаловать, <span><?php echo $_SESSION['session_login'][0];?>! </span></h2>

        <form action="intropage.php" method="POST">
            <p><label for="email">E-mail<br>
                    <input class="input" id="email" name="email" size="20" type="text" value="<?php echo $_SESSION['session_login'][2];?>" required></label></p>
            <p><label for="login">Логин<br>
                    <input class="input" id="login" name="login" size="20" type="text" value="<?php echo $_SESSION['session_login'][0];?>" required></label></p>
            <p><label for="pass">Пароль<br>
                    <input class="input" id="password" name="pass" size="20" type="password" value="<?php echo $_SESSION['session_login'][1];?>" required></label></p>
            <p class="submit"><input class="button" name="update" type= "submit" value="Обновить"></p>
        </form>

        <p><a href="logout.php">Выйти</a> из системы</p>
    </div>
    <?php include_once('footer.php'); ?>
<?php endif; ?>

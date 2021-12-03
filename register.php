<?php
include_once('header.php');
include_once('db.php');
?>
<?php
if(isset($_POST["register"])){
    $pdo = (new db())->connect();
    $login = $_POST['login'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $data = $pdo->query('SELECT * FROM users where login="'.$login.'"')->fetchAll(PDO::FETCH_UNIQUE);
    if(!$data)
    {
        $ins = $pdo->prepare('INSERT INTO users (email,login,pass) VALUES (:email, :login, :pass)');
        $ins->execute([
            'email' => $email,
            'login' => $login,
            'pass' => $pass,
        ]);
        if($ins)
        {
            $message = "<p style='color: green;'><b>Аккаунт создан, для входа перейдите по ссылке <a href='/'>ВХОД</a></b>";
        } else {
            $message = "<p style='color: red;'><b>Не удалось вставить информацию о данных!</b></p>";
        }
    }
    else {
        $message = "<p style='color: red;'><b>Это имя пользователя уже существует! Пожалуйста, попробуйте другой!</b></p>";
    }
}
?>

<?php if (!empty($message)) {echo $message;} ?>
<div class="container mregister">
    <div id="login">
        <h1>Регистрация</h1>
        <form action="register.php" method="post">
            <p><label for="login">Логин<br>
                    <input class="input" id="login" name="login" size="32"  type="text" value="" required></label></p>
            <p><label for="email">E-mail<br>
                    <input class="input" id="email" name="email" size="32" type="email" value="" required></label></p>
            <p><label for="pass">Пароль<br>
                    <input class="input" id="pass" name="pass" size="32"   type="password" value="" required></label></p>
            <p><input class="button" id="register" name= "register" type="submit" value="Зарегистрироваться"></p>
            <p>Уже зарегистрированы? <a href= "/">Введите имя пользователя</a>!</p>
        </form>
    </div>
</div>
<?php
include_once('footer.php');
?>
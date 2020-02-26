<?php
session_start();

if ($_SESSION['user']) {
    header('Location: main.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
</head>

<body>
    <form method="post" action="vendor/sign_up_handler.php">
        <label for="name">Имя* </label>
        <input type="text" name="name" id="name" required /><br>
        <label for="login">Логин* </label>
        <input type="text" name="login" id="login" required /><br>
        <label for="password">Пароль* </label>
        <input type="password" name="password" id="password" required /><br>
        <input type="submit" value="Зарегистрироваться" />
        <?php
        if ($_SESSION['message']) {
            echo '<p class="msg"> ' . $_SESSION['message'] . ' </p>';
        }
        unset($_SESSION['message']);
        ?>
    </form>
</body>

</html>
<?php
session_start();
require_once 'connect.php';

$login = !empty(trim($_POST['login'])) ? trim($_POST['login']) : null;
$password = !empty(trim($_POST['password'])) ? trim($_POST['password']) : null;

if ($login && $password) {
    $query = "SELECT id, name, login, password FROM user WHERE login=?";
    $statement = $connect->prepare($query);
    $statement->bind_param('s', $login);
    $statement->execute();
    $statement->bind_result($id, $name, $login, $db_password);

    if ($statement->fetch()) {

        if (password_verify($password, $db_password)) {
            $_SESSION['user'] = [
                "id" => $id,
                "name" => $name,
                "login" => $login
            ];
            $_SESSION['message'] = 'Вы успешно авторизовались!';
            header('Location: ../main.php');
        } else {
            $_SESSION['message'] = 'Неверный пароль';
            header('Location: ../index.php');
        }
    } else {
        $_SESSION['message'] = 'Такого пользователя не существует!';
        header('Location: ../index.php');
    }
    $statement->close();
} else {
    $_SESSION['message'] = 'Заполните все поля!';
    header('Location: ../index.php');
}

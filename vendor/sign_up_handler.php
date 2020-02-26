<?php
session_start();
require_once 'connect.php';

$name = !empty(trim($_POST['name'])) ? trim($_POST['name']) : null;
$login = !empty(trim($_POST['login'])) ? trim($_POST['login']) : null;
$password = !empty(trim($_POST['password'])) ? trim($_POST['password']) : null;

if ($name && $login && $password) {
    if (check_unique($login, $connect)) {
        $password_hash = password_hash($password, PASSWORD_BCRYPT);
        $query = "INSERT INTO user (name, login, password) VALUES (?, ?, ?)";
        $statement = $connect->prepare($query);
        $statement->bind_param('sss', $name, $login, $password_hash);

        if ($statement->execute()) {
            $_SESSION['message'] = 'Вы зарегистрировались';
            header('Location: ../index.php');
            die();
        } else {
            $_SESSION['message'] = 'Ошибка! не удалось зарегистрироваться';
        }
        $statement->close();
    } else {
        $_SESSION['message'] = 'Логин уже занят!';
    }
} else {
    $_SESSION['message'] = 'Заполните все поля!';
}
header('Location: ../sign_up.php');

function check_unique($login, $connect)
{
    $query = "SELECT login FROM user WHERE login=?";
    $statement = $connect->prepare($query);
    $statement->bind_param('s', $login);
    $statement->execute();
    $statement->store_result();

    if ($statement->num_rows == 0) {
        return true;
    } else {
        return false;
    }
}

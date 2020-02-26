<?php
session_start();
require_once 'connect.php';

$name = !empty(trim($_POST['name'])) ? trim($_POST['name']) : null;
$comment = !empty(trim($_POST['comment'])) ? trim($_POST['comment']) : null;
$file_name = !empty($_FILES['file']['name']) ? $_FILES['file']['name'] : null;
$date = date("Y-m-d H:i:s");

if ($name && $comment && $file_name) {
    $file_hash = md5(hash_file('md5', $_FILES['file']['tmp_name']) . md5($date));
    $path_info = pathinfo($file_name);
    $ext = $path_info['extension'];
    $whitelist = ['pdf', 'jpg', 'jpeg', 'png'];
    
    if (in_array($ext, $whitelist)) {
        insert_data($name, $comment, $file_name, $file_hash, $connect);
        move_uploaded_file($_FILES['file']['tmp_name'], "../accounts/$file_hash.$ext");
        $response = [
            'name' => $name,
            'comment' => $comment,
            'file_name' => $file_name,
            'file_ext' => $ext,
            'file_hash' => $file_hash,
            'status' => 'Ожидает',
            'date' => $date,
            'error' => 0,
        ];
    } else {
        $response = ['error' => 'Неверное расширение файла! Допустимые: pdf, jpg, jpeg, png'];
    }
    
} else {
    $response = ['error' => 'Заполните все поля!'];
}
echo json_encode($response);

function insert_data($name, $comment, $file_name, $file_hash, $connect)
{
    $user_id = $_SESSION['user']['id'];
    $query = "INSERT INTO client_account (name, comment, file_name, file_hash, user_id) VALUES(?, ?, ?, ?, ?)";
    $statement = $connect->prepare($query);

    $statement->bind_param('ssssi', $name, $comment, $file_name, $file_hash, $user_id);

    if (!$statement->execute()) {
        die('Error : (' . $connect->errno . ') ' . $connect->error);
    }
    $statement->close();
}

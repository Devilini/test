<?php
session_start();
require_once 'connect.php';

$id = $_POST["id"];

if (!empty($id)) {
    $file = get_file($id, $connect);
    $query = "DELETE FROM client_account WHERE id=?";
    $statement = $connect->prepare($query);
    $statement->bind_param('i', $id);

    if ($statement->execute()) {
        if (file_exists($file)) {
            unlink($file);
        }
        $response = 1;
    } else {
        $response = 0;
    }
    $statement->close();
} else {
    $response = 0;
}
echo $response;

function get_file($id, $connect, $directory = '../accounts/')
{
    $query = "SELECT file_hash, file_name FROM client_account WHERE id=?";
    $statement = $connect->prepare($query);
    $statement->bind_param('i', $id);
    $statement->execute();
    $statement->bind_result($file_hash, $file_name);
    while ($statement->fetch()) {
        $ext = array_pop(explode(".", $file_name));
        $file = $directory . $file_hash . '.' . $ext;

        return $file;
    }
}

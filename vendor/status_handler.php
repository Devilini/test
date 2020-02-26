<?php
session_start();
require_once 'connect.php';

$id = $_POST["id"];
$status = $_POST["status"];

if (!empty($id) && !empty($status)) {
    $query = "UPDATE client_account SET status=?,  updated_at=NOW() WHERE id=?";
    $statement = $connect->prepare($query);
    $statement->bind_param('ii', $status, $id);

    if ($statement->execute()) {
        $response = $status;
    } else {
        $response = 0;
    }
    $statement->close();
} else {
    $response = 0;
}
echo convert_status($response);

function convert_status($response)
{
    if ($response == 1) {
        $status = 'Одобрен';
    } elseif ($response == 2) {
        $status = 'Отклонен';
    } else {
        $status = 0;
    }
    return $status;
}

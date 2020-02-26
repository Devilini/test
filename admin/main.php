<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['is_admin'] != 1) {
    header('Location: ../main.php');
}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title></title>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
</head>

<body>
    <a href="/vendor/logout.php">Выход</a>
    <p>Здравствуйте, <?= $_SESSION['user']['name'] ?></p>
    <?php
    if ($_SESSION['message']) {
        echo '<p> ' . $_SESSION['message'] . ' </p>';
    }
    unset($_SESSION['message']);
    ?>

    <br>
    <div id="error_data" style="color: red"></div>
    <?php
    $mysqli = new mysqli('localhost', 'root', '', 'test');

    if ($mysqli->connect_error) {
        die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }
    $results = $mysqli->query("SELECT client_account.id,  client_account.name,  client_account.comment,  client_account.file_name, 
    client_account.file_hash, client_account.status, client_account.created_at, user.name AS username FROM client_account JOIN user ON 
    client_account.user_id = user.id ORDER BY client_account.created_at DESC");
    ?>

    <h2>Таблица счетов</h2>
    <table border="1" bgcolor="#E6E6FA" id="account_table">
        <thead>
            <tr bgcolor="#D8BFD8">
                <th>Номер</th>
                <th>Название</th>
                <th>Комментарий</th>
                <th>Файл</th>
                <th>Статус</th>
                <th>Дата заявки</th>
                <th>Имя клиента</th>
                <th>X</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $results->fetch_assoc()) {
                $path_info = pathinfo($row["file_name"]);
                $ext = $path_info['extension'];
                if ($row["status"] == 1) {
                    $status = 'Одобрен';
                } elseif ($row["status"] == 2) {
                    $status = 'Отклонен';
                } else {
                    $status = 'Ожидает';
                }
            ?>
                <tr id="<?= $row["id"]; ?>">
                    <td><?= $row["id"]; ?></td>
                    <td><?= $row["name"]; ?></td>
                    <td><?= $row["comment"]; ?></td>
                    <td><a href="/accounts/<?= $row["file_hash"] . '.' . $ext; ?>" download><?= $row["file_name"]; ?></a></td>
                    <td><span><?= $status; ?></span><button class="btn-status" data-status="1">одобрить</button>
                        <button class="btn-status" data-status="2">отклонить</button></td>
                    <td><?= $row["created_at"] ?></td>
                    <td><?= $row["username"]; ?></td>
                    <th><button class="del-row">x</button></th>
                </tr>
            <?php
            }
            $mysqli->close();
            ?>
        </tbody>
    </table><br>
    <script type="text/javascript" src="../assets/script_admin.js"></script>
</body>

</html>

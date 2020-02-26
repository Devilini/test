<?php
session_start();
if (!$_SESSION['user']) {
    header('Location: index.php');
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
    <form method="post" id="account_form" enctype="multipart/form-data" accept-charset="utf-8">
        <label for="name">Назначение* </label>
        <input type="text" name="name" id="name" required /><br>
        <label for="file">Счет* </label>
        <input type="file" name="file" id="file" required /><br>
        <label for="comment">Комментарий* </label>
        <input type="text" name="comment" id="comment" required /><br>
        <input type="button" id="btn" value="Отправить" />
    </form>
    <br>
    <div id="error_data" style="color: red"></div>

    <?php
    $mysqli = new mysqli('localhost', 'root', '', 'test');
    if ($mysqli->connect_error) {
        die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }
    $id = $_SESSION['user']['id'];
    $results = $mysqli->query("SELECT * FROM client_account WHERE user_id = $id ORDER BY created_at DESC");
    ?>

    <h2>Таблица счетов</h2>
    <table border="1" bgcolor="#E6E6FA" id="account_table">
        <thead>
            <tr bgcolor="#D8BFD8">
                <th>Название</th>
                <th>Комментарий</th>
                <th>Файл</th>
                <th>Статус</th>
                <th>Дата</th>
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
                <tr>
                    <td><?= $row["name"]; ?></td>
                    <td><?= $row["comment"]; ?></td>
                    <td><a href="/accounts/<?= $row["file_hash"] . '.' . $ext; ?>" download><?= $row["file_name"]; ?></a></td>
                    <td><?= $status; ?></td>
                    <td><?= $row["created_at"] ?></td>
                </tr>
            <?php
            }
            $mysqli->close();
            ?>
        </tbody>
    </table><br>
    <script type="text/javascript" src="/assets/script.js"></script>
</body>

</html>

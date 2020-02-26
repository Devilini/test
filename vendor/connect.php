<?php
$connect = new mysqli('127.0.0.1', 'root', '', 'test');

if ($connect->connect_error) {
    die('Error : (' . $connect->connect_errno . ') ' . $connect->connect_error);
}

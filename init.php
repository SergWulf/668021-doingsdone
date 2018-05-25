<?php
require_once('userdata.php');
require_once('mysql_helper.php');
require_once('functions.php');
session_start();


//Подключится к базе данных
$link = mysqli_connect('localhost', 'root', '', 'doingsdone');
if ($link == FALSE) {
    die('Ошибка подключения: '.mysqli_connect_error());
}
// Устанавливаем кодировку
mysqli_set_charset($link, 'utf8');

?>
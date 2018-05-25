<?php
require_once('data.php');
require_once('mysql_helper.php');
require_once('functions.php');


//Подключится к базе данных
$link = mysqli_connect('localhost', 'root', '', 'doingsdone');
if ($link == FALSE) {
    die('Ошибка подключения: '.mysqli_connect_error());
}
// Устанавливаем кодировку
mysqli_set_charset($link, 'utf8');

?>
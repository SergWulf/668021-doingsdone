<?PHP
session_start();

if ($_SESSION['username']) {
    unset($_SESSION['username']);
    header('Location: /index.php');
}
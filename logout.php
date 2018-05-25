<?PHP
require_once('init.php');

if ($_SESSION['username']) {
    unset($_SESSION['username']);
    unset($_SESSION['current_project_id']);
    header('Location: /index.php');
}
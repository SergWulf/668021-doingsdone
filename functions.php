<?php

// Функция подсчета количества проектов

function count_projects(mysqli $link, int $user_id)
{
    $sql_count_projects = 'SELECT project_id, count(*) AS cnt FROM tasks WHERE user_id = ? GROUP BY project_id';
    $stmt = db_get_prepare_stmt($link, $sql_count_projects, [$user_id]);
    mysqli_stmt_execute($stmt);
    $mysqli_result = mysqli_stmt_get_result($stmt);
    $aggregated_projects = mysqli_fetch_all($mysqli_result, MYSQLI_ASSOC);
    $result = [];
    $count_all = 0;
    foreach ($aggregated_projects as $project) {
        $result[$project['project_id']] = (int)$project['cnt'];
        $count_all += (int)$project['cnt'];
    }
    $result[PROJECT_ALL] = $count_all;
    return $result;
}

// Функция - шаблонизатор
function include_template($template, $vars_array)
{
    if (file_exists($template) == FALSE) {
        return '';
    }

    extract($vars_array);
    ob_start();
    require_once($template);
    $content = ob_get_clean();
    return $content;
}

/**
 * Функция сигнализирует о том, что на время выполнения задачи осталось меньше 24 часов
 */

function task_important($task)
{
    $cur_time = time();
    $task_time = strtotime($task['limit_date_task']);
    //Переменная хранящая разницу в часах между текущим временем и датой выполнения задачи
    $diff_time_hours = floor(($task_time - $cur_time) / 3600);

    if ($diff_time_hours <= 24)
    {
        return TRUE;
    }
    return FALSE;
}

function getUserById(mysqli $link, int $user_id)
{
    $sql_user_id = 'SELECT id, name_user  FROM users WHERE id = ?';
    $stmt = db_get_prepare_stmt($link, $sql_user_id, [$user_id]);
    mysqli_stmt_execute($stmt);
    $mysqli_result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($mysqli_result);
    return $user;
}

function getProjectsByUserId(mysqli $link, int $user_id)
{
    $sql_projects_user_id = 'SELECT * FROM projects WHERE user_id = ?';
    $stmt = db_get_prepare_stmt($link, $sql_projects_user_id, [$user_id]);
    mysqli_stmt_execute($stmt);
    $mysqli_result = mysqli_stmt_get_result($stmt);
    $projects = mysqli_fetch_all($mysqli_result, MYSQLI_ASSOC);
    return $projects;
}

function getTasks(mysqli $link, int $user_id, bool $show_complete_tasks, int $project_id)
{
    $sql = 'SELECT * FROM tasks';
    $where_clause = [];
    $params = [];

    $where_clause[] = 'user_id = ?';
    $params[] = $user_id;

    if (! $show_complete_tasks) {
        $where_clause[] = 'status = false';
    }

    if ($project_id !== PROJECT_ALL) {
        $where_clause[] = 'project_id = ?';
        $params[] = $project_id;
    }


    if (count($where_clause)) {
        $sql = $sql . ' WHERE ' . implode(' AND ', $where_clause);
    }
    $stmt = db_get_prepare_stmt($link, $sql, $params);
    mysqli_stmt_execute($stmt);
    $mysqli_result = mysqli_stmt_get_result($stmt);
    $tasks = mysqli_fetch_all($mysqli_result, MYSQLI_ASSOC);
    return $tasks;
}

function addProjectByUserId (mysqli $link, int $user_id, $data_task_project)
{

    // Извлекаем параметры из массива и подготавлиаваем их для запроса
    $params = [];
    $params[] = $user_id;
    $params[] = $data_task_project['name'];


    //Составляем SQL запрос
    $sql = "INSERT INTO projects (`user_id`,`name_project`) VALUES (?, ?)";
    $stmt = db_get_prepare_stmt($link, $sql, $params);
    mysqli_stmt_execute($stmt);

    return mysqli_insert_id($link);
}

function addTaskByUserId (mysqli $link, int $user_id, $data_task_form)
{

    // Извлекаем параметры из массива и подготавлиаваем их для запроса
    $params = [];
    $params[] = $user_id;
    $params[] = $data_task_form['project'];
    $params[] = $data_task_form['name'];
    $params[] = $data_task_form['create_date'];
    $params[] = $data_task_form['date'];
    $params[] = $data_task_form['file'];

    //Составляем SQL запрос
    $sql = "INSERT INTO tasks (`user_id`, `project_id`, `name_task`, `create_date_task`, `run_date_task`, `limit_date_task`, `file_task`, `status`) VALUES (?, ?, ?, ?, null, ?, ?, false)";
    $stmt = db_get_prepare_stmt($link, $sql, $params);
    mysqli_stmt_execute($stmt);

    return mysqli_insert_id($link);

}

function validateDate($date)
{
    $format = 'Y-m-d H:i:s';
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

function addUser(mysqli $link, $data_register_form)
{
    $params = [];
    $params[] = $data_register_form['name'];
    $params[] = $data_register_form['email'];
    $params[] = $data_register_form['password'];
    $params[] = $data_register_form['date'];


    $sql = "INSERT INTO users (`name_user`, `email_user`, `password_user`, `reg_date_user`, `contact_user`) VALUES (?, ?, ?, ?, null)";
    $stmt = db_get_prepare_stmt($link, $sql, $params);
    mysqli_stmt_execute($stmt);

    return mysqli_insert_id($link);
}

function checkEmailUser(mysqli $link, $email_user)
{
    $params = [];
    $params[] = $email_user;

    // Получить данные пользователя
    $sql = "SELECT * FROM users WHERE `email_user` = ?";

    $stmt = db_get_prepare_stmt($link, $sql, $params);
    mysqli_stmt_execute($stmt);
    $mysqli_result = mysqli_stmt_get_result($stmt);
    $data_user = mysqli_fetch_assoc($mysqli_result);

    return $data_user;
}
?>
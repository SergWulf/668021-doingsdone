<?php

// Функция подсчета количества проектов
function count_projects(int $user_id, mysqli $link)
{
    $sql_count_projects = 'SELECT project_id, count(*) AS cnt FROM tasks WHERE user_id = ? GROUP BY project_id';
    $stmt = db_get_prepare_stmt($link, $sql_count_projects, [$user_id]);
    mysqli_stmt_execute($stmt);
    $mysqli_result = mysqli_stmt_get_result($stmt);
    $cnt_projects = mysqli_fetch_all($mysqli_result, MYSQLI_ASSOC);
    $cnt_rows_projects = mysqli_num_rows($mysqli_result);
    $count_all_projects = 0;
    foreach ($cnt_projects as $index => $values)
    {
        $count_all_projects = $cnt_projects[$index]['cnt'] + $count_all_projects;
    }
    $cnt_projects[$cnt_rows_projects]['project_id'] = 'project_all';
    $cnt_projects[$cnt_rows_projects]['cnt'] = $count_all_projects;
    return $cnt_projects;
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

function getUserById(int $user_id, mysqli $link)
{
    $sql_user_id = 'SELECT id, name_user  FROM users WHERE id = ?';
    $stmt = db_get_prepare_stmt($link, $sql_user_id, [$user_id]);
    mysqli_stmt_execute($stmt);
    $mysqli_result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($mysqli_result);
    return $user;
}

function getProjectsByUserId(int $user_id, mysqli $link)
{
    $sql_projects_user_id = 'SELECT * FROM projects WHERE user_id = ?';
    $stmt = db_get_prepare_stmt($link, $sql_projects_user_id, [$user_id]);
    mysqli_stmt_execute($stmt);
    $mysqli_result = mysqli_stmt_get_result($stmt);
    $projects = mysqli_fetch_all($mysqli_result, MYSQLI_ASSOC);
    return $projects;
}

function getTasksByUser(int $user_id, mysqli $link)
{
    $sql_tasks_user_id = 'SELECT * FROM tasks WHERE user_id = ?';
    $stmt = db_get_prepare_stmt($link, $sql_tasks_user_id, [$user_id]);
    mysqli_stmt_execute($stmt);
    $mysqli_result = mysqli_stmt_get_result($stmt);
    $tasks = mysqli_fetch_all($mysqli_result, MYSQLI_ASSOC);
    return $tasks;
}
?>
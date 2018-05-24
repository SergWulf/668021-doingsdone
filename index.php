<?php
require_once('init.php');

/**
 * Получаем данные из БД и преобразовываем их в массивы.
 */

// Получаем имя текущего пользователя по id
$row_user = getUserById(2, $link);
$name_user = $row_user['name_user'];

// SQL-запрос для получения списка проектов у текущего пользователя
$project_array = getProjectsByUserId(2, $link);

//SQL-запрос для получения списка задач для выбранного проекта
$array_tasks = getTasksByUser(2,$link);

//Подсчет количества задач для каждого проекта
$count_projects_array = count_projects(2, $link);

$page_content = include_template('templates/index.php', ['array_tasks' => $array_tasks]);
$layout_content = include_template('templates/layout.php', [
    'title' => 'Дела в порядке',
    'name_user' => $name_user,
    'content' => $page_content,
    'project_array' => $project_array,
    'array_tasks' => $array_tasks,
    'count_projects_array' => $count_projects_array,
]);
print($layout_content);
?>

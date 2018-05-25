<?php
require_once('init.php');

/**
 * Получаем данные из БД и преобразовываем их в массивы.
 */

// Получаем имя текущего пользователя по id
$row_user = getUserById($link, $user_id);
$name_user = $row_user['name_user'];

// SQL-запрос для получения списка проектов у текущего пользователя
$project_array = getProjectsByUserId($link, $user_id);

//Подсчет количества задач для каждого проекта
$count_projects_array = count_projects($link, $user_id);


if (isset($_GET['id'])) {
    $project_exists = false;
    foreach ($project_array as $project){
        if ($_GET['id'] == $project['id']){
            $current_project_id = $project['id'];
            $project_exists = true;
            break;
        }
    }
    if (! $project_exists) {
        http_response_code(404);
        echo include_template('templates/error404.php', ['message' => 'Ошибка 404, такой страницы не существует']);
        exit;
    }
}

//SQL-запрос для получения списка задач для выбранного проекта
$array_tasks = getTasks($link, $user_id, $show_complete_tasks, $current_project_id);

$page_content = include_template('templates/index.php', [
    'array_tasks' => $array_tasks,
    'show_complete_tasks' => $show_complete_tasks
]);
$layout_content = include_template('templates/layout.php', [
    'title' => 'Дела в порядке',
    'name_user' => $name_user,
    'content' => $page_content,
    'project_array' => $project_array,
    'array_tasks' => $array_tasks,
    'count_projects_array' => $count_projects_array,
    'current_project_id' => $current_project_id
]);
print($layout_content);
?>

<?php
require_once('data.php');
require_once('functions.php');

//Подключится к базе данных
$link = mysqli_connect('localhost', 'root', '', 'doingsdone');
if ($link == FALSE) {
    print ('Ошибка подключения: '.mysqli_connect_error());
}
else {
    mysqli_set_charset($link, 'utf8');

    // Получаем имя текущего пользователя
    $sql_user = 'SELECT * FROM users WHERE id = 2';
    $result = mysqli_query($link, $sql_user);
    if (!$result){
        $error = mysqli_error($link);
        print('Ошибка MySQL: '.$error);
    }
    if ($result) {
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $name_user = $rows[0]['name_user'];
    }

    // SQL-запрос для получения списка проектов у текущего пользователя
    $sql_projects = 'SELECT * FROM projects WHERE user_id = 2';
    $result = mysqli_query($link, $sql_projects);
    if (!$result){
        $error = mysqli_error($link);
        print('Ошибка MySQL: '.$error);
    }
    if ($result) {
        $list_projects = mysqli_fetch_all($result, MYSQLI_ASSOC);
        /**
         * Добавляем в начало массива элемент с названием "Все", который будет использоваться только для подсчёта кол-ва проектов
         */
        $project_array = [
            0 => [
                'id' => 0,
                'name_project' => 'Все'
            ]
        ];
        foreach ($list_projects as $id_project => $project) {
            $project_array[$id_project+1] = $project;
        }
    }

    //SQL-запрос для получения списка задач для выбранного проекта
    $sql_tasks = 'SELECT * FROM tasks WHERE user_id = 2';
    $result = mysqli_query($link, $sql_tasks);
    if (!$result){
        $error = mysqli_error($link);
        print('Ошибка MySQL: '.$error);
    }
    if ($result) {
        $list_tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);
        foreach ($list_tasks as $id_task => $task) {
            $array_tasks[$id_task] = $task;
        }
    }
}

$page_content = include_template('templates/index.php', ['array_tasks' => $array_tasks]);
$layout_content = include_template('templates/layout.php', [
    'title' => 'Дела в порядке',
    'name_user' => $name_user,
    'content' => $page_content,
    'project_array' => $project_array,
    'array_tasks' => $array_tasks
]);
print($layout_content);
?>

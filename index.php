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

// Проверка переменной id
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

// Проверяем, что форма отправлена, проводим валидацию данных.
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{

    // Валидация полей формы: имя, проект, дата
    foreach ($_POST as $field => $value) {
        if ($field == 'name'){
            if (empty($_POST[$field])) $errors_form_task[$field] = 'Поле на заполнено!';
            $data_fields_from_task[$field] = $_POST[$field];
        }
        if ($field == 'project'){
            $select_project_exist = false;
            foreach($project_array as $project){
                if ($project['id'] == $_POST[$field]){
                    $select_project_exist = true;
                    break;
                }
            }
            if (!$select_project_exist) $errors_form_task[$field] = 'Такого проекта не существует';
            $data_fields_from_task[$field] = $_POST[$field];
            $data_fields_from_task['create_date'] = date('Y-m-d H:i:s');
        }
        if ($field == 'date') {
            if (!(validateDate($_POST[$field]))) $errors_form_task[$field] = "Введите дату в формате: ГГГГ-ММ-ДД ЧЧ:ММ:СС";
            $data_fields_from_task[$field] = $_POST[$field];
        }
    }

    // Валидация файла
    if (isset($_FILES['preview']) and ($_FILES['preview']['name'] !== '')) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);

        $file_name = $_FILES['preview']['name'];
        $file_path = __DIR__.'\\';

        $file_size = $_FILES['preview']['size'];
        $file_type = finfo_file($finfo, $_FILES['preview']['tmp_name']);

        if (($file_type !== 'text/plain') or ($file_size > 200000)) {
            $errors_form_task['preview'] = 'Загрузите текстовый файл размером не более 200 Кб';
        }
        else {
            $data_fields_from_task['file'] = $file_path . $file_name;
        }
    }



     if (count($errors_form_task) == 0){
        // Если файл прошел валидацию, то добавляем его в корень директории
        if (isset($data_fields_from_task['file'])) {
            move_uploaded_file($_FILES['preview']['tmp_name'], $file_path.$file_name);
        }
        // Иначе, вместо пути к файлу записываем пустую строку.
        else {
            $data_fields_from_task['file'] = $_FILES['preview']['name'];
        }
        // Вызываю функцию добавления задачи в БД (линк, массив с полями)

         If (addTaskByUserId($link, $user_id, $data_fields_from_task)){
            echo "Задача добавлена";
         }


     }
}

//SQL-запрос для получения списка задач для выбранного проекта
$array_tasks = getTasks($link, $user_id, $show_complete_tasks, $current_project_id);

$modal_task = include_template('templates/modal-form-task.php',[
    'errors_form_task' => $errors_form_task,
    'project_array' => $project_array
]);

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
    'current_project_id' => $current_project_id,
    'modal_task' => $modal_task,
    'errors_form_task' => $errors_form_task
]);
print($layout_content);
?>

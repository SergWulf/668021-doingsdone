<?php
require_once('init.php');

if (($_SERVER['REQUEST_METHOD'] == 'POST') and (count($_POST) == 0)){
    $errors_form_task['preview'] = "Размер файла превышает ограничения на сервере";
}

if (isset($_SESSION['username'])) {
    $data_user = $_SESSION['username'];
    $user_id = $data_user['id'];
    // Получаем имя текущего пользователя по id
    $row_user = getUserById($link, $user_id);
    $name_user = $row_user['name_user'];

    // SQL-запрос для получения списка проектов у текущего пользователя
    $project_array = getProjectsByUserId($link, $user_id);
    $count_projects_array = [];

    //Подсчет количества задач для каждого проекта
    foreach ($project_array as $project) {
        $count_projects_array[$project['id']] = 0;
    }
    foreach (count_projects($link, $user_id) as $project_id => $count_project) {
        $count_projects_array[$project_id] = $count_project;
    }


    if ((isset($_SESSION['filter'])) and (!isset($_GET['filter']))) {
        $filter_task = $_SESSION['filter'];
    }
    if (isset($_GET['filter'])){
        if (isset($_SESSION['current_project_id'])){
            unset($_SESSION['current_project_id']);
            $current_project_id = PROJECT_ALL;
        }

        $filter_exists = false;
        foreach ($filter_tasks as $filter) {
            if ($_GET['filter'] == $filter){
                $filter_task = $filter;
                $_SESSION['filter'] = $filter;
                $filter_exists = true;
                break;
            }
        }

        if (!$filter_exists) {
            http_response_code(404);
            echo include_template('templates/error404.php', ['message' => 'Ошибка 404, такой страницы не существует']);
            exit;
        }

    }


    if((isset($_SESSION['current_project_id'])) and (!isset($_GET['id']))){
        $current_project_id = $_SESSION['current_project_id'];
    }

    // Проверка переменной id
    if (isset($_GET['id'])) {

        if (isset($_SESSION['filter'])){
            unset($_SESSION['filter']);
            $filter_task = 0;
        }

        $project_exists = false;
        foreach ($project_array as $project) {
            if ($_GET['id'] == $project['id']) {
                $current_project_id = $project['id'];
                $_SESSION['current_project_id'] = $current_project_id;
                $project_exists = true;
                break;
            }
        }

        if ($current_project_id == PROJECT_ALL){
            $_SESSION['current_project_id'] = PROJECT_ALL;
        }

        if ((!$project_exists) and ($current_project_id != PROJECT_ALL)) {
            http_response_code(404);
            echo include_template('templates/error404.php', ['message' => 'Ошибка 404, такой страницы не существует']);
            exit;
        }
    }

    // Проверка запроса на изменение статуса задачи
    if ((isset($_GET['task_id'])) and (isset($_GET['check']))){
        if (setTaskStatus($link, $_GET['task_id'], $_GET['check']))
        {
            unset($_GET['task_id']);
            unset($_GET['check']);
            header('Location: /');
        }
    }

    // Проверка запроса на показ выполненных задач
    if (isset($_GET['show_completed'])){
        $show_complete_tasks = $_GET['show_completed'];
    }


    //SQL-запрос для получения списка задач для выбранного проекта
    $array_tasks = getTasks($link, $user_id, $show_complete_tasks, $current_project_id, $filter_task);

    // Валидация поля формы добавления проектов
    if (($_SERVER['REQUEST_METHOD'] == 'POST') and (isset($_POST['form_project']))) {

        if (empty($_POST['name'])){
            $errors_form_project['name'] = 'Поле не заполнено';
        }

        $data_fields_form_project['name'] = strip_tags($_POST['name']);

        if (count($errors_form_project) == 0){
            if (addProjectByUserId($link, $user_id, $data_fields_form_project)) {
                header('Location: /');
            }
        }
    }

    // Валидация полей формы добавления задачи
    if (($_SERVER['REQUEST_METHOD'] == 'POST') and (isset($_POST['form_task']))) {

        // Валидация полей формы: имя, проект, дата
        foreach ($_POST as $field => $value) {
            if ($field == 'name') {
                if (empty($_POST[$field])) {
                    $errors_form_task[$field] = 'Поле на заполнено!';
                }
                $data_fields_form_task[$field] = strip_tags($_POST[$field]);
            }
            if ($field == 'project') {
                $select_project_exist = false;
                foreach ($project_array as $project) {
                    if ($project['id'] == $_POST[$field]) {
                        $select_project_exist = true;
                        break;
                    }
                }

                if (!$select_project_exist){
                    $errors_form_task[$field] = 'Такого проекта не существует';
                }
                $data_fields_form_task[$field] = strip_tags($_POST[$field]);
                $data_fields_form_task['create_date'] = date('Y-m-d H:i:s');
            }

            if (!isset($_POST['project'])) {
                $errors_form_task['project'] = 'Ни создано ни одного проекта, создайте хотя бы один';
            }

            if ($field == 'date') {
                if ((!(validateDate($_POST[$field]))) and ($_POST[$field] != '')) {
                    $errors_form_task[$field] = "Если вводите дату, то формате: ГГГГ-ММ-ДД ЧЧ:ММ, иначе оставьте поле пустым";
                }
                if ($_POST[$field] == '') {
                    $data_fields_form_task[$field] = $_POST[$field];
                }
                else {
                    $data_fields_form_task[$field] = $_POST[$field];
                }
            }
        }

        // Валидация файла
        if (isset($_FILES['preview']) and ($_FILES['preview']['name'] !== '')) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);

            $file_name = $_FILES['preview']['name'];
            $file_path = $_SERVER['DOCUMENT_ROOT'] . '/';

            $file_size = $_FILES['preview']['size'];
            $file_type = finfo_file($finfo, $_FILES['preview']['tmp_name']);

            if ($file_size > 1000000)  { // and ($file_size != 0))
                $errors_form_task['preview'] = 'Загрузите любой файл размером не более 1 Мб';
            } else {
                $data_fields_form_task['file'] = $file_path . $file_name;
            }
        }


        if (count($errors_form_task) == 0) {
            // Если файл прошел валидацию, то добавляем его в корень директории
            if (isset($data_fields_form_task['file'])) {
                move_uploaded_file($_FILES['preview']['tmp_name'], $file_path . $file_name);
            } // Иначе, вместо пути к файлу записываем пустую строку.
            else {
                $data_fields_form_task['file'] = '';
            }
            // Вызываю функцию добавления задачи в БД (линк, массив с полями)

            If (addTaskByUserId($link, $user_id, $data_fields_form_task)) {
                header('Location: /index.php?id=-1');
            }


        }
    }

    $page_guest = include_template('templates/guest.php',[]);

    $modal_auth = include_template('templates/auth_form.php',[
        'errors_form_auth' => $errors_form_auth,
        'data_user_form_auth' => $data_user_form_auth,
        'call_form_auth' => $call_form_auth
    ]);

    $modal_project = include_template('templates/modal-form-project.php',[
        "errors_form_project" => $errors_form_project,
        "data_fields_form_project" => $data_fields_form_project
    ]);

    $modal_task = include_template('templates/modal-form-task.php',[
        'errors_form_task' => $errors_form_task,
        'project_array' => $project_array,
        'data_fields_form_task' => $data_fields_form_task
    ]);

    $page_content = include_template('templates/index.php', [
        'array_tasks' => $array_tasks,
        'show_complete_tasks' => $show_complete_tasks,
        'filter_tasks' => $filter_tasks,
        'filter_task' => $filter_task,
        'current_project_id' => $current_project_id
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
        'errors_form_task' => $errors_form_task,
        'guest' => $page_guest,
        'data_user_form_auth' => $data_user_form_auth,
        'modal_auth' => $modal_auth,
        'errors_form_auth' => $errors_form_auth,
        'data_user' => $data_user,
        'errors_form_project' => $errors_form_project,
        'modal_project' => $modal_project,
    ]);
    print($layout_content);

}
else {



    // Валидация полей формы авторизации пользователя
    if (($_SERVER['REQUEST_METHOD'] == 'POST') and (isset($_POST['form_auth']))) {

        $_POST['email'] = strip_tags($_POST['email']);

        $data_user_form_auth = checkEmailUser($link, $_POST['email']);

        if (count($data_user_form_auth)) {

            $data_user_form_auth['email'] = $_POST['email'];
            if (!password_verify($_POST['password'], $data_user_form_auth['password_user'])){
                $errors_form_auth['password'] = 'Ваш пароль не совпадает, попробуйте еще раз';
            }

        }
        else {
            $errors_form_auth['email'] = 'Такого email в базе данных не существует';

        }

        if (count($errors_form_auth) == 0) {
            $_SESSION['username'] = $data_user_form_auth;
            header('Location: /');
        }
    }

    // Выводим гостевую страницу

    $page_guest = include_template('templates/guest.php',[]);

    $modal_auth = include_template('templates/auth_form.php',[
        'errors_form_auth' => $errors_form_auth,
        'data_user_form_auth' => $data_user_form_auth,
        'call_form_auth' => $call_form_auth
    ]);

    $modal_project = include_template('templates/modal-form-project.php',[
        "errors_form_project" => $errors_form_project,
        "data_fields_form_project" => $data_fields_form_project
    ]);

    $modal_task = include_template('templates/modal-form-task.php',[
        'errors_form_task' => $errors_form_task,
        'project_array' => $project_array,
        'data_fields_form_task' => $data_fields_form_task
    ]);

    $page_content = include_template('templates/index.php', [
        'array_tasks' => $array_tasks,
        'show_complete_tasks' => $show_complete_tasks,
        'filter_tasks' => $filter_tasks,
        'filter_task' => $filter_task,
        'current_project_id' => $current_project_id
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
        'errors_form_task' => $errors_form_task,
        'guest' => $page_guest,
        'data_user_form_auth' => $data_user_form_auth,
        'modal_auth' => $modal_auth,
        'errors_form_auth' => $errors_form_auth,
        'data_user' => $data_user,
        'errors_form_project' => $errors_form_project,
        'modal_project' => $modal_project
    ]);

    print($layout_content);

}

?>

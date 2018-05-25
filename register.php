<?php
require_once('init.php');

// Проверяем, что форма отправлена, проводим валидацию данных.
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{

    // Валидация полей формы: имя, проект, дата
    foreach ($_POST as $field => $value) {
        if ($field == 'email'){
            if (!filter_var($value, FILTER_VALIDATE_EMAIL)) $errors_form_register[$field] = 'Введите email корректно';
            $data_fields_form_register[$field] = strip_tags($_POST[$field]);

        }
        if ($field == 'password'){
            if ((empty($_POST[$field])) and (strlen($_POST[$field]) < 8)) $errors_form_register[$field] = 'Пароль должен быть не пустым и содержать не менее 8 символов';
            $data_fields_form_register[$field] = password_hash($_POST[$field], PASSWORD_DEFAULT);
        }
        if ($field == 'name') {
            if (empty($_POST[$field])) $errors_form_register[$field] = 'Поле на заполнено!';
            $data_fields_form_register[$field] = strip_tags($_POST[$field]);
        }
    }

    if (checkEmailUser($link, $data_fields_form_register['email'])) $errors_form_register['email'] = 'Такой email уже существует у другого пользователя';

    // Если ошибок нету и email уникальный в БД, то добавляем нового пользователя в БД
    if (count($errors_form_register) == 0) {

        $data_fields_form_register['date'] = date('Y-m-d H:i:s');

        // Функция добавления нового пользователя в БД (линк, массив с данными)
        If (addUser($link, $data_fields_form_register)){
            header('Location: /');
        }
    }
}



$register_form = include_template('templates/register.php',[
    'errors_form_register' => $errors_form_register,
    'data_fields_form_register' => $data_fields_form_register,
]);

print($register_form);
?>
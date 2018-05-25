<?php
/**
 * В этом файле хранятся необходимые данные для пользователя
 */
$name_user = '';
$project_array = array();
$array_tasks = array();
define('PROJECT_ALL', -1);
$user_id = 0;
$show_complete_tasks = 1;
$current_project_id = PROJECT_ALL;
$errors_form_task = [];
$data_fields_form_task = [];
$errors_form_register = [];
$data_fields_form_register = [];
$errors_form_auth = [];
$data_user_form_auth = [];
$data_user = [];
$count_projects_array = 0;
$errors_form_project = [];
$data_fields_form_project = [];
$filter_task = 0;
$filter_tasks = [
    'today' => 1,
    'tomorrow' => 2,
    'overdue' => 3
];
$call_form_auth = 0;
?>
<?php

// Функция подсчета количества проектов
function count_project($list_tasks, $name_task)
{
    $current_count_project = 0;
    if ($name_task == 'Все') {
        return count($list_tasks);
    }

    foreach ($list_tasks as $description_task => $attributes_of_task) {
        if ($name_task == $attributes_of_task['category']) {
            $current_count_project++;
        }
    }
    return $current_count_project;
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

?>
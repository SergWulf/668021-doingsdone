<?php
require_once('data.php');
require_once('functions.php');
$page_content=include_template('templates/index.php',['array_tasks' => $array_tasks]);
$layout_content=include_template('templates/layout.php', [
    'title' => 'Дела в порядке',
    'name_user' => 'Вячеслав',
    'content' => $page_content,
    'project_array' => $project_array,
    'array_tasks' => $array_tasks
]);
print($layout_content);
?>

<?php
// Добавляю простой массив
$project_array=array("Все","Входящие","Учеба","Работа","Домашние дела","Авто");

// Добавляю двумерных ассоциативный массив
$array_tasks = [
    'task1' => [
        'task' => 'Собеседование в IT компании',
        'date' => '01.06.2018',
        'category' => 'Работа',
        'complete' => 'Нет'
    ],
    'task2' => [
        'task' => 'Выполнить тестовое задание',
        'date' => '25.05.2018',
        'category' => 'Работа',
        'complete' => 'Нет'
    ],
    'task3' => [
        'task' => 'Сделать задание первого раздела',
        'date' => '21.04.2018',
        'category' => 'Работа',
        'complete' => 'Нет'
    ],
    'task4' => [
        'task' => 'Встреча с другом',
        'date' => '22.04.2018',
        'category' => 'Учеба',
        'complete' => 'Да'
    ],
    'task5' => [
        'task' => 'Купить корм для кота',
        'date' => 'нет',
        'category' => 'Входящие',
        'complete' => 'Нет'
    ],
    'task6' => [
        'task' => 'Заказать пиццу',
        'date' => 'нет',
        'category' => 'Домашние дела',
        'complete' => 'Нет'
    ]
];

// Добавляем функцию подсчета количества проектов
function count_project($list_tasks, $name_task)
{
    $current_count_project=0;
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
?>

<?php
require_once('functions.php');
$page_content=include_template('templates/index.php',['array_tasks' => $array_tasks]);
$layout_content=include_template('templates/layout.php', [
    'title' => 'Дела в порядке',
    'content' => $page_content,
    'project_array' => $project_array,
    'array_tasks' => $array_tasks
]);
print($layout_content);


?>

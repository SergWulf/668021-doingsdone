<h2 class="content__main-heading">Список задач</h2>

<form class="search-form" action="index.html" method="post">
    <input class="search-form__input" type="text" name="" value="" placeholder="Поиск по задачам">

    <input class="search-form__submit" type="submit" name="" value="Искать">
</form>

<div class="tasks-controls">
    <nav class="tasks-switch">
        <a href="/" class="tasks-switch__item tasks-switch__item--active">Все задачи</a>
        <a href="/" class="tasks-switch__item">Повестка дня</a>
        <a href="/" class="tasks-switch__item">Завтра</a>
        <a href="/" class="tasks-switch__item">Просроченные</a>
    </nav>

    <label class="checkbox">
        <!--добавить сюда аттрибут "checked", если переменная $show_complete_tasks равна единице-->
        <input class="checkbox__input visually-hidden show_completed" type="checkbox" <?php if ($show_complete_tasks == 1): echo "checked"; endif;?>>
        <span class="checkbox__text">Показывать выполненные</span>
    </label>
</div>

<table class="tasks">
    <?php foreach ($array_tasks as $index => $attributes_of_task): ?>
        <tr class="tasks__item task  <?php if ($array_tasks[$index]['status'] == 1): echo('task--completed '); endif; echo task_important($array_tasks[$index]) ? 'task--important' : ''; ?>">
            <td class="task__select">
                <label class="checkbox task__checkbox">
                    <input class="checkbox__input visually-hidden task__checkbox" type="checkbox">
                    <span class="checkbox__text"><?=strip_tags(($array_tasks[$index]['name_task'])); ?></span>
                </label>
            </td>
            <td class="task__file"></td>
            <td class="task__date"><?=strip_tags(($array_tasks[$index]['limit_date_task'])); ?></td>
        </tr>
    <?php endforeach; ?>
</table>
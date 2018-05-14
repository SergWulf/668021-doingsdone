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
        <input class="checkbox__input visually-hidden show_completed" type="checkbox">
        <span class="checkbox__text">Показывать выполненные</span>
    </label>
</div>

<table class="tasks">
    <?php foreach ($array_tasks as $index => $attributes_of_task): ?>
        <tr class="tasks__item task  <?php if ($array_tasks[$index]['complete'] == "Да"): echo("task--completed"); endif;?>">
            <td class="task__select">
                <label class="checkbox task__checkbox">
                    <input class="checkbox__input visually-hidden task__checkbox" type="checkbox">
                    <span class="checkbox__text"><?=strip_tags(($array_tasks[$index]['task'])); ?></span>
                </label>
            </td>
            <td class="task__file"></td>
            <td class="task__date"><?=strip_tags(($array_tasks[$index]['date'])); ?></td>
        </tr>
    <?php endforeach; ?>
</table>
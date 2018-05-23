<div class="modal" <?=(count($errors_form_task)?'':'hidden');?> id="task_add">
    <button class="modal__close" type="button" name="button" href="/">Закрыть</button>

    <h2 class="modal__heading">Добавление задачи</h2>

    <form class="form"  action="index.php" method="post" enctype="multipart/form-data">
        <div class="form__row">
            <label class="form__label" for="name">Название <sup>*</sup></label>

            <input class="form__input <?php if (isset($errors_form_task['name'])): echo 'form__input--error'; endif;?>"" type="text" name="name" id="name" value="" placeholder="Введите название">
            <?php if (isset($errors_form_task['name'])):  echo '<p class="form__message">'.$errors_form_task['name'].'</p>'; endif; ?>
        </div>

        <div class="form__row">
            <label class="form__label" for="project">Проект <sup>*</sup></label>

            <select class="form__input form__input--select <?php if (isset($errors_form_task['project'])): echo 'form__input--error'; endif;?>" name="project" id="project">
                <?php foreach($project_array as $project):?>
                <option value="<?=$project['id'];?>"><?=$project['name_project'];?></option>
                <?php endforeach;?>
            </select>
            <?php if (isset($errors_form_task['project'])):  echo '<p class="form__message">'.$errors_form_task['project'].'</p>'; endif; ?>
        </div>

        <div class="form__row">
            <label class="form__label" for="date">Срок выполнения</label>

            <input class="form__input form__input--date <?php if (isset($errors_form_task['date'])): echo 'form__input--error'; endif;?>" type="text" name="date" id="date"
                   placeholder="Введите дату и время">
            <?php if (isset($errors_form_task['date'])):  echo '<p class="form__message">'.$errors_form_task['date'].'</p>'; endif; ?>
        </div>

        <div class="form__row">
            <label class="form__label" for="preview">Файл</label>

            <div class="form__input-file <?php if (isset($errors_form_task['preview'])): echo 'form__input--error'; endif;?>">
                <input class="visually-hidden" type="file" name="preview" id="preview" value="">

                <label class="button button--transparent" for="preview">
                    <span>Выберите файл</span>
                </label>
            </div>
            <?php if (isset($errors_form_task['preview'])):  echo '<p class="form__message">'.$errors_form_task['preview'].'</p>'; endif; ?>
        </div>

        <div class="form__row form__row--controls">
            <input class="button" type="submit" name="" value="Добавить">
        </div>
    </form>
</div>
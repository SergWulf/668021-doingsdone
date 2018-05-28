<div class="modal" <?=(count($errors_form_project)?'':'hidden');?> id="project_add">
    <button class="modal__close" type="button" name="button">Закрыть</button>

    <h2 class="modal__heading">Добавление проекта</h2>

    <form class="form"  action="index.php" method="post">
        <div class="form__row">
            <label class="form__label" for="project_name">Название <sup>*</sup></label>

            <input class="form__input <?php if (isset($errors_form_project['name'])): echo 'form__input--error'; endif;?>" type="text" name="name" id="project_name" value="" placeholder="Введите название проекта">
            <p class="form__message"><?php if (isset($errors_form_project['name'])):  echo $errors_form_project['name']; endif; ?></p>
        </div>

        <div class="form__row form__row--controls">
            <input class="button" type="submit" name="form_project" value="Добавить">
        </div>
    </form>
</div>
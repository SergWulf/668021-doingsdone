<div class="modal" <?php if ((count($errors_form_auth)) or ($call_form_auth == 1)): echo ''; else: echo 'hidden'; endif;?>  id="user_login">
    <button class="modal__close" type="button" name="button">Закрыть</button>

    <h2 class="modal__heading">Вход на сайт</h2>

    <form class="form" action="index.php" method="post">
        <div class="form__row">
            <label class="form__label" for="email">E-mail <sup>*</sup></label>
            <input class="form__input <?php if (isset($errors_form_auth['email'])): echo 'form__input--error'; endif;?>" type="text" name="email" id="email" value="<?php if (isset($data_user_form_auth['email'])): echo $data_user_form_auth['email']; endif;?>" placeholder="Введите e-mail">
            <p class="form__message"><?php if (isset($errors_form_auth['email'])):  echo $errors_form_auth['email']; endif; ?></p>
        </div>

        <div class="form__row">
            <label class="form__label" for="password">Пароль <sup>*</sup></label>
            <input class="form__input <?php if (isset($errors_form_auth['password'])): echo 'form__input--error'; endif;?>" type="password" name="password" id="password" value="" placeholder="Введите пароль">
            <p class="form__message"><?php if (isset($errors_form_auth['password'])):  echo $errors_form_auth['password']; endif; ?></p>
        </div>

        <div class="form__row form__row--controls">
            <input class="button" type="submit" name="form_auth" value="Войти">
        </div>
    </form>
</div>
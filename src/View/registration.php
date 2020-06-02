<?php
use Metrotel\View;
?>

<div class="row justify-content-md-center">
    <div class="col-md-auto">
        <form id="registration-form" method="POST" action="<?php echo View::base_url('login/registration');?>">

            <h5>Регистрация</h5>

            <div class="form-group">
                <input type="text" class="form-control" value="<?php if (!empty($form['name'])) echo $form['name'];?>" maxlength="50" name="name" placeholder="Имя">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" value="<?php if (!empty($form['name'])) echo $form['lastname'];?>" maxlength="50" name="lastname" placeholder="Фамилия">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" value="<?php if (!empty($form['name'])) echo $form['login'];?>" maxlength="50" name="login" placeholder="Логин">
            </div>
            <div class="form-group">
                <input type="email" class="form-control" value="<?php if (!empty($form['name'])) echo $form['email'];?>"maxlength="50" name="email" placeholder="Email">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" value="" maxlength="50" name="password" placeholder="Пароль">
            </div>
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary btn-action" data-method="login">Регистрация</button>
            </div>
        </form>
    </div>
</div>
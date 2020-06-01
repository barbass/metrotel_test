<?php
use Metrotel\View;
?>

<div class="row justify-content-md-center">
    <div class="col-md-auto">
        <form id="auth-form" method="POST" action="<?php echo View::base_url('login/index');?>">

            <h5>Авторизация</h5>

            <div class="form-group">
                <input type="text" class="form-control username" name="username" placeholder="Логин">
            </div>
            <div class="form-group">
                <input type="password" class="form-control password" name="password" placeholder="Пароль">
            </div>
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary btn-action" data-method="login">Вход</button>
            </div>
        </form>
    </div>
</div>
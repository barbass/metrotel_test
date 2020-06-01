<?php
use Metrotel\View;
?>

<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <script type="text/javascript" src="<?php echo View::base_url('public/js/jquery-3.5.1.min.js');?>"></script>

        <script type="text/javascript" src="<?php echo View::base_url('public/js/bootstrap-4.5.0-dist/js/bootstrap.bundle.min.js');?>"></script>
        <link rel="stylesheet" href="<?php echo View::base_url('public/js/bootstrap-4.5.0-dist/css/bootstrap.min.css');?>">

        <title>Телефонная книга</title>
    </head>

    <body>
        <div class="header pageHeader">
            <div role="navigation" class="navbar navbar-expand-lg navbar-dark bg-dark flex-wrap">
                <div class="container-fluid">
                    <div class="navbar-collapse collapse">
                        <ul class="nav navbar-nav">
                            <li><a href="javascript:void(0);" class="navbar-brand">Телефонная книга</a></li>
                        </ul>
                        <div class="ml-auto justify-content-end">
                            <span class="text-white d-none fullname"></span>
                            &nbsp;&nbsp;&nbsp;
                            <button class="btn btn-light d-none btn-action exit" data-method="exit">Выйти</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id='popup'>
            <div id='ajaxLoading' class='d-none'>
                <div id="nprogress">
                    <div class="bar" role="bar">
                        <div class="peg"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">

            <div class="row justify-content-md-center pageLogin">
                <div class="col-md-auto">
                    <form id="auth-form">

                        <h5>Авторизация</h5>

                        <div class="form-group">
                            <input type="text" class="form-control username" name="username" placeholder="Логин">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control password" name="password" placeholder="Пароль">
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="button" class="btn btn-primary btn-action" data-method="login">Авторизация</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row d-none pageMain">
                <div class="col-12 col-md-2 py-3 menu">
                    <ul>
                        <li>
                            Телефонная книга
                        </li>
                        <li>
                            Регистрация
                        </li>
                    </ul>

                    <a class="to_header" href="javascript:void(0);">
                        <div id="to_header">
                            <i class="fa fa-arrow-up" aria-hidden="true"></i>
                        </div>
                    </a>
                </div>


                <div class="col-12 col-md-10 py-3">
                    <div class="d-none justify-content-center pageResponse"></div>
                    <div class="content"></div>
                </div>
            </div>
        </div>
    </body>

    <script type="text/javascript">

    </script>

</html>

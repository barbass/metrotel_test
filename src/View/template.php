<?php
use Metrotel\View;
use Guard\Authorization;
?>

<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <script type="text/javascript" src="<?php echo View::base_url('js/jquery-3.5.1.min.js');?>"></script>
        <script type="text/javascript" src="<?php echo View::base_url('js/fontawesome.all.min.js');?>"></script>
        <script type="text/javascript" src="<?php echo View::base_url('js/bootstrap-4.5.0-dist/js/bootstrap.bundle.min.js');?>"></script>
        <link rel="stylesheet" href="<?php echo View::base_url('js/bootstrap-4.5.0-dist/css/bootstrap.min.css');?>">

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
                            <?php if (Authorization::isAuth()) { ?>
                                <span class="text-white fullname"><?php echo Authorization::getFullname();?></span>
                                &nbsp;&nbsp;&nbsp;
                                <a class="btn btn-outline-secondary" href="<?php echo View::base_url('login/logout');?>">Выйти</a>
                            <?php } else { ?>
                                <a class="btn btn-outline-primary" href="<?php echo View::base_url('login/index');?>">Войти</a>
                                <a class="btn btn-outline-primary" href="<?php echo View::base_url('login/registration');?>">Регистрация</a>
                            <?php } ?>
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

        <div class="container-fluid mt-5">
            <?php if (!empty($error)) { ?>
                <div class="alert alert-dismissable alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <?php echo $error;?>
                </div>
            <?php } ?>
            <?php if (!empty($success)) { ?>
                <div class="alert alert-dismissable alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <?php echo $success;?>
                </div>
            <?php } ?>

            <?php echo (!empty($content)) ? $content : '';?>
        </div>
    </body>

    <script type="text/javascript">

    </script>

</html>

<!DOCTYPE html>
<html class="no-js">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title> <?= $title ?> </title>

        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
	
        <link rel="stylesheet" href="/debate/assets/css/normalize.min.css">
        <link rel="stylesheet" href="/debate/assets/css/main.css">
        <script src="/debate/assets/js/vendor/prefixfree.min.js"></script>

        <script src="/debate/assets/js/vendor/modernizr-2.6.2.min.js"></script>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <header>
            <div class="wrapper clear">

                <div id="user">
                    <?php
			         if($user) { ?>
                     <!-- prueba2 -->
                        <span>Hola, <?= $user->cn; ?> </span>
                        <?php if ($user->rol < 100){ ?>
                        <a class="logout" href="/debate/inicio/logout">Salir</a>
                        <!-- Si el usuario es administrador, además le aparece el boton de admin -->
                       <?php } if ($user->rol >= 100){ ?>
                        <a class="logout" href="/debate/admin/">Admin</a>
                    <?php   }
                    } else { ?>
                        <a href="/debate/inicio/login">Entrar</a>
                    <?php } ?>
                </div>
                <a href="/debate/inicio"> <h1>Debate a Rector</h1> </a>
                <a href="http://delegacion.uc3m.es" target="_blank"> <img src="/debate/assets/img/delegacion.png"> </a>

            </div>
        </header>

        <div class="main <?php echo isset($section) ? $section : '' ?> ">

<?php defined('TIKETAI_FLOW') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <meta name="description" content="<?php echo $business->description_text.' - '.$business->description_subtext ?>">

        <link rel="shortcut icon" href="/favicon.ico"/>

        <title><?php echo $title ?></title>

        <?php if ( isset( $ogg ) ): ?>
            <?php echo $ogg; ?>
        <?php else: ?>
            <meta property="og:title" content="<?php echo $title ?>" />
            <meta property="og:url" content="<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>"/>
            <meta property="og:description" content="<?php echo $business->description_text.' - '.$business->description_subtext ?>"/>
            <meta property="og:image" content="<?php echo $business->header_image ?>"/>
        <?php endif; ?>

        <?php echo $business->tiketai_theme->before_head_close ?>

        <style>
          ::selection { background: <?php echo ( isset($event) && ! empty($event->main_color) )? $event->main_color : $business->main_color ?>; color: #fff }
          ::-moz-selection { background: <?php echo ( isset($event) && ! empty($event->main_color) )? $event->main_color : $business->main_color ?>; color: #fff }

          body .c1, body .hover-c1:hover, body .hover-c1:focus {color:<?php echo ( isset($event) && ! empty($event->main_color) && ! empty( $event->main_color ) )? $event->main_color : $business->main_color ?>;}
          body .bgc1, body .hover-bgc1:hover, body .hover-bgc1:focus {background-color: <?php echo ( isset($event) && ! empty($event->main_color) )? $event->main_color : $business->main_color ?>}
          body .borderc1, body .hover-borderc1:hover, body .hover-borderc1:focus { border-color: <?php echo ( isset($event) && ! empty($event->main_color) )? $event->main_color : $business->main_color ?>}

          body.dark .c1, body.dark .hover-c1:hover, body.dark .hover-c1:focus {color:<?php echo ( isset($event) && ! empty($event->main_color) )? $event->main_color : $business->main_color ?>;}
          body.dark .bgc1, body.dark .hover-bgc1:hover, body.dark .hover-bgc1:focus {background-color: <?php echo ( isset($event) && ! empty($event->main_color) )? $event->main_color : $business->main_color ?>}
          body.dark .borderc1, body.dark .hover-borderc1:hover, body.dark .hover-borderc1:focus { border-color: <?php echo ( isset($event) && ! empty($event->main_color) )? $event->main_color : $business->main_color ?>}

        </style>
    </head>
    <body <?php echo (isset( $body_classes )? 'class="'.$body_classes.'"':'') ?> <?php echo ( $business->tiketai_theme->id == 2 )? 'class="dark"' : '' ?>>

        <nav class="navbar navbar-expand-sm navbar-custom fixed-top anim">
            <div class="container">
                <a class="navbar-brand" href="/">
                    <img src="<?php echo $business->logo ?>" class="img-fluid" alt="logo"/>
                </a>
                <div class="collapse navbar-collapse text-right" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link c3 hover-c1 anim" href="/">Inicio</a>
                        </li>
                        <span class="c3">·</span>
                        <li class="nav-item">
                            <a class="nav-link c3 hover-c1 anim" href="#comprarTickets">Eventos</a>
                        </li>
                        <span class="c3">·</span>
                        <li class="nav-item">
                            <a class="nav-link c3 hover-c1 anim" href="/contact">Contacto</a>
                        </li>
                    </ul>
                    <?php if (! (isset( $menu_simple) && $menu_simple) ): ?>
                        <a class="comprar anim bgc1 c2 hover-c2" href="#comprarTickets">Comprar Tickets</a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>

        <?php if (isset($content)) echo $content; ?>

        <footer class="borderc1">
            <div class="container-fluid">
                <div class="row">

                    <div class="col-12 col-sm-3 d-flex align-items-end flex-column bd-highlight p-3 bgc1">
                        <p class="mt-auto m-0 c2">
                          <a class="c2" href="//tiket.ai">Powered by Tiket.ai</a>
                        </p>
                    </div>

                    <div class="col-12 col-sm-3 pt-5">
                        <div class="col-12 p-0">
                            <a href="/">
                                <img src="<?php echo $business->logo ?>" alt="<?php echo $business->name ?>" style="max-height:90px"/>
                            </a>
                        </div>
                        <div class="sep mt-3 mb-3"></div>
                        <div class="">
                            <?php if ( ! empty( $business->facebook )): ?>
                                <a href="<?php echo $business->facebook ?>"><i class="c2 bgc1 hover-c2 m-1 anim fab fa-facebook"></i></a>
                            <?php endif; ?>
                            <?php if ( ! empty( $business->instagram )): ?>
                                <a href="<?php echo $business->instagram ?>"><i class="c2 bgc1 hover-c2 m-1 anim fab fa-instagram"></i></a>
                            <?php endif; ?>
                            <?php if ( ! empty( $business->twitter )): ?>
                                <a href="<?php echo $business->twitter ?>"><i class="c2 bgc1 hover-c2 m-1 anim fab fa-twitter"></i></a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 d-flex align-items-end text-right flex-column bd-highlight p-4">
                        <p class="mt-auto m-0">
                            <a class="c3 hover-c1 anim" href="/contact">Contacto</a><br>
                            <a class="c3 hover-c1 anim" href="/tos">Términos y condiciones</a>
                        </p>
                    </div>

                </div>
            </div>
        </footer>

        <?php echo $business->tiketai_theme->before_body_close ?>
        <?php if (isset($specifics_scripts)) echo $specifics_scripts; ?>
    </body>
</html>

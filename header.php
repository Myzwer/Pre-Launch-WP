<?php
/**
 * The header for this theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Pre-Launch WP
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <script src="https://kit.fontawesome.com/aa36ddf53c.js" crossorigin="anonymous"></script>

    <?php wp_head(); ?>
</head>

<body class="leading-normal tracking-normal"
      style="font-family: 'Source Sans Pro', sans-serif;" <?php body_class(); ?>>

<?php wp_body_open(); ?>


<section class="navigation">
    <div class="nav-container">
        <div class="brand">
            <a href="/frontpage">
                <img src="https://images.squarespace-cdn.com/content/v1/575a6067b654f9b902f452f4/1552683653140-0UUVQSSUEWVC73AWAEQG/300Logo.png"
                     alt="">
            </a>
        </div>
        <nav>
            <div class="nav-mobile">
                <a id="nav-toggle" href="#!"><span></span></a>
            </div>

            <!-- Start Wordpress-->
            <?php
            wp_nav_menu(array(
                'theme_location' => 'header-menu',
                'menu_class'     => 'primary-menu', // pass whatever classes to be added to top level here
                'walker' => new PreLaunch_Walker(),
//                'items_wrap' => '<nav role="navigation" class="%2$s">%3$s</nav>'
                 'items_wrap' => '<ul class="nav-list">%3$s</ul>'
            ));
            ?>
            <!-- End Wordress -->
        </nav>
    </div>
</section>








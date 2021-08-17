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


<nav>
    <div class="logo"><img
                src="https://images.squarespace-cdn.com/content/v1/575a6067b654f9b902f452f4/1552683653140-0UUVQSSUEWVC73AWAEQG/300Logo.png"
                alt=""></div>
    <label for="drop" class="toggle">
        <div class="borger-menu">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>
    </label>


    <?php
    wp_nav_menu(array(
    'theme_location' => 'header-menu',
    'menu_class' => 'primary-menu', // pass whatever classes to be added to top level here
    'walker' => new PreLaunch_Walker(),
    'items_wrap' => '<input type="checkbox" id="drop"/><ul class = \'menu %2$s\'>%3$s</ul>'

    ));
    ?>

</nav>





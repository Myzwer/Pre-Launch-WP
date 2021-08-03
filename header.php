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
        <div class = "borger-menu">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>
    </label>
    <input type="checkbox" id="drop"/>
    <ul class="menu">
        <li><a href="#">Home</a></li>
        <li>
            <!-- First Tier Drop Down -->
            <label for="drop-1" class="toggle">Service</label>
            <a href="#">Service</a>
            <input type="checkbox" id="drop-1"/>
            <ul>
                <li><a href="#">Service 1</a></li>
                <li><a href="#">Service 2</a></li>
                <li><a href="#">Service 3</a></li>
            </ul>
        </li>
        <li>

            <!-- First Tier Drop Down -->
            <label for="drop-2" class="toggle">Portfolio</label>
            <a href="#">Portfolio</a>
            <input type="checkbox" id="drop-2"/>
            <ul>
                <li><a href="#">Portfolio 1</a></li>
                <li><a href="#">Portfolio 2</a></li>
                <li>

                    <!-- Second Tier Drop Down -->
                    <label for="drop-3" class="toggle">Works</label>
                    <a href="#">Works</a>
                    <input type="checkbox" id="drop-3"/>
                    <ul>
                        <li><a href="#">HTML/CSS</a></li>
                        <li><a href="#">jQuery</a></li>
                        <li><a href="#">Python</a></li>
                    </ul>
                </li>
            </ul>
        </li>
        <li><a href="#">Blog</a></li>
        <li><a href="#">Submit</a></li>
        <li><a href="#">Contact</a></li>
        <li><a href="#">About</a></li>
    </ul>
</nav>

<?php
/* wp_nav_menu(array(
     'theme_location' => 'header-menu',
     'menu_class'     => 'primary-menu', // pass whatever classes to be added to top level here
     'walker' => new PreLaunch_Walker(),
     'items_wrap' => '<nav role="navigation" class="%2$s">%3$s</nav>'
 ));*/
?>



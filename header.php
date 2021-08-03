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
        <svg fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                  d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z"
                  clip-rule="evenodd"></path>
            <!--            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>-->
        </svg>
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
            <label for="drop-2" class="toggle">Portfolio +</label>
            <a href="#">Portfolio</a>
            <input type="checkbox" id="drop-2"/>
            <ul>
                <li><a href="#">Portfolio 1</a></li>
                <li><a href="#">Portfolio 2</a></li>
                <li>

                    <!-- Second Tier Drop Down -->
                    <label for="drop-3" class="toggle">Works +</label>
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



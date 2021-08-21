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
            <a href="#!">
                <img src="https://images.squarespace-cdn.com/content/v1/575a6067b654f9b902f452f4/1552683653140-0UUVQSSUEWVC73AWAEQG/300Logo.png" alt="">
            </a>
        </div>
        <nav>
            <div class="nav-mobile">
                <a id="nav-toggle" href="#!"><span></span></a>
            </div>

            <!-- tart Wordpress-->
            <ul class="nav-list">
                <li>
                    <a href="#!">Home</a>
                </li>
                <li>
                    <a href="#!">About</a>
                </li>
                <li>
                    <a href="#!">Services</a>
                    <ul class="nav-dropdown">
                        <li>
                            <a href="#!">Web Design</a>
                        </li>
                        <li>
                            <a href="#!">Web Development</a>
                        </li>
                        <li>
                            <a href="#!">Graphic Design</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="#!">Pricing</a>
                </li>

                <li>
                    <a href="#!">Portfolio</a>
                    <ul class="nav-dropdown">
                        <li>
                            <a href="#!">Web Design</a>
                        </li>
                        <li>
                            <a href="#!">Web Development</a>
                        </li>
                        <li>
                            <a href="#!">Graphic Design</a>
                        </li>
                        <li>
                            <a href="#!">Graphic Design</a>
                        </li>
                        <li>
                            <a href="#!">Graphic Design</a>
                        </li>
                        <li>
                            <a href="#!">Graphic Design</a>
                        </li>
                    </ul>
                </li>


                <li class = "button"><a href="#!">Book Now</a></li>
            <!-- End Wordress -->
            </ul>
        </nav>
    </div>
</section>






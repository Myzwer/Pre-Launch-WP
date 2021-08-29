<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Pre-Launch WP
 */

?>

<footer class="footer">

    <div class="footer-left">
        <img src="https://images.squarespace-cdn.com/content/v1/575a6067b654f9b902f452f4/1552683653140-0UUVQSSUEWVC73AWAEQG/300Logo.png">
        <div class="left-inner">
            <h3>Fancy Company</h3>
            <p class="phone-number">+1 234-567-8901</p>
        </div>
    </div>

    <div class="footer-right">
        <div class="right-inner">
            <?php wp_nav_menu( array( 'theme_location' => 'footer-column-1' ) ); ?>
            <?php wp_nav_menu( array( 'theme_location' => 'footer-column-2' ) ); ?>
        </div>

    </div>
    <div class="footer-bottom">
        <div class="bot-inner">
            <p>Some Text</p>
            <p>© <?php echo date("Y"); ?> Website Company Name</p>
            <div class="footer-icons">
            <a href="#"><i class="fa fa-facebook"></i></a>
            <a href="#"><i class="fa fa-twitter"></i></a>
            <a href="#"><i class="fa fa-instagram"></i></a>
            <a href="#"><i class="fa fa-linkedin"></i></a>
            <a href="#"><i class="fa fa-youtube"></i></a>
        </div>
    </div>
</footer>


<?php wp_footer(); ?>

</body>
</html>

<?php
/**
 * Shortcodes
 *
 * Defines custom shortcodes for various buttons and social icons.
 *
 * Usage: These shortcodes are linked in the main functions.php file and can be used in the content or widgets.
 *
 * @package WordPress
 * @subpackage Pre_Launch_WP
 * @author Josh Forrester <josh@onefortyfivedesign.com>
 * @version 1.0.0
 */


/**
 * Function to generate a shortcode for creating a button with specified class and icon HTML.
 *
 * This function returns another function that acts as a shortcode handler.
 * The returned function handles the button's text, URL, and whether it should open in a new tab.
 *
 * Shortcode attributes:
 * - text: The text to display on the button.
 * - url: The URL where the button should link to.
 * - tab: Controls how the link opens. Valid values are 'y' (opens in a new tab) or other (opens in same tab).
 *
 * @param string $class_name The class name to apply to the button.
 * @param string $icon_html The HTML for the button's icon. Default is an empty string.
 *
 * @return callable The function that will be used as the shortcode handler. This function returns a string containing the HTML for the generated button.
 */
function generate_button_shortcode($class_name, $icon_html = '')
{
    // Return a function that generates the shortcode output
    return function ($atts) use ($class_name, $icon_html) {
        // Get the button text and URL from the shortcode attributes
        $button_text = isset($atts['text']) ? $atts['text'] : null;
        $button_url = isset($atts['url']) ? $atts['url'] : null;

        // Determine if button details are complete or hidden
        $all_details = (!empty($button_text) && !empty($button_url)) ? '' : 'hidden';

        // Set how new tab behavior is handled based on the 'tab' attribute
        $open_in_tab = isset($atts['tab']) && strtolower($atts['tab']) === 'y' ? " target='_blank'" : '';

        // Return the HTML for the button
        return '<span class="not-prose"><a href="' . esc_url($button_url) . '"' . $open_in_tab . ' class="' . esc_attr($class_name) . ' mt-3 ' . esc_attr($all_details) . '">' . $icon_html . esc_html($button_text) . '</a></span>';
    };
}

// Define shortcodes with appropriate classes and icons
add_shortcode('btn_main', generate_button_shortcode('btn-main', '<i class="fa-sharp fa-solid fa-arrow-right"></i> '));
add_shortcode('btn_light', generate_button_shortcode('btn-light', '<i class="fa-sharp fa-solid fa-arrow-right"></i> '));
add_shortcode('btn_dark', generate_button_shortcode('btn-dark', '<i class="fa-sharp fa-solid fa-arrow-right"></i> '));
add_shortcode('btn_ghost_white', generate_button_shortcode('btn-ghost-white', '<i class="fa-sharp fa-solid fa-arrow-right"></i> '));
add_shortcode('btn_ghost_black', generate_button_shortcode('btn-ghost-black', '<i class="fa-sharp fa-solid fa-arrow-right"></i> '));



//******************** SOCIALS *********************
/*
 * FACEBOOK ICON
 * Defaults to the FC Facebook if no url is given
 * You can feed it any size between 1 and 10. Defaults to 2.
 * Usage:  [facebook url = "https://example.com" size = "1-10"]
*/
function facebook_shortcode($atts, $content = null)
{
    $button_size = isset($atts['size']) ? $atts['size'] : 2;
    $button_url = isset($atts['url']) ? $atts['url'] : 'https://www.facebook.com/foothillschurchTN';
    return '<a href="' . esc_url($button_url) . '"><i class="text-' . esc_html($button_size) . 'xl pr-1 fa-brands fa-facebook"></i></a>';
}

add_shortcode('facebook', 'facebook_shortcode');

/*
 * INSTAGRAM ICON
 * Defaults to the FC Instagram if no url is given
 * You can feed it any size between 1 and 10. Defaults to 2.
 * Usage:  [instagram url = "https://example.com" size = "1-10"]
*/
function instagram_shortcode($atts, $content = null)
{
    $button_size = isset($atts['size']) ? $atts['size'] : 2;
    $button_url = isset($atts['url']) ? $atts['url'] : 'https://www.instagram.com/foothillschurchtn/';
    return '<a href="' . esc_url($button_url) . '"><i class="text-' . esc_html($button_size) . 'xl pr-1 fa-brands fa-instagram"></i></a>';
}

add_shortcode('instagram', 'instagram_shortcode');

/*
 * X ICON
 * Defaults to the FC X account if no url is given
 * You can feed it any size between 1 and 10. Defaults to 2.
 * Usage:  [x url = "https://example.com" size = "1-10"]
*/
function x_shortcode($atts, $content = null)
{
    $button_size = isset($atts['size']) ? $atts['size'] : 2;
    $button_url = isset($atts['url']) ? $atts['url'] : 'https://twitter.com/foothillschurch';
    return '<a href="' . esc_url($button_url) . '"><i class="text-' . esc_html($button_size) . 'xl pr-1 fa-brands fa-x-twitter"></i></a>';
}

add_shortcode('x', 'x_shortcode');

/*
 * WEBSITE ICON
 * Defaults to the fc site if no url is given
 * You can feed it any size between 1 and 10. Defaults to 2.
 * Usage:  [website url = "https://example.com" size = "1-10"]
*/
function website_shortcode($atts, $content = null)
{
    $button_size = isset($atts['size']) ? $atts['size'] : 2;
    $button_url = isset($atts['url']) ? $atts['url'] : 'https://foothillschurch.com/';
    return '<a href="' . esc_url($button_url) . '"><i class="text-' . esc_html($button_size) . 'xl pr-1 fa-solid fa-link-simple"></i></a>';
}

add_shortcode('website', 'website_shortcode');

// Allows WP to inject shortcodes via a wysiwyg editor
add_filter('widget_text', 'do_shortcode');
add_filter('the_content', 'do_shortcode');

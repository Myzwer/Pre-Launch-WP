<?php
/**
 * The custom Navwalker for the theme.
 * This pairs with the header.php file to generate the right code to make the navwalker work.
 * You can read more about this in the Header section of the readme.
 *
 * The Walker class was implemented in WordPress 2.1 to provide developers with a means to traverse
 * tree-like data structures for the purpose of rendering HTML.
 *
 * @link https://developer.wordpress.org/reference/classes/walker/
 *
 * @package WordPress
 * @subpackage Pre_Launch_WP
 * @since 1.0.0
 */

class PreLaunch_Walker extends Walker_Nav_Menu
{
    /**
     * Append the opening html for a nav menu item, and the menu item itself.
     * @note Startel handles everything from <li><a href = "">TEXT
     *
     * @param string $output Used to append additional content (passed by reference).
     * @param WP_Post $item Menu item data object.
     * @param int $depth Depth of menu item. Used for padding.
     * @param stdClass $args An object of wp_nav_menu() arguments.
     * @param int $id Current item ID.
     */
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
        $title = $item->title;
        $permalink = $item->url;

        $output .= "<li>";
        $output .= "<a href='$permalink'>$title</a>";
    }


    /**
     * Append the closing html for a menu item.
     *
     * @param string $output Used to append additional content (passed by reference).
     * @param WP_Post $item Page data object. Not used.
     * @param int $depth Depth of page. Not Used.
     * @param stdClass $args An object of wp_nav_menu() arguments.
     */
    public function end_el(&$output, $item, $depth = 0, $args = null)
    {
        $output .= "</li>";
    }

    /**
     * Provide the opening markup for a new menu within our menu (AKA a submenu).
     *
     * @param string $output Used to append additional content (passed by reference).
     * @param int $depth Depth of menu item. Used for padding.
     * @param stdClass $args An object of wp_nav_menu() arguments.
     */
    public function start_lvl(&$output, $depth = 0, $args = null)
    {
        $output .= '<ul class="nav-dropdown">';
    }

    /**
     * This oddly named fellow does nothing other than end a submenu.
     *
     * @param string $output Used to append additional content (passed by reference).
     * @param int $depth Depth of menu item. Used for padding.
     * @param stdClass $args An object of wp_nav_menu() arguments.
     */
    public function end_lvl(&$output, $depth = 0, $args = null)
    {
        $output .= '</ul>';
    }
}







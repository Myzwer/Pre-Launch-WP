<?php

class PreLaunch_Walker extends Walker_Nav_Menu
{
    private $topLevelClasses = "a-class another-class";
    private $secondLevelClasses = "a-third-classssss";
    private $drops = "drop-1";

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
        if (in_array("menu-item-has-children", $item->classes)) {
            $output .= "<li><label for='drop-{$item->ID}'>$title</label>";
            $output .= "<a href='$permalink'>$title</a>";
            $output .= "<input type='checkbox' id='drop-{$item->ID}' />";
        } else {
            $output .= "<li><a href='$permalink'>$title";
        }
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
        // Grab the closing html that we defined in the shortcode cb.
//        $after = $args->after;
        // Passed by reference, thus no need to return a value.
//        $output .= $after;
        $output .= "</a></li>";
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
        $output .= '<ul>';
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
        /*// Grab the closing html that we defined in the shortcode cb.
        $after = $args->after_submenu;
        // Passed by reference, thus no need to return a value.
        $output .= $after;*/
    }
}







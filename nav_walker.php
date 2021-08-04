<?php

class PreLaunch_Walker extends Walker_Nav_Menu
{
    private $topLevelClasses = "a-class another-class";
    private $secondLevelClasses = "a-third-classssss";

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
        if ($depth === 0) {
            $classes = "cat";
        }
        else {
            $classes = "cat-2";
        }
        $output .= "<li><a href='$permalink'>$title</a></li>";


       /* $object = $item->object;
        $type = $item->type;
        $title = $item->title;
        $description = $item->description;
        $permalink = $item->url;

        if ($depth === 0) {
            $output .= "<li class='" . $this->topLevelClasses . "'>";
        } else {
            $output .= "<li class='" . $this->secondLevelClasses . "'>";
        }*/

        /*  Shorthand for above section - learn more later
        $classes = ($depth === 0) ? $this->topLevelClasses : $this->secondLevelClasses;
        $output .= "<li class='$classes'>>";
        */


        //Add SPAN if no Permalink
        /*if ($permalink && $permalink != '#') {
            $output .= '<a href="' . $permalink . '">';
        } else {
            $output .= '<span>';
        }
        $output .= $title;
        if ($description != '' && $depth == 0) {
            $output .= '<small class="description">' . $description . '</small>';
        }
        if ($permalink && $permalink != '#') {
            $output .= '</a>';
        } else {
            $output .= '</span>';
        }*/
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
        $after = $args->after;
        // Passed by reference, thus no need to return a value.
        $output .= $after;
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
        $output .= '<div>';
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
        $output .= '</div></div></div>';
        /*// Grab the closing html that we defined in the shortcode cb.
        $after = $args->after_submenu;
        // Passed by reference, thus no need to return a value.
        $output .= $after;*/
    }
}







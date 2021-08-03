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
            $classes = "px-4 py-2 mt-2 text-sm font-semibold text-gray-900 bg-gray-200 rounded-lg dark-mode:bg-gray-700 dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline";
        } else {
            $classes = "block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline";
        }
        $output .= "<a class='$classes' href='$permalink'>$title</a>";


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
        $output .= '<div @click.away="open = false" class="relative" x-data="{ open: false }">';
        $output .= '<button @click="open = !open" class="flex flex-row items-center w-full px-4 py-2 mt-2 text-sm font-semibold text-left bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:focus:bg-gray-600 dark-mode:hover:bg-gray-600 md:w-auto md:inline md:mt-0 md:ml-4 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline">';
        $output .= '<span>Dropdown</span>';
        $output .= '<svg fill="currentColor" viewBox="0 0 20 20" :class="{\'rotate-180\': open, \'rotate-0\': !open}" class="inline w-4 h-4 mt-1 ml-1 transition-transform duration-200 transform md:-mt-1"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>';
        $output .= '</button>';
        $output .= '<div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 w-full mt-2 origin-top-right rounded-md shadow-lg md:w-48">';
        $output .= '<div class="px-2 py-2 bg-white rounded-md shadow dark-mode:bg-gray-800">';
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







<?php

/**
 * Nav Walker
 *
 * Custom Walker_Nav_Menu implementation for this theme.
 *
 * Outputs:
 * - <li> elements with WordPress-generated and admin-defined classes
 * - <a> elements with standard menu item attributes (href, target, rel, title, aria-current)
 * - Optional wrappers provided via wp_nav_menu() args (before/after/link_before/link_after)
 *
 * Preserves standard WordPress filters for compatibility:
 * - nav_menu_css_class
 * - nav_menu_link_attributes
 * - walker_nav_menu_start_el
 *
 */
class PreLaunch_Walker extends Walker_Nav_Menu
{
    /**
     * Builds the opening <li> and <a> markup for a single nav menu item.
     *
     * This method:
     * - Outputs the <li> wrapper with WordPress-generated and admin-defined classes
     * - Outputs the <a> element with the menu item's URL and title
     * - Mirrors menu item classes onto the <a> element for styling hooks
     * - Applies standard WordPress filters for classes and attributes
     *
     * @param string   $output Used to append the generated menu markup (passed by reference).
     * @param WP_Post  $item   Menu item data object.
     * @param int      $depth  Depth of menu item in the hierarchy.
     * @param stdClass $args   Arguments passed to wp_nav_menu().
     * @param int      $id     Current menu item ID.
     */
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
        // Normalize args to safely access properties even if null.
        $args = is_object($args) ? $args : (object) [];

        $title = apply_filters('the_title', $item->title, $item->ID);
        $permalink = !empty($item->url) ? $item->url : '';

        // Collect menu item classes defined in WP admin and core.
        $classes = !empty($item->classes) ? (array) $item->classes : [];
        $classes = array_filter($classes);

        // Build <li> class attribute using standard WordPress filters.
        $li_class_names = join(' ', apply_filters('nav_menu_css_class', $classes, $item, $args, $depth));
        $li_class_attr = $li_class_names ? ' class="' . esc_attr($li_class_names) . '"' : '';

        // Open list item.
        $output .= '<li' . $li_class_attr . '>';

        // Build link attributes from the menu item.
        $atts = [
            'href' => $permalink,
        ];

        if (!empty($item->target)) {
            $atts['target'] = $item->target;
        }

        if (!empty($item->xfn)) {
            $atts['rel'] = $item->xfn;
        }

        if (!empty($item->attr_title)) {
            $atts['title'] = $item->attr_title;
        }

        // Set aria-current for the current item.
        if (!empty($item->current)) {
            $atts['aria-current'] = 'page';
        }

        // Mirror menu item classes onto the <a> element for styling hooks.
        if (!empty($li_class_names)) {
            $atts['class'] = $li_class_names;
        }

        // Apply standard WordPress link attribute filters.
        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);

        // Compile attribute string.
        $attributes = '';
        foreach ($atts as $attr => $value) {
            if ($value === null || $value === '') {
                continue;
            }

            $value = ($attr === 'href') ? esc_url($value) : esc_attr($value);
            $attributes .= ' ' . $attr . '="' . $value . '"';
        }

        // Resolve optional wrappers from wp_nav_menu() args.
        $before = isset($args->before) ? $args->before : '';
        $after = isset($args->after) ? $args->after : '';
        $link_before = isset($args->link_before) ? $args->link_before : '';
        $link_after = isset($args->link_after) ? $args->link_after : '';

        // Build item output and apply the final element filter.
        $item_output = $before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $link_before . esc_html($title) . $link_after;
        $item_output .= '</a>';
        $item_output .= $after;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    /**
     * Appends the closing markup for a menu item.
     *
     * @param string  $output Used to append additional content (passed by reference).
     * @param WP_Post $item   Menu item data object.
     * @param int     $depth  Depth of menu item.
     * @param stdClass $args  Arguments passed to wp_nav_menu().
     */
    public function end_el(&$output, $item, $depth = 0, $args = null)
    {
        $output .= '</li>';
    }

    /**
     * Appends the opening markup for a submenu level.
     *
     * @param string   $output Used to append additional content (passed by reference).
     * @param int      $depth  Depth of menu item.
     * @param stdClass $args   Arguments passed to wp_nav_menu().
     */
    public function start_lvl(&$output, $depth = 0, $args = null)
    {
        $output .= '<ul class="nav-dropdown">';
    }

    /**
     * Appends the closing markup for a submenu level.
     *
     * @param string   $output Used to append additional content (passed by reference).
     * @param int      $depth  Depth of menu item.
     * @param stdClass $args   Arguments passed to wp_nav_menu().
     */
    public function end_lvl(&$output, $depth = 0, $args = null)
    {
        $output .= '</ul>';
    }
}

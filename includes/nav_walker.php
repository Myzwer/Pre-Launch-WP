<?php

/**
 * PreLaunch_Walker - contract-based nav walker (depth 2 only).
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('PreLaunch_Walker')) {

    class PreLaunch_Walker extends Walker_Nav_Menu
    {
        private array $submenu_id_stack = [];
        private array $item_has_children = [];

        /**
         * Ensure $args->has_children is reliably set (WP core is inconsistent here depending on context).
         */
        public function display_element($element, &$children_elements, $max_depth, $depth = 0, $args = null, &$output = null)
        {
            if (!$element) {
                return;
            }

            $id_field = $this->db_fields['id'];
            $element_id = $element->$id_field;

            $has_children = !empty($children_elements[$element_id]);
            $this->item_has_children[$element_id] = $has_children;

            // WP passes $args as an array with the first element being the args object.
            if (is_array($args) && isset($args[0]) && is_object($args[0])) {
                $args[0]->has_children = $has_children;
            } elseif (is_object($args)) {
                $args->has_children = $has_children;
            }

            parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
        }

        /**
         * Only keep "intentional" menu item classes (admin hooks) instead of WP's noisy defaults.
         */
        private function filter_item_classes(array $classes): array
        {
            $classes = array_filter(array_map('sanitize_html_class', $classes));

            $allowed = [];

            foreach ($classes as $c) {
                // CTA hooks (support your current conventions too)
                if (in_array($c, ['nav-cta', 'is-cta', 'menu-cta'], true)) {
                    $allowed[] = $c;
                    continue;
                }

                // Icon hooks
                if ($c === 'has-icon' || str_starts_with($c, 'icon-')) {
                    $allowed[] = $c;
                    continue;
                }

                // Mega hook
                if ($c === 'is-mega') {
                    $allowed[] = $c;
                    continue;
                }
            }

            return array_values(array_unique($allowed));
        }

        public function start_lvl(&$output, $depth = 0, $args = null)
        {
            $depth = (int) $depth;

            // Only one submenu level supported (top-level -> submenu).
            if ($depth !== 0) {
                return;
            }

            $indent = str_repeat("\t", $depth);
            $submenu_id = $this->submenu_id_stack[$depth] ?? '';

            $output .= "\n$indent<div class=\"nav-submenu\" id=\"" . esc_attr($submenu_id) . '" hidden data-nav-submenu>';
            $output .= "\n$indent\t<ul class=\"nav-submenu-list\" role=\"list\">\n";
        }

        public function end_lvl(&$output, $depth = 0, $args = null)
        {
            $depth = (int) $depth;
            if ($depth !== 0) {
                return;
            }

            $indent = str_repeat("\t", $depth);
            $output .= "$indent\t</ul>\n";
            $output .= "$indent</div>\n";
        }

        public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
        {
            $depth = (int) $depth;
            if ($depth > 1) {
                return;
            }

            $indent = ($depth) ? str_repeat("\t", $depth) : '';

            $args = is_object($args) ? $args : (object) [];
            $item_id = (int) $item->ID;

            // Reliable child detection
            $has_children = $this->item_has_children[$item_id] ?? !empty($args->has_children);

            $raw_classes = is_array($item->classes) ? $item->classes : [];
            $admin_classes = $this->filter_item_classes($raw_classes);

            $is_cta = in_array('nav-cta', $admin_classes, true) || in_array('is-cta', $admin_classes, true) || in_array('menu-cta', $admin_classes, true);
            $is_mega = in_array('is-mega', $admin_classes, true);

            $has_icon = in_array('has-icon', $admin_classes, true);
            if (!$has_icon) {
                foreach ($admin_classes as $c) {
                    if (str_starts_with($c, 'icon-')) {
                        $has_icon = true;
                        break;
                    }
                }
            }

            // LI classes: contract first, then admin hooks only
            $li_classes = [];
            $li_classes[] = ($depth === 0) ? 'nav-item' : 'nav-subitem';

            if ($depth === 0 && $has_children) {
                $li_classes[] = 'has-submenu';
            }

            // Normalize CTA to a single class we can style against
            if ($is_cta) {
                $li_classes[] = 'nav-cta';
            }

            // Preserve admin hook classes (icon-* etc.)
            $li_classes = array_merge($li_classes, $admin_classes);

            // Future mega hook (no behavior now)
            if ($depth === 0 && $has_children && $is_mega) {
                $li_classes[] = 'is-mega';
            }

            $li_class_attr = implode(' ', array_unique(array_filter($li_classes)));

            $output .= $indent . '<li class="' . esc_attr($li_class_attr) . '"' . (($depth === 0 && $has_children) ? ' data-nav-item' : '') . '>';

            // Wrapper: only for top-level items (link + toggle alignment)
            if ($depth === 0) {
                $output .= '<div class="nav-item-inner">';
            }

            // Link attributes
            $atts = [];
            $atts['href'] = !empty($item->url) ? $item->url : '';

            if (!empty($item->attr_title)) {
                $atts['title'] = $item->attr_title;
            }
            if (!empty($item->target)) {
                $atts['target'] = $item->target;
                if ($item->target === '_blank') {
                    $atts['rel'] = 'noopener';
                }
            }
            if (!empty($item->xfn)) {
                $atts['rel'] = isset($atts['rel']) ? ($atts['rel'] . ' ' . $item->xfn) : $item->xfn;
            }

            // aria-current
            $is_current =
                !empty($item->current)
                || in_array('current-menu-item', $raw_classes, true)
                || in_array('current_page_item', $raw_classes, true);

            if ($is_current) {
                $atts['aria-current'] = 'page';
            }

            // Link class
            $link_classes = [ ($depth === 0) ? 'nav-link' : 'nav-sublink' ];
            if ($depth === 0 && $is_cta) {
                $link_classes[] = 'nav-cta-link';
            }
            if ($depth === 0 && $has_icon) {
                $link_classes[] = 'nav-link--icon';
            }
            $atts['class'] = implode(' ', array_unique(array_filter($link_classes)));

            $title = apply_filters('the_title', $item->title, $item_id);

            $attributes = '';
            foreach ($atts as $attr => $value) {
                if ($value === '') {
                    continue;
                }
                $value = ($attr === 'href') ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }

            $output .= '<a' . $attributes . '>' . esc_html($title) . '</a>';

            // Toggle button for top-level items with children
            if ($depth === 0 && $has_children) {
                $submenu_id = 'submenu-' . $item_id;
                $this->submenu_id_stack[0] = $submenu_id;

                $toggle_label = sprintf(
                    __('Open %s submenu', 'prelaunch-wp'),
                    wp_strip_all_tags($title)
                );

                $output .= '<button'
                           . ' class="nav-toggle"'
                           . ' type="button"'
                           . ' aria-expanded="false"'
                           . ' aria-controls="' . esc_attr($submenu_id) . '"'
                           . ' aria-label="' . esc_attr($toggle_label) . '"'
                           . ' data-nav-toggle'
                           . '>'
                           . '<span class="nav-toggle-icon" aria-hidden="true"></span>'
                           . '</button>';
            }

            if ($depth === 0) {
                $output .= '</div>'; // .nav-item-inner
            }
        }

        public function end_el(&$output, $item, $depth = 0, $args = null)
        {
            $depth = (int) $depth;
            if ($depth > 1) {
                return;
            }
            $output .= "</li>\n";
        }
    }
}

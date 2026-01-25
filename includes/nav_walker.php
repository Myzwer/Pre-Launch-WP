<?php

/**
 * PreLaunch_Walker - contract-based nav walker (depth 2 only).
 *
 * Rules:
 * - Exactly 2 levels (top-level + one submenu level).
 * - If a top-level item has children, it is a DISCLOSURE (button), not a link.
 * - Submenus are wrapped in: div.nav-submenu#submenu-{ID}[hidden] > ul.nav-submenu-list
 *
 * Admin-controlled hooks:
 * - CTA: add class "nav-cta" OR "is-cta" OR "menu-cta" to the menu item in WP admin
 * - Icons: add "has-icon" + one or more "icon-*" classes to the menu item in WP admin (preserved hook)
 * - Font Awesome: add any "fa-*" classes to the menu item in WP admin (supported now)
 * - Future mega hook: add "is-mega" to menu item class (not implemented yet)
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('PreLaunch_Walker')) {

    class PreLaunch_Walker extends Walker_Nav_Menu
    {
        /**
         * Track submenu IDs for the current top-level item (depth 0).
         * start_el() sets it, start_lvl() consumes it.
         */
        private array $submenu_id_stack = [];

        /**
         * Reliable child detection (WP core is inconsistent depending on context).
         */
        private array $item_has_children = [];

        /**
         * Extract and normalize Font Awesome classes from admin-defined menu classes.
         *
         * FA7 rules enforced:
         * - Exactly ONE style prefix (fa-solid, fa-brands, fa-regular, etc.)
         * - Exactly ONE icon glyph (fa-*)
         * - If no style is provided, default to fa-solid
         *
         * README:CTA_ICON_PREFIX_DEFAULT
         *
         * @param array $classes
         * @return string|null
         */
        private function get_fa_icon_classes(array $classes): ?string
        {
            $style_classes = [];
            $icon_classes = [];

            foreach ($classes as $class) {
                if (!is_string($class) || !str_starts_with($class, 'fa-')) {
                    continue;
                }

                // FA style prefixes (FA6 / FA7 compatible)
                if (
                    $class === 'fa-solid' ||
                    $class === 'fa-regular' ||
                    $class === 'fa-brands' ||
                    $class === 'fa-light' ||
                    $class === 'fa-thin' ||
                    $class === 'fa-duotone' ||
                    str_starts_with($class, 'fa-sharp')
                ) {
                    $style_classes[] = $class;
                    continue;
                }

                // Everything else is treated as a glyph
                $icon_classes[] = $class;
            }

            // Must have at least one icon glyph
            if (empty($icon_classes)) {
                return null;
            }

            // Enforce exactly one style prefix
            if (!empty($style_classes)) {
                $style = $style_classes[0]; // first wins
            } else {
                // Default style (documented + filterable)
                $style = apply_filters('prelaunch_nav_fa_default_style', 'fa-solid');
            }

            // Enforce exactly one glyph (first wins)
            $icon = $icon_classes[0];

            return esc_attr(trim($style . ' ' . $icon));
        }

        /**
         * Ensure $args->has_children is reliably set.
         */
        public function display_element($element, &$children_elements, $max_depth, $depth, $args, &$output)
        {
            if (!$element) {
                return;
            }

            $id_field = $this->db_fields['id'];
            $id = $element->$id_field;

            $has_children = !empty($children_elements[$id]);
            $this->item_has_children[$id] = $has_children;

            if (is_array($args) && isset($args[0]) && is_object($args[0])) {
                $args[0]->has_children = $has_children;
            } elseif (is_object($args)) {
                $args->has_children = $has_children;
            }

            parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
        }

        /**
         * Submenu wrapper (depth 1) open.
         */
        public function start_lvl(&$output, $depth = 0, $args = null)
        {
            $depth = (int) $depth;

            // Only one submenu level supported (depth 1)
            if ($depth !== 0) {
                return;
            }

            $indent = str_repeat("\t", $depth);

            $submenu_id = $this->submenu_id_stack[0] ?? '';

            $output .= "\n$indent<div class=\"nav-submenu\""
                       . ($submenu_id ? ' id="' . esc_attr($submenu_id) . '"' : '')
                       . " hidden data-nav-submenu>\n";

            $output .= "$indent\t<ul class=\"nav-submenu-list\" role=\"list\">\n";
        }

        /**
         * Submenu wrapper (depth 1) close.
         */
        public function end_lvl(&$output, $depth = 0, $args = null)
        {
            $depth = (int) $depth;

            // Only one submenu level supported (depth 1)
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

            // Only support depth 0 and 1 (top + submenu items)
            if ($depth > 1) {
                return;
            }

            $indent = ($depth) ? str_repeat("\t", $depth) : '';

            $item_id = (int) $item->ID;

            // Admin classes (from WP menu item CSS Classes field)
            $admin_classes = is_array($item->classes) ? array_filter($item->classes) : [];

            // CTA normalization: nav-cta OR is-cta OR menu-cta
            $is_cta = false;
            foreach ($admin_classes as $c) {
                if ($c === 'nav-cta' || $c === 'is-cta' || $c === 'menu-cta') {
                    $is_cta = true;
                    break;
                }
            }

            // Icon hooks (future / preserved)
            $has_icon = in_array('has-icon', $admin_classes, true);

            // Mega hook (future / preserved)
            $is_mega = in_array('is-mega', $admin_classes, true);

            // Child detection
            $has_children = $this->item_has_children[$item_id] ?? false;

            // Base LI classes
            $li_classes = [];

            if ($depth === 0) {
                $li_classes[] = 'nav-item';
            } else {
                $li_classes[] = 'nav-subitem';
            }

            if ($depth === 0 && $has_children) {
                $li_classes[] = 'has-submenu';
            }

            // Normalize CTA to a single class we can style against
            if ($is_cta) {
                $li_classes[] = 'nav-cta';
            }

            // Preserve admin hook classes, BUT never output Font Awesome classes on the <li>.
            // Font Awesome Kits (FA6/FA7) may scan fa-* on any element and mutate DOM/styles,
            // which can break layout (e.g., CTA button).
            //
            // We still read fa-* from $admin_classes for the CTA <i>, we just don't print them on <li>.
            $admin_classes_for_li = array_values(array_filter(
                $admin_classes,
                static fn ($c) => is_string($c) && !str_starts_with($c, 'fa-')
            ));

            $li_classes = array_merge($li_classes, $admin_classes_for_li);

            // Future mega hook (no behavior now)
            if ($depth === 0 && $has_children && $is_mega) {
                $li_classes[] = 'is-mega';
            }

            // Print LI open
            $output .= $indent . '<li class="' . esc_attr(implode(' ', array_unique(array_filter($li_classes)))) . '"'
                       . (($depth === 0 && $has_children) ? ' data-nav-item' : '')
                       . '>';

            // Wrapper: only for top-level items (keeps layout consistent)
            if ($depth === 0) {
                $output .= '<div class="nav-item-inner">';
            }

            // Title
            $title = apply_filters('the_title', $item->title, $item_id);

            /**
             * Top-level item with children = DISCLOSURE BUTTON (NOT A LINK)
             */
            if ($depth === 0 && $has_children) {
                $submenu_id = 'submenu-' . $item_id;
                $this->submenu_id_stack[0] = $submenu_id;

                $btn_classes = ['nav-disclosure'];
                if ($has_icon) {
                    $btn_classes[] = 'nav-disclosure--icon';
                }
                $btn_class_attr = implode(' ', array_unique(array_filter($btn_classes)));

                $toggle_label = sprintf(
                    __('Toggle submenu for %s', 'prelaunch-wp'),
                    wp_strip_all_tags($title)
                );

                $output .= '<button'
                           . ' class="' . esc_attr($btn_class_attr) . '"'
                           . ' type="button"'
                           . ' aria-expanded="false"'
                           . ' aria-controls="' . esc_attr($submenu_id) . '"'
                           . ' aria-haspopup="true"'
                           . ' aria-label="' . esc_attr($toggle_label) . '"'
                           . ' data-nav-toggle'
                           . '>'
                           . '<span class="nav-label">' . esc_html($title) . '</span>'
                           . '<i class="fa-solid fa-caret-down nav-caret" aria-hidden="true"></i>'
                           . '</button>';

            } else {
                /**
                 * Otherwise = normal link (top-level items without children, and all submenu links)
                 */
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
                    $atts['rel'] = trim(($atts['rel'] ?? '') . ' ' . $item->xfn);
                }

                $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);

                // Classes for the anchor
                $link_classes = [($depth === 0) ? 'nav-link' : 'nav-sublink'];

                if ($depth === 0 && $is_cta) {
                    $link_classes[] = 'nav-cta-link';
                }

                $atts['class'] = implode(' ', array_unique(array_filter($link_classes)));

                // Build attributes string
                $attributes = '';
                foreach ($atts as $attr => $value) {
                    if (is_scalar($value) && $value !== '') {
                        $value = ($attr === 'href') ? esc_url($value) : esc_attr($value);
                        $attributes .= ' ' . $attr . '="' . $value . '"';
                    }
                }

                if ($depth === 0 && $is_cta) {
                    $fa_icon_class = $this->get_fa_icon_classes($admin_classes);
                    $cta_icon_html = $fa_icon_class
                        ? '<i class="' . esc_attr($fa_icon_class) . ' nav-cta-icon" aria-hidden="true"></i>'
                        : '';

                    /**
                     * README:CTA_ICON_POSITION
                     *
                     * Default CTA markup order is:
                     *   [Label] [Icon]
                     *
                     * If a future site needs the icon on the LEFT:
                     *   - Swap the output order in the block below to:
                     *     [Icon] [Label]
                     *   - No CSS/JS changes required (CTA uses inline-flex + gap already).
                     *   NOTE: Only keep ONE of the $output .= lines active.
                     */
                    $label_html = '<span class="nav-label">' . esc_html($title) . '</span>';

                    // Default (icon on the right)
                    $output .= '<a' . $attributes . '>' . $label_html . $cta_icon_html . '</a>';

                    /*
                     // Alternate (icon on the left)
                     $output .= '<a' . $attributes . '>' . $cta_icon_html . $label_html . '</a>';
                    */

                } else {
                    $output .= '<a' . $attributes . '>' . esc_html($title) . '</a>';
                }
            }

            if ($depth === 0) {
                $output .= '</div>'; // .nav-item-inner
            }
        }

        public function end_el(&$output, $item, $depth = 0, $args = null)
        {
            $depth = (int) $depth;

            // Close LI
            $output .= "</li>\n";
        }
    }
}

<?php

/**
 * PreLaunch_Walker
 *
 * Contract-based primary navigation walker (depth 2 only).
 *
 * This walker intentionally outputs a stable, minimal DOM. CSS/JS assume this structure.
 * Do not change markup (nesting, class names, data attributes, submenu wrappers, depth handling)
 * unless the DOM contract is being updated intentionally and re-tested.
 *
 * DOM contract summary:
 * - Exactly 2 levels: top-level (depth 0) + one submenu level (depth 1).
 * - Top-level items with children render as a disclosure <button> (not a link).
 * - Submenus render as:
 *     <div class="nav-submenu" id="submenu-{ID}" hidden data-nav-submenu>
 *       <ul class="nav-submenu-list" role="list"> ... </ul>
 *     </div>
 *
 * Admin class hooks (WP menu item “CSS Classes” field):
 * - CTA: "nav-cta" OR "is-cta" OR "menu-cta" (normalized to .nav-cta on the <li>)
 * - Reserved/preserved hooks: "has-icon", "icon-*", "is-mega"
 * - Font Awesome icons: any "fa-*" classes (read for CTA icon rendering)
 *
 * README flags:
 * - README:CTA_ICON_PREFIX_DEFAULT  Default FA style prefix when none is provided.
 * - README:CTA_ICON_POSITION        CTA icon label/icon order (documented swap only).
 * - README:FA_CLASSES_ON_LI         Reason FA classes are not printed on <li>.
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

            // CTA detection (supported admin hooks: nav-cta | is-cta | menu-cta).
            $is_cta = (
                in_array('nav-cta', $admin_classes, true) ||
                in_array('is-cta', $admin_classes, true) ||
                in_array('menu-cta', $admin_classes, true)
            );

            // Icon hooks (future / preserved)
            $has_icon = in_array('has-icon', $admin_classes, true);

            // Future mega hook (preserved)
            $is_mega = in_array('is-mega', $admin_classes, true);

            // Reliable has-children flag set in display_element()
            $has_children = $this->item_has_children[$item_id] ?? false;

            // Classes for the LI
            $li_classes = [($depth === 0) ? 'nav-item' : 'nav-subitem'];

            if ($depth === 0 && $has_children) {
                $li_classes[] = 'has-submenu';
            }

            if ($is_cta) {
                $li_classes[] = 'nav-cta';
            }

            // Preserve admin hook classes on the <li>, excluding any Font Awesome classes.
            //
            // README:FA_CLASSES_ON_LI
            // Font Awesome Kits (FA6/FA7) can scan for `fa-*` classes on non-<i> elements and inject SVG markup.
            // If `fa-*` classes are printed on the <li>, this can create layout side effects (notably breaking CTA button sizing).
            // Font Awesome classes remain available via $admin_classes for CTA icon rendering on the <i>.
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

            if ($depth === 0) {
                $output .= '<div class="nav-item-inner">';
            }

            $title = apply_filters('the_title', $item->title, $item_id);

            if ($depth === 0 && $has_children) {
                $submenu_id = 'submenu-' . $item_id;
                $this->submenu_id_stack[0] = $submenu_id;

                // Disclosure button (top-level items that have submenus)
                $btn_classes = ['nav-disclosure'];
                if ($has_icon) {
                    $btn_classes[] = 'nav-disclosure--icon';
                }

                $toggle_label = sprintf(
                    __('Toggle submenu for %s', 'prelaunch-wp'),
                    wp_strip_all_tags($title)
                );

                $output .= '<button'
                           . ' class="' . esc_attr(implode(' ', array_unique(array_filter($btn_classes)))) . '"'
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
                 * Normal link output (top-level items without children, and all submenu links)
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
                     * If a future site needs icon-first:
                     * - Swap the output order in the block below to:
                     *     [Icon] [Label]
                     * - No CSS/JS changes are expected (CTA uses inline-flex + gap).
                     *
                     * Safe swap reference (leave only one line active):
                     *   // Current (suffix): label then icon
                     *   // $output .= '<a' . $attributes . '>' . $label_html . $cta_icon_html . '</a>';
                     *   // Alternate (prefix): icon then label
                     *   // $output .= '<a' . $attributes . '>' . $cta_icon_html . $label_html . '</a>';
                     */
                    $label_html = '<span class="nav-label">' . esc_html($title) . '</span>';

                    // Default (icon on the right): [Label] [Icon]
                    $output .= '<a' . $attributes . '>' . $label_html . $cta_icon_html . '</a>';

                    /*
                     // Alternate (icon on the left): [Icon] [Label]
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
            // Close LI
            $output .= "</li>\n";
        }
    }
}

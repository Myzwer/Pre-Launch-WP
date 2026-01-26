/**
 * TinyMCE Button Generator (Admin Only)
 * ------------------------------------
 * This script registers a custom TinyMCE toolbar button ("Button") for
 * ACF WYSIWYG fields using the Classic editor (TinyMCE 4).
 *
 * Purpose:
 * - Provide a UI-driven way for clients to insert the [btn] shortcode
 *   without manually typing shortcode syntax.
 * - Reduce errors in WYSIWYG content and improve editor UX.
 *
 * What it does:
 * - Adds a "Button" control to the main TinyMCE toolbar.
 * - Opens a modal that collects button options (text, URL, style, icon, etc.).
 * - Validates required fields.
 * - Normalizes internal URLs (auto-prepends "/" when appropriate).
 * - Inserts a clean, minimal [btn ...] shortcode at the cursor.
 *
 * Important notes:
 * - This is intentionally written for TinyMCE 4 compatibility, which is what
 *   ACF WYSIWYG uses under the hood in WordPress.
 * - TinyMCE 4 requires listbox options to use `text` (not `label`), or dropdown
 *   items will render with no visible text.
 * - This file does NOT control frontend rendering — it only inserts shortcodes.
 *
 * Related files:
 * - /includes/editor_tools.php  → registers this script with TinyMCE
 * - /assets/admin/tinymce-btn.css → styles the toolbar button and modal UI
 * - /includes/shortcodes.php → defines how the [btn] shortcode renders frontend
 */
(function () {
	if (typeof tinymce === "undefined") return;

	const PLUGIN_NAME = "wpk_btn";
	const BUTTON_ID = "wpk_btn";

	const VARIANTS = [
		{ text: "Main", value: "main" },
		{ text: "Secondary", value: "secondary" },
		{ text: "Light", value: "light" },
		{ text: "Dark", value: "dark" },
		{ text: "Ghost White", value: "ghost_white" },
		{ text: "Ghost Black", value: "ghost_black" },
	];

	const ICONS = [
		{ text: "None", value: "none" },
		{ text: "Arrow", value: "arrow" },
		{ text: "External Link", value: "external" },
		{ text: "Download", value: "download" },
		{ text: "Phone", value: "phone" },
		{ text: "Email", value: "email" },
	];

	/**
	 * Normalizes a URL entered by the user for safe shortcode output.
	 *
	 * @param {string} url - Raw URL input from the modal field.
	 * @return {string} Normalized URL suitable for the [btn] shortcode.
	 */
	function normalizeUrl(url) {
		if (!url) return url;

		const trimmed = url.trim();

		// Allow absolute URLs and protocols
		if (
			trimmed.startsWith("http://") ||
			trimmed.startsWith("https://") ||
			trimmed.startsWith("mailto:") ||
			trimmed.startsWith("tel:") ||
			trimmed.startsWith("/")
		) {
			return trimmed;
		}

		return "/" + trimmed;
	}

	/**
	 * Builds and inserts a [btn] shortcode at the current TinyMCE cursor position.
	 *
	 * @param {Object} editor - TinyMCE editor instance.
	 * @param {Object} attrs - Parsed button attributes from the modal.
	 */
	function insertShortcode(editor, attrs) {
		let shortcode = `[btn text="${attrs.text}" url="${attrs.url}"`;

		if (attrs.variant !== "main") {
			shortcode += ` variant="${attrs.variant}"`;
		}

		if (attrs.icon !== "none") {
			shortcode += ` icon="${attrs.icon}" icon_pos="${attrs.icon_pos}"`;
		}

		if (attrs.tab) {
			shortcode += ` tab="Y"`;
		}

		if (attrs.center) {
			shortcode += ` center="Y"`;
		}

		shortcode += `]`;

		editor.execCommand("mceInsertContent", false, shortcode);
		editor.focus();
	}

	tinymce.PluginManager.add(PLUGIN_NAME, function (editor) {
		editor.addButton(BUTTON_ID, {
			text: "Button",
			tooltip: "Insert Button",
			onclick: function () {
				editor.windowManager.open({
					title: "Insert Button",
					body: [
						{ type: "textbox", name: "text", label: "Button Text" },

						{
							type: "textbox",
							name: "url",
							label: "URL",
							placeholder: "/contact or https://example.com",
						},

						{
							type: "label",
							text:
								"Use /page-slug for internal links or a full URL for external links.",
						},

						{
							type: "listbox",
							name: "variant",
							label: "Style",
							values: VARIANTS,
							value: "main",
						},

						{
							type: "listbox",
							name: "icon",
							label: "Icon",
							values: ICONS,
							value: "none",
						},

						{
							type: "listbox",
							name: "icon_pos",
							label: "Icon Position",
							values: [
								{ text: "Right", value: "right" },
								{ text: "Left", value: "left" },
							],
							value: "right",
						},

						{ type: "checkbox", name: "tab", label: "Open in new tab?" },
						{ type: "checkbox", name: "center", label: "Center Button?" },
					],

					onsubmit: function (e) {
						if (!e.data.text || !e.data.url) {
							alert("Button Text and URL are required.");
							return;
						}

						insertShortcode(editor, {
							text: e.data.text,
							url: normalizeUrl(e.data.url),
							variant: e.data.variant || "main",
							icon: e.data.icon || "none",
							icon_pos: e.data.icon_pos || "right",
							tab: !!e.data.tab,
							center: !!e.data.center,
						});
					},
				});
			},
		});
	});
})();

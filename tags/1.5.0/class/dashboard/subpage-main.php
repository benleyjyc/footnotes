<?php
/**
 * Includes the Plugin Class to display all Settings.
 *
 * @filesource
 * @author Stefan Herndler
 * @since 1.5.0 14.09.14 14:47
 */

/**
 * Displays and handles all Settings of the Plugin.
 *
 * @author Stefan Herndler
 * @since 1.5.0
 */
class MCI_Footnotes_Layout_Settings extends MCI_Footnotes_LayoutEngine {

	/**
	 * Returns a Priority index. Lower numbers have a higher Priority.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @return int
	 */
	public function getPriority() {
		return 10;
	}

	/**
	 * Returns the unique slug of the sub page.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @return string
	 */
	protected function getSubPageSlug() {
		return "-" . MCI_Footnotes_Config::C_STR_PLUGIN_NAME;
	}

	/**
	 * Returns the title of the sub page.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @return string
	 */
	protected function getSubPageTitle() {
		return MCI_Footnotes_Config::C_STR_PLUGIN_PUBLIC_NAME;
	}

	/**
	 * Returns an array of all registered sections for the sub page.
	 *
	 * @author Stefan Herndler
	 * @since  1.5.0
	 * @return array
	 */
	protected function getSections() {
		return array(
			$this->addSection("settings", __("Settings", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), 0, true),
			$this->addSection("customize", __("Customize", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), 1, true),
			$this->addSection("how-to", __("How to", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), null, false)
		);
	}

	/**
	 * Returns an array of all registered meta boxes for each section of the sub page.
	 *
	 * @author Stefan Herndler
	 * @since  1.5.0
	 * @return array
	 */
	protected function getMetaBoxes() {
		return array(
			$this->addMetaBox("settings", "reference-container", __("References Container", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), "ReferenceContainer"),
			$this->addMetaBox("settings", "styling", sprintf(__("%s styling", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), MCI_Footnotes_Config::C_STR_PLUGIN_PUBLIC_NAME), "Styling"),
			$this->addMetaBox("settings", "love", MCI_Footnotes_Config::C_STR_PLUGIN_PUBLIC_NAME . '&nbsp;' . MCI_Footnotes_Config::C_STR_LOVE_SYMBOL, "Love"),
			$this->addMetaBox("settings", "other", __("Other", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), "Other"),

			$this->addMetaBox("customize", "superscript", __("Superscript layout", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), "Superscript"),
			$this->addMetaBox("customize", "hyperlink-arrow", __("Hyperlink symbol in the Reference container", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), "HyperlinkArrow"),
			$this->addMetaBox("customize", "custom-css", __("Add custom CSS to the public page", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), "CustomCSS"),

			$this->addMetaBox("how-to", "help", __("Brief introduction in how to use the plugin", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), "Help"),
			$this->addMetaBox("how-to", "donate", __("Help us to improve our Plugin", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), "Donate")
		);
	}

	/**
	 * Displays all settings for the reference container.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 */
	public function ReferenceContainer() {
		// options for the positioning of the reference container
		$l_arr_Positions = array(
			"footer" => __("in the footer", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
			"post_end" => __("at the end of the post", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
			"widget" => __("in the widget area", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)
		);

		// load template file
		$l_obj_Template = new MCI_Footnotes_Template(MCI_Footnotes_Template::C_STR_DASHBOARD, "settings-reference-container");
		// replace all placeholders
		$l_obj_Template->replace(
			array(
				"label-name" => $this->addLabel(MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_NAME, __("References label", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
				"name" => $this->addTextBox(MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_NAME),

				"label-collapse" => $this->addLabel(MCI_Footnotes_Settings::C_BOOL_REFERENCE_CONTAINER_COLLAPSE, __("Collapse references by default", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
				"collapse" => $this->addCheckbox(MCI_Footnotes_Settings::C_BOOL_REFERENCE_CONTAINER_COLLAPSE),

				"label-position" => $this->addLabel(MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_POSITION, __("Where shall the reference container appear", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
				"position" => $this->addSelectBox(MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_POSITION, $l_arr_Positions)
			)
		);
		// display template with replaced placeholders
		echo $l_obj_Template->getContent();
	}

	/**
	 * Displays all settings for the footnotes styling.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 */
	public function Styling() {
		// define some space for the output
		$l_str_Space = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		// options for the combination of identical footnotes
		$l_arr_CombineIdentical = array(
			"yes" => __("Yes", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
			"no" => __("No", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)
		);
		// options for the start of the footnotes short code
		$l_arr_ShortCodeStart = array(
			"((" => "((",
			htmlspecialchars("<fn>") => htmlspecialchars("<fn>"),
			"[ref]" => "[ref]",
			"userdefined" => __('user defined', MCI_Footnotes_Config::C_STR_PLUGIN_NAME)
		);
		// options for the end of the footnotes short code
		$l_arr_ShortCodeEnd = array(
			"))" => "))",
			htmlspecialchars("</fn>") => htmlspecialchars("</fn>"),
			"[/ref]" => "[/ref]",
			"userdefined" => __('user defined', MCI_Footnotes_Config::C_STR_PLUGIN_NAME)
		);
		// options for the counter style of the footnotes
		$l_arr_CounterStyle = array(
			"arabic_plain" => __("Arabic Numbers - Plain", MCI_Footnotes_Config::C_STR_PLUGIN_NAME) . $l_str_Space . "1, 2, 3, 4, 5, ...",
			"arabic_leading" => __("Arabic Numbers - Leading 0", MCI_Footnotes_Config::C_STR_PLUGIN_NAME) . $l_str_Space . "01, 02, 03, 04, 05, ...",
			"latin_low" => __("Latin Character - lower case", MCI_Footnotes_Config::C_STR_PLUGIN_NAME) . $l_str_Space . "a, b, c, d, e, ...",
			"latin_high" => __("Latin Character - upper case", MCI_Footnotes_Config::C_STR_PLUGIN_NAME) . $l_str_Space . "A, B, C, D, E, ...",
			"romanic" => __("Roman Numerals", MCI_Footnotes_Config::C_STR_PLUGIN_NAME) . $l_str_Space . "I, II, III, IV, V, ..."
		);

		// load template file
		$l_obj_Template = new MCI_Footnotes_Template(MCI_Footnotes_Template::C_STR_DASHBOARD, "settings-styling");
		// replace all placeholders
		$l_obj_Template->replace(
			array(
				"label-identical" => $this->addLabel(MCI_Footnotes_Settings::C_BOOL_COMBINE_IDENTICAL_FOOTNOTES, __("Combine identical footnotes", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
				"identical" => $this->addSelectBox(MCI_Footnotes_Settings::C_BOOL_COMBINE_IDENTICAL_FOOTNOTES, $l_arr_CombineIdentical),

				"label-short-code-start" => $this->addLabel(MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_START, __("Footnote tag starts with", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
				"short-code-start" => $this->addSelectBox(MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_START, $l_arr_ShortCodeStart),

				"label-short-code-end" => $this->addLabel(MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_END, __("and ends with", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
				"short-code-end" => $this->addSelectBox(MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_END, $l_arr_ShortCodeEnd),

				"label-short-code-start-user" => $this->addLabel(MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_START_USER_DEFINED, ""),
				"short-code-start-user" => $this->addTextBox(MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_START_USER_DEFINED),

				"label-short-code-end-user" => $this->addLabel(MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_END_USER_DEFINED, ""),
				"short-code-end-user" => $this->addTextBox(MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_END_USER_DEFINED),

				"label-counter-style" => $this->addLabel(MCI_Footnotes_Settings::C_STR_FOOTNOTES_COUNTER_STYLE, __("Counter style", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
				"counter-style" => $this->addSelectBox(MCI_Footnotes_Settings::C_STR_FOOTNOTES_COUNTER_STYLE, $l_arr_CounterStyle),

				"short-code-start-id" => MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_START,
				"short-code-end-id" => MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_END,
				"short-code-start-user-id" => MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_START_USER_DEFINED,
				"short-code-end-user-id" => MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_END_USER_DEFINED,
			)
		);
		// display template with replaced placeholders
		echo $l_obj_Template->getContent();
	}

	/**
	 * Displays all settings for 'I love Footnotes'.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 */
	public function Love() {
		// options for the positioning of the reference container
		$l_arr_Love = array(
			"text-1" => sprintf(__('I %s %s', MCI_Footnotes_Config::C_STR_PLUGIN_NAME), MCI_Footnotes_Config::C_STR_LOVE_SYMBOL, MCI_Footnotes_Config::C_STR_PLUGIN_PUBLIC_NAME),
			"text-2" => sprintf(__('this site uses the awesome %s Plugin', MCI_Footnotes_Config::C_STR_PLUGIN_NAME), MCI_Footnotes_Config::C_STR_PLUGIN_PUBLIC_NAME),
			"text-3" => sprintf(__('extra smooth %s', MCI_Footnotes_Config::C_STR_PLUGIN_NAME), MCI_Footnotes_Config::C_STR_PLUGIN_PUBLIC_NAME),
			"random" => __('random text', MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
			"no" => sprintf(__("Don't display a %s %s text in my footer.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), MCI_Footnotes_Config::C_STR_PLUGIN_PUBLIC_NAME, MCI_Footnotes_Config::C_STR_LOVE_SYMBOL)
		);

		// load template file
		$l_obj_Template = new MCI_Footnotes_Template(MCI_Footnotes_Template::C_STR_DASHBOARD, "settings-love");
		// replace all placeholders
		$l_obj_Template->replace(
			array(
				"label-love" => $this->addLabel(MCI_Footnotes_Settings::C_STR_FOOTNOTES_LOVE, sprintf(__("Tell the world you're using %s", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), MCI_Footnotes_Config::C_STR_PLUGIN_PUBLIC_NAME)),
				"love" => $this->addSelectBox(MCI_Footnotes_Settings::C_STR_FOOTNOTES_LOVE, $l_arr_Love),

				"label-no-love" => $this->addText(sprintf(__("Don't tell the world you're using %s on specific pages by adding the following short code:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), MCI_Footnotes_Config::C_STR_PLUGIN_PUBLIC_NAME)),
				"no-love" => $this->addText(MCI_Footnotes_Config::C_STR_NO_LOVE_SLUG)
			)
		);
		// display template with replaced placeholders
		echo $l_obj_Template->getContent();
	}

	/**
	 * Displays all settings that are not grouped in special meta boxes.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 */
	public function Other() {
		// options for the Footnotes to be replaced in excerpt
		$l_arr_Excerpt = array(
			"yes" => __("Yes", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
			"no" => __("No", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)
		);

		// load template file
		$l_obj_Template = new MCI_Footnotes_Template(MCI_Footnotes_Template::C_STR_DASHBOARD, "settings-other");
		// replace all placeholders
		$l_obj_Template->replace(
			array(
				"label-excerpt" => $this->addLabel(MCI_Footnotes_Settings::C_BOOL_FOOTNOTES_IN_EXCERPT, __("Allow footnotes on Summarized Posts", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
				"excerpt" => $this->addSelectBox(MCI_Footnotes_Settings::C_BOOL_FOOTNOTES_IN_EXCERPT, $l_arr_Excerpt)
			)
		);
		// display template with replaced placeholders
		echo $l_obj_Template->getContent();
	}

	/**
	 * Displays all settings for the footnotes Superscript.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 */
	public function Superscript() {
		// load template file
		$l_obj_Template = new MCI_Footnotes_Template(MCI_Footnotes_Template::C_STR_DASHBOARD, "customize-superscript");
		// replace all placeholders
		$l_obj_Template->replace(
			array(
				"label-before" => $this->addLabel(MCI_Footnotes_Settings::C_STR_FOOTNOTES_STYLING_BEFORE, __("Before Footnotes index", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
				"before" => $this->addTextBox(MCI_Footnotes_Settings::C_STR_FOOTNOTES_STYLING_BEFORE),

				"label-after" => $this->addLabel(MCI_Footnotes_Settings::C_STR_FOOTNOTES_STYLING_AFTER, __("After Footnotes index", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
				"after" => $this->addTextBox(MCI_Footnotes_Settings::C_STR_FOOTNOTES_STYLING_AFTER)
			)
		);
		// display template with replaced placeholders
		echo $l_obj_Template->getContent();
	}

	/**
	 * Displays all settings for the hyperlink arrow.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 */
	public function HyperlinkArrow() {
		// load template file
		$l_obj_Template = new MCI_Footnotes_Template(MCI_Footnotes_Template::C_STR_DASHBOARD, "customize-hyperlink-arrow");
		// replace all placeholders
		$l_obj_Template->replace(
			array(
				"label-symbol" => $this->addLabel(MCI_Footnotes_Settings::C_STR_HYPERLINK_ARROW, __("Hyperlink symbol", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
				"symbol" => $this->addSelectBox(MCI_Footnotes_Settings::C_STR_HYPERLINK_ARROW, MCI_Footnotes_Convert::getArrow()),

				"label-user-defined" => $this->addLabel(MCI_Footnotes_Settings::C_STR_HYPERLINK_ARROW_USER_DEFINED, __("or enter a user defined symbol", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
				"user-defined" => $this->addTextBox(MCI_Footnotes_Settings::C_STR_HYPERLINK_ARROW_USER_DEFINED),
				"comment" => __("if set it overrides the hyperlink symbol above", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)
			)
		);
		// display template with replaced placeholders
		echo $l_obj_Template->getContent();
	}

	/**
	 * Displays the custom css box.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 */
	public function CustomCSS() {
		// load template file
		$l_obj_Template = new MCI_Footnotes_Template(MCI_Footnotes_Template::C_STR_DASHBOARD, "customize-css");
		// replace all placeholders
		$l_obj_Template->replace(
			array(
				"label-css" => $this->addLabel(MCI_Footnotes_Settings::C_STR_CUSTOM_CSS, __("Add custom CSS", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
				"css" => $this->addTextArea(MCI_Footnotes_Settings::C_STR_CUSTOM_CSS),

				"headline" => $this->addText(__("Available CSS classes to customize the footnotes and the reference container", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),

				"label-class-1" => ".footnote_plugin_tooltip_text",
				"class-1" => $this->addText(__("inline footnotes", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),

				"label-class-2" => ".footnote_tooltip",
				"class-2" => $this->addText(__("inline footnotes, mouse over highlight box", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),

				"label-class-3" => ".footnote_plugin_index",
				"class-3" => $this->addText(__("reference container footnotes index", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),

				"label-class-4" => ".footnote_plugin_link",
				"class-4" => $this->addText(__("reference container footnotes linked arrow", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),

				"label-class-5" => ".footnote_plugin_text",
				"class-5" => $this->addText(__("reference container footnotes text", MCI_Footnotes_Config::C_STR_PLUGIN_NAME))
			)
		);
		// display template with replaced placeholders
		echo $l_obj_Template->getContent();
	}

	/**
	 * Displays a short introduction of the Plugin.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 */
	public function Help() {
		global $g_obj_MCI_Footnotes;
		// load footnotes starting and end tag
		$l_arr_Footnote_StartingTag = $this->LoadSetting(MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_START);
		$l_arr_Footnote_EndingTag = $this->LoadSetting(MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_END);

		if ($l_arr_Footnote_StartingTag["value"] == "userdefined" || $l_arr_Footnote_EndingTag["value"] == "userdefined") {
			// load user defined starting and end tag
			$l_arr_Footnote_StartingTag = $this->LoadSetting(MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_START_USER_DEFINED);
			$l_arr_Footnote_EndingTag = $this->LoadSetting(MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_END_USER_DEFINED);
		}
		$l_str_Example = "Hello" . $l_arr_Footnote_StartingTag["value"] . __("example string", MCI_Footnotes_Config::C_STR_PLUGIN_NAME) . $l_arr_Footnote_EndingTag["value"] . " World!";

		// load template file
		$l_obj_Template = new MCI_Footnotes_Template(MCI_Footnotes_Template::C_STR_DASHBOARD, "how-to-help");
		// replace all placeholders
		$l_obj_Template->replace(
			array(
				"label-start" => __("Start your footnote with the following short code:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
				"start" => $l_arr_Footnote_StartingTag["value"],

				"label-end" => __("...and end your footnote with this short code:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
				"end" => $l_arr_Footnote_EndingTag["value"],

				"example-code" => $l_str_Example,
				"example-string" => __("will be displayed as:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
				"example" => $g_obj_MCI_Footnotes->a_obj_Task->exec($l_str_Example, true),

				"information" => sprintf(__("For further information please check out our %ssupport forum%s on WordPress.org.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), '<a href="http://wordpress.org/support/plugin/footnotes" target="_blank" class="footnote_plugin">', '</a>')
			)
		);
		// display template with replaced placeholders
		echo $l_obj_Template->getContent();
	}

	/**
	 * Displays all Donate button to support the developers.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 */
	public function Donate() {
		// load template file
		$l_obj_Template = new MCI_Footnotes_Template(MCI_Footnotes_Template::C_STR_DASHBOARD, "how-to-donate");
		// replace all placeholders
		$l_obj_Template->replace(
			array(
				"caption" => __('Donate now',MCI_Footnotes_Config::C_STR_PLUGIN_NAME)
			)
		);
		// display template with replaced placeholders
		echo $l_obj_Template->getContent();
	}
}
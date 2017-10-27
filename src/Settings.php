<?php
/**
 * Created by PhpStorm.
 * User: fredbradley
 * Date: 27/10/2017
 * Time: 11:04
 */

namespace FredBradley\CranleighCulturePlugin;

use WeDevs_Settings_API;

class Settings {

	private $settings_api;

	function __construct() {
		$this->settings_api = new WeDevs_Settings_API;

		add_action( 'admin_init', array($this, 'admin_init') );
		add_action( 'admin_menu', array($this, 'admin_menu') );
	}

	function admin_init() {

		//set the settings
		$this->settings_api->set_sections( $this->get_settings_sections() );
		$this->settings_api->set_fields( $this->get_settings_fields() );

		//initialize settings
		$this->settings_api->admin_init();
	}

	function admin_menu() {
		//add_options_page( 'Culture Settings', 'Culture Settings', 'manage_options', 'culture-settings', array($this, 'plugin_page') );
		add_submenu_page("edit.php?post_type=culture-article", "Culture Settings", "Settings", "manage_options", "culture-settings", array($this, 'plugin_page'));
	}

	function get_settings_sections() {
		$sections = array(
			array(
				'id' => 'culture-settings',
				'title' => __( 'Culture Plugin Settings', 'wedevs' )
			),

		);
		return $sections;
	}

	/**
	 * Returns all the settings fields
	 *
	 * @return array settings fields
	 */
	function get_settings_fields() {
		$settings_fields = array(
			'culture-settings' => array(
				array(
					'name'              => 'welcome-paragraph',
					'label'             => __( 'Welcome Paragraph', 'wedevs' ),
					'desc'              => __( 'Opening Blurb by Jody', 'wedevs' ),
					'type'              => 'wysiwyg',
				),
				array(
					"name"              => "include-drafts",
					"label"             => "Include Drafts",
					"desc"              => "Would you like to include drafts on archive page",
					"type"              => "checkbox"
				),
				array(
					"name" => "admin-only",
					"label" => "Admin Only",
					"type" =>"checkbox"
				)

			),
		);

		return $settings_fields;
	}

	private function get_plugin_list() {
		$all_plugins = get_plugins();
		$output = array();
		foreach ($all_plugins as $plugin => $value):
			$output[$plugin] = $value['Name'];
		endforeach;

		return $output;
	}

	function plugin_page() {
		echo '<div class="wrap">';

		if (count($this->get_settings_sections()) > 1):
			$this->settings_api->show_navigation();
		endif;
		$this->settings_api->show_forms();

		echo '</div>';
	}



	/**
	 * Get all the pages
	 *
	 * @return array page names with key value pairs
	 */
	function get_pages() {
		$pages = get_pages();
		$pages_options = array();
		if ( $pages ) {
			foreach ($pages as $page) {
				$pages_options[$page->ID] = $page->post_title;
			}
		}

		return $pages_options;
	}

}


<?php

namespace FredBradley\CranleighCulturePlugin;

/**
 * Class Plugin
 *
 * @package FredBradley\CranleighCulturePlugin
 */
class Plugin extends BaseController {

	/**
	 * @var
	 */
	private $post_type;

	/**
	 * Plugin constructor.
	 */
	public function __construct() {
		parent::__construct();
		$this->runUpdateChecker( 'cranleigh-culture-plugin' );
		Admin::run();
		Template::run();
		$settings = new Settings();
		add_filter('get_the_archive_title', array($this,'filter_title'), 4);

	}
	public static function setting($setting) {
		$settings = new Setting('culture-settings');
		return $settings->$setting;
	}
	/**
	 *
	 */
	public function setupPlugin() {
		// TODO: Implement setupPlugin() method.

		// TODO: Custom Post Type
		$this->createCustomPostType("Culture Article")->register();
	}

	/**
	 * @param string $post_type_key
	 *
	 * @return \FredBradley\CranleighCulturePlugin\CustomPostType
	 */
	private function createCustomPostType( string $post_type_key ) {

		$this->post_type = new CustomPostType( $post_type_key );

		return $this->post_type;
	}

	public function filter_title($title) {
		if (is_post_type_archive( $this->post_type )):
			return str_replace("Archives:", "", $title); //'The ' . $title . ' was filtered';
		endif;

		return $title;
	}

}

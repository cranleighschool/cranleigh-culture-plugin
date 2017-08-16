<?php

namespace FredBradley\CranleighCulturePlugin;

/**
 * Class Plugin
 *
 * @package FredBradley\CranleighCulturePlugin
 */
class Plugin extends BaseController {

	private $post_type;

	public function __construct() {
		parent::__construct();
		$this->runUpdateChecker( 'cranleigh-culture-plugin' );
	}

	public function setupPlugin() {
		// TODO: Implement setupPlugin() method.

		// TODO: Custom Post Type
		$this->createCustomPostType("Culture Article")->register();
	}

	private function createCustomPostType( string $post_type_key ) {

		$this->post_type = new CustomPostType( $post_type_key );

		return $this->post_type;
	}
}

<?php
/**
 * Created by PhpStorm.
 * User: fredbradley
 * Date: 27/10/2017
 * Time: 11:23
 */

namespace FredBradley\CranleighCulturePlugin;

use WP_Error;
class Setting {
	private $option_name;

	public $settings;

	public function __construct( $option_name ) {
		$this->option_name = $option_name;
		$this->settings    = get_option( $this->option_name );
	}

	public function __get( $name ) {
		if ( isset( $this->settings[ $name ] ) ) {
			return $this->settings[ $name ];
		} else {
			new WP_Error( '400', 'Setting Not Found' );
		}
		// return $this->settings[$name];
	}
}

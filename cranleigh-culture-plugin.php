<?php
/*
Plugin Name: Cranleigh Culture Plugin
Plugin URI: https://www.cranleigh.org
Description: Cranleigh Culture Plugin
Version: 1.3
Author: fredbradley
Author URI: https://www.cranleigh.org
License: GPL2
*/

namespace FredBradley\CranleighCulturePlugin;

if ( ! defined( 'WPINC' ) ) {
	die;
}
require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

$plugin = new Plugin();

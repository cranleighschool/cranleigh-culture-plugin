<?php
/**
 * Created by PhpStorm.
 * User: fredbradley
 * Date: 24/07/2017
 * Time: 14:00
 */

namespace FredBradley\CranleighCulturePlugin;

use PostTypes\PostType;

class CustomPostType
{
	private $post_type_key;

	public $post_type;

	private $supports = [
		"thumbnail",
		"title",
		"editor",
	];

	private $options = [
		"menu_position" => 27,
		"menu_icon" => "dashicons-book-alt",
	];

	public $labels = [
	];

	function __construct(string $post_key, array $options=[], array $labels=[]) {

		$this->setPostTypeKey( $post_key );

		$this->labels = array_merge( $this->labels, $labels );

		$this->options[ 'supports' ] = $this->supports;

		$this->options = array_merge( $options, $this->options );
	}
	
	public function register() {
		$this->post_type = new PostType($this->post_type_key, $this->options, $this->labels);
		$this->setTaxonomies();
	}

	private function setPostTypeKey(string $key) {
		$key                 = str_replace(" ", "-", $key);
		$this->post_type_key = strtolower($key);
	}

	private function setTaxonomies() {
		$this->post_type->taxonomy('culture-mag-edition');
		$this->post_type->taxonomy('post_tag');
		$this->post_type->taxonomy('category');

	}

}

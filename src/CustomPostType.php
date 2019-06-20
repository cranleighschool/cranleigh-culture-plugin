<?php
/**
 * Created by PhpStorm.
 * User: fredbradley
 * Date: 24/07/2017
 * Time: 14:00
 */

namespace FredBradley\CranleighCulturePlugin;

use PostTypes\PostType;

/**
 * Class CustomPostType
 *
 * @package FredBradley\CranleighCulturePlugin
 */
class CustomPostType {

	/**
	 * @var
	 */
	private $post_type_key;

	/**
	 * @var
	 */
	public $post_type;

	/**
	 * @var array
	 */
	private $supports = [
		'thumbnail',
		'title',
		'editor',
		'page-attributes',
	];

	/**
	 * @var array
	 */
	private $options = [
		'menu_position' => 27,
		'menu_icon'     => 'dashicons-book-alt',
		'has_archive'   => true,
		'rewrite'       => [
			'slug' => 'culture',
		],
	];

	/**
	 * @var array
	 */
	public $labels = [
		'name' => 'Culture Magazine',
	];

	/**
	 * CustomPostType constructor.
	 *
	 * @param string $post_key
	 * @param array  $options
	 * @param array  $labels
	 */
	function __construct( string $post_key, array $options = [], array $labels = [] ) {

		$this->setPostTypeKey( $post_key );

		$this->labels = array_merge( $this->labels, $labels );

		$this->options['supports'] = $this->supports;

		$this->options = array_merge( $options, $this->options );

		add_filter( 'rwmb_meta_boxes', array( $this, 'metaboxes' ) );
		add_action(
			'edit_form_after_title',
			function() {
				global $post, $wp_meta_boxes;
				do_meta_boxes( get_current_screen(), 'author_bio', $post );
				unset( $wp_meta_boxes[ get_post_type( $post ) ]['author_bio'] );
			}
		);
	}

	/**
	 *
	 */
	public function register() {

		$this->post_type = new PostType( $this->post_type_key, $this->options, $this->labels );
		$this->setTaxonomies();

		$rewrites   = ResetPermalinks::run();
		$customMeta = TaxCustomField::run();
	}

	/**
	 * @param string $key
	 */
	private function setPostTypeKey( string $key ) {

		$key                 = str_replace( ' ', '-', $key );
		$this->post_type_key = strtolower( $key );
	}

	/**
	 *
	 */
	private function setTaxonomies() {

		$this->post_type->taxonomy( 'culture-mag-edition' );
		$this->post_type->taxonomy( 'post_tag' );

	}

	public function metaboxes( $metaboxes ) {

		$metaboxes[] = array(
			'title'      => __( 'Author Bio', 'cranleigh-2016' ),
			'post_types' => $this->post_type_key,
			'context'    => 'author_bio',
			'priority'   => 'high',
			'fields'     => array(
				array(
					'id'   => 'article_author_bio',
					'name' => 'Author Bio',
					'type' => 'textarea',
				),
			),
		);
		return $metaboxes;
	}

}

<?php
/**
 * Created by PhpStorm.
 * User: fredbradley
 * Date: 26/11/2018
 * Time: 21:04
 */

namespace FredBradley\CranleighCulturePlugin;

class ResetPermalinks {

	public static $post_type_key = 'culture-article';
	public static $taxonomy_key  = 'culture-mag-edition';
	public static $archive_slug  = 'culture';
	public static $taxonomy_slug = 'edition';

	public static function run() {

		add_filter( 'register_post_type_args', [ self::class, 'filter_cpt' ], 11, 2 );
		add_filter( 'register_taxonomy_args', [ self::class, 'filter_tax' ], 11, 3 );
		add_filter( 'post_type_link', [ self::class, 'show_permalink' ], 1, 2 );
	}

	public static function show_permalink( $post_link, $post ) {

		if ( is_object( $post ) && $post->post_type == self::$post_type_key ) {
			$terms = wp_get_object_terms( $post->ID, self::$taxonomy_key );
			if ( $terms ) {
				return str_replace( '%' . self::$taxonomy_key . '%', $terms[0]->slug, $post_link );
			}
		}

		return $post_link;
	}

	public static function filter_tax( $args, $taxonomy, $object_type ) {

		if ( $taxonomy !== self::$taxonomy_key ) {
			return $args;
		}

		$tax_args = [
			'rewrite' => [
				'slug'       => self::$archive_slug,
				'with_front' => true,
			],
		];

		return array_merge( $args, $tax_args );
	}

	public static function filter_cpt( $args, $post_type ) {

		if ( $post_type !== self::$post_type_key ) {
			return $args;
		}

		$cpt_args = [
			'rewrite'     => [
				'slug'       => self::$archive_slug . '/%' . self::$taxonomy_key . '%',
				'with_front' => true,
			],
			'has_archive' => self::$archive_slug,
		];

		return array_merge( $args, $cpt_args );
	}

}

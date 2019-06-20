<?php
/**
 * Created by PhpStorm.
 * User: fredbradley
 * Date: 27/10/2017
 * Time: 08:44
 */

namespace FredBradley\CranleighCulturePlugin;

class Admin {
	public static $post_type_key = 'culture-article';

	public static function run() {
		add_filter( 'manage_edit-' . self::$post_type_key . '_columns', array( self::class, 'edit_columns' ) );
		add_action( 'manage_' . self::$post_type_key . '_posts_custom_column', array( self::class, 'manage_columns' ), 10, 2 );
		add_filter( 'manage_edit-' . self::$post_type_key . '_sortable_columns', array( self::class, 'sortable_columns' ) );
		add_action( 'pre_get_posts', array( self::class, 'order_posts_list' ) );
	}

	public static function order_posts_list( $query ) {
		if ( ! is_admin() ) {
			return;
		}

		$orderby = $query->get( 'orderby' );
		if ( 'expiry' == $orderby ) {
			$query->set( 'meta_key', 'notice_expiry' );
			$query->set( 'orderby', 'meta_value_date' );
		}

	}
	public static function sortable_columns( $columns ) {
		$columns['expiry'] = 'expiry';

		return $columns;
	}

	public static function edit_columns( $columns ) {
		$columns['featured_image'] = 'Feat. Image';
		unset( $columns['wpseo-score'] );
		unset( $columns['wpseo-score-readability'] );
		unset( $columns['wpseo-title'] );
		unset( $columns['wpseo-metadesc'] );
		unset( $columns['wpseo-focuskw'] );
		unset( $columns['wpseo-links'] );
		return $columns;
	}

	public static function manage_columns( $column, $post_id ) {

		switch ( $column ) {
			case 'featured_image':
				echo the_post_thumbnail( 'thumbnail' );
				break;
		}

	}
}

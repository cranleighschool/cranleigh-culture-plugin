<?php
/**
 * Created by PhpStorm.
 * User: fredbradley
 * Date: 27/10/2017
 * Time: 09:07
 */

namespace FredBradley\CranleighCulturePlugin;


class Template {

	public static function run() {

		add_filter( 'template_include', [ self::class, 'select_template' ] );
		add_filter( 'excerpt_length', [ self::class, 'excerpt_length' ], 9999 );
		add_action( 'widgets_init', [ self::class, 'register_sidebar' ] );
		add_action( 'wp_head', [ self::class, 'prefix_filter_og_image_head' ], 10, 1 );
		add_action( 'pre_get_posts', [ self::class, 'setTaxonomyOrder' ] );

		if ( Plugin::setting( 'include-drafts' ) ) {
			add_action( 'pre_get_posts', [ self::class, 'filter_posts' ] );
		}
	}

	public static function excerpt_length( $length ) {

		if ( get_post_type() == 'culture-article' ) {
			return 70;
		}

		return $length;

	}


	public static function setTaxonomyOrder( &$query ) {


		if ( is_tax( 'culture-mag-edition' ) ) {
			$query->set( 'orderby', 'menu_order' );
			$query->set( 'order', 'ASC' );
		}
	}

	public static function prefix_filter_og_image_head( $img ) {

		if ( is_post_type_archive( 'culture-article' ) ) {
			$image       = "https://www.cranleigh.org/wp-content/uploads/2017/10/Thumbnail-Web-Cranleigh-Culture-Magazine.jpg";
			$description = strip_tags( Plugin::setting( 'welcome-paragraph' ) );
			echo '<meta name="og:image" property="og:image" content="' . $image . '" />';
			echo '<meta name="og:description" property="og:description" content="' . $description . '" />';
		}
	}

	public static function filter_posts( $query ) {

		if ( is_post_type_archive( 'culture-article' ) && ! is_admin() ) {
			$query->set( "orderby", [ "menu_order" => "ASC", "date" => "ASC" ] );
			$query->set( 'post_status', [ 'publish', 'draft', 'pending', 'private', 'future' ] );
		}
	}

	public static function select_template( $template ) {

		if ( is_post_type_archive( 'culture-article' ) ) {
			$theme_files     = [ 'archive-culture-article.php', 'culture-article/archive.php' ];
			$exists_in_theme = locate_template( $theme_files, false );
			if ( $exists_in_theme != '' ) {
				return $exists_in_theme;
			} else {
				return plugin_dir_path( dirname( __FILE__ ) ) . 'templates/archive.php';
			}
		} elseif ( is_tax( 'culture-mag-edition' ) ) {
			$theme_files     = [ 'taxonomy-culture-article.php', 'culture-article/taxonomy.php' ];
			$exists_in_theme = locate_template( $theme_files, false );
			if ( $exists_in_theme != '' ) {
				return $exists_in_theme;
			} else {
				return plugin_dir_path( dirname( __FILE__ ) ) . 'templates/taxonomy.php';
			}
		} elseif ( 'culture-article' == get_post_type() ) {
			$theme_files     = [ 'single-culture-article.php', 'culture-article/single.php' ];
			$exists_in_theme = locate_template( $theme_files, false );
			if ( $exists_in_theme != '' ) {
				return $exists_in_theme;
			} else {
				return plugin_dir_path( dirname( __FILE__ ) ) . 'templates/single.php';
			}
		}

		return $template;
	}

	public static function register_sidebar() {

		$sidebar[ "name" ] = "Culture Mag Sidebar";
		$sidebar[ 'id' ]   = "culture-mag";
		register_sidebar(
			wp_parse_args( $sidebar, cranleigh_2016_sidebar_defaults() )
		);
	}

	public static function author_bio( $post_id = null ) {

		if ( $post_id === null ) {
			$post_id = get_the_ID();
		}
		$bio = get_post_meta( $post_id, 'article_author_bio', true );
		if ( ! empty( $bio ) ) {
			echo '<div class="well well-sm author-bio">';
			echo '<h3>' . get_post_meta( $post_id, 'guest-author', true ) . '</h3>';
			echo '<em>';
			echo wpautop( $bio );
			echo '</em>';
			echo '</div>';
		}
	}

}

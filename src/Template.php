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
		add_filter('template_include', array(self::class, 'select_template'));
		add_filter( 'excerpt_length', array(self::class, 'excerpt_length'), 9999 );

		if (Plugin::setting('include-drafts'))
			add_action('pre_get_posts', array(self::class, 'filter_posts'));
	}

	public static function excerpt_length( $length ) {
		if (get_post_type() == 'culture-article') {
			return 70;
		}
		return $length;

	}
	public static function filter_posts($query) {
		if (is_post_type_archive('culture-article') && !is_admin()) {
			$query->set('post_status', ['publish', 'draft', 'pending', 'private', 'future']);
		}
	}
	public static function select_template( $template ) {
		if ( is_post_type_archive('culture-article') ) {
			$theme_files = array('archive-culture-article.php', 'culture-article/theme.php');
			$exists_in_theme = locate_template($theme_files, false);
			if ( $exists_in_theme != '' ) {
				return $exists_in_theme;
			} else {
				return plugin_dir_path(dirname(__FILE__)) . 'templates/archive.php';
			}
		}
		return $template;
	}
}

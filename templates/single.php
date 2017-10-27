<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package cranleigh-2016
 */

get_header();
if (get_post_meta(get_the_ID(), 'cran_hero', true) || in_array(get_post_type( $post ), ["departments", "sport"])) {
	cranleigh_2016_hero_image('slim', $post->post_name);
}
?>
	<div class="container">
		<div class="row">
			<div id="primary" class="col-sm-8 content-area">
				<main id="main" class="site-main" role="main">

					<?php
					cranleigh_breadcrumbs();

					while ( have_posts() ) : the_post();

						?>
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<meta itemprop="sport" content="<?php the_title(); ?>" />
							<meta itemprop="name" content="<?php echo 'Cranleigh '.get_the_title(); ?>" />
							<header class="post-meta">
								<?php
								if ( is_single() ) {
									the_title( '<h1 class="entry-title">', '</h1>' );
								} else {
									the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
								}

								if ( in_array(get_post_type(), ['post', 'landtblog']) ): ?>
									<div class="entry-meta">
										<?php cranleigh_2016_posted_on(); ?>
									</div><!-- .entry-meta -->
									<?php
								endif; ?>
							</header><!-- .entry-header -->
							<?php		cs_quickJump(); ?>

							<div class="entry-content">
								<?php
								echo '<div class="well well-sm author-bio">';
									echo '<h3>'.get_post_meta(get_the_ID(), 'guest-author', true).'</h3>';
									echo '<em>';
									echo wpautop(get_post_meta(get_the_ID(), 'article_author_bio', true));
									echo '</em></div>';
								?>
								<?php
								if (has_post_thumbnail()) {
									$fullsizeurl = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' )[0];
									echo '<a href="' . $fullsizeurl . '">';
									the_post_thumbnail( 'medium', array('class'=>'img-responsive alignright') );
									echo '</a>';
								}
								the_content( sprintf(
								/* translators: %s: Name of current post. */
									wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'cranleigh-2016' ), array( 'span' => array( 'class' => array() ) ) ),
									the_title( '<span class="screen-reader-text">"', '"</span>', false )
								) );

								wp_link_pages( array(
									'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'cranleigh-2016' ),
									'after'  => '</div>',
								) );
								?>
							</div><!-- .entry-content -->
							<?php

							?>
							<footer class="entry-footer">
								<?php cranleigh_2016_entry_footer(); ?>
							</footer><!-- .entry-footer -->
						</article><!-- #post-## -->
						<div class="clear clearfix">&nbsp;</div>

<?php
						cranleigh_2016_keep_reading();

						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;

					endwhile; // End of the loop.
					?>

				</main><!-- #main -->
			</div><!-- #primary -->
			<aside id="secondary" class="col-sm-4 widget-area" role="complementary">
				<?php dynamic_sidebar('culture-mag-sidebar');
				?></aside>
		</div>
	</div>
<?php
get_footer();


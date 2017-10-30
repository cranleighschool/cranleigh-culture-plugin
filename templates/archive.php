<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package cranleigh-2016
 */

use FredBradley\CranleighCulturePlugin\Plugin;
get_header();

	if ( Plugin::setting('admin-only') && !is_user_logged_in() ) {
		echo '<div class="row"><div class="col-md-6 col-md-offset-3">';
		echo '<div class="alert alert-warning"><p>We are undertaking some maintenance to this page. Please try again in a few moments.</p></div>';

		echo '</div></div>';
	} else {
		?>

		<div class="container">
			<div class="row">
				<div id="primary" class="col-sm-12 content-area">
					<main id="main" class="site-main" role="main">

						<?php
						//cranleigh_breadcrumbs();

						if ( have_posts() ) : ?>

						<header class="page-header">
							<?php
							the_archive_title( '<h1 class="page-title text-center">', '</h1>' );
							echo '<div class="row"><div class="col-md-8 col-md-offset-2" style="text-align:justify">';
							echo apply_filters( 'the_content', wpautop( Plugin::setting( 'welcome-paragraph' ) ) );
							echo '</div></div>';
							?>
						</header><!-- .page-header -->

						<h2 class="text-center">Articles from the Magazine</h2>
						<div class="row">
							<div class="col-md-10 col-md-offset-1">
								<?php
								$i = 0;
								while ( have_posts() ): the_post();
									$i ++;
									if ( $i % 2 ) {
										$align_class = "pull-right";
									} else {
										$align_class = null;
									}
									?>
									<article id="culture-article-<?php echo get_the_ID(); ?>" <?php post_class( 'culture-archive' ); ?>>

										<div class="row">
											<div class="col-sm-4 col-md-4 <?php echo $align_class; ?>">
												<a href="<?php the_permalink(); ?>"><?php echo wp_get_attachment_image( get_post_thumbnail_id(),
														'medium', false, [
															"class" => "img-responsive",
															"style" => "margin:auto;"
														] ); ?></a>
											</div>
											<div class="col-sm-8 col-md-8">
												<header class="entry-meta">
													<h3 class="<?php echo $align_class; ?>">
														<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
													</h3>
												</header>

												<div class="entry-content">
													<?php
													echo wpautop( the_excerpt() );
													?>
												</div>
												<footer class="entry-footer">
													<?php //cranleigh_2016_entry_footer(); ?>
												</footer>
											</div>
										</div>

									</article><!-- #edition-<?php the_ID(); ?> -->

									<?php
								endwhile;


								the_posts_navigation();

								wp_reset_postdata();
								wp_reset_query();
								else :

									get_template_part( 'template-parts/content', 'none' );

								endif; ?>
							</div>
						</div>

					</main><!-- #main -->
				</div><!-- #primary -->
			</div>
		</div>

		<?php
	}
get_footer();



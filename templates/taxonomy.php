<?php
/**
 * The template for displaying archive pages.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package cranleigh-2016
 */

use FredBradley\CranleighCulturePlugin\Plugin;

get_header();
$obj = get_queried_object();

if ( \FredBradley\CranleighCulturePlugin\TaxCustomField::hasIssuuEmbed( $obj ) === false && ! is_user_logged_in() ) {
	echo '<div class="container">';
	echo '<div class="row">';
	echo '<div id="primary" class="col-sm-12 content-area">';
	echo '<div id="main" class="site-main" role="main">';
	echo '<header class="page-header">';
	echo '<h1 class="page-title text-center">Cranleigh Culture Magazine: '.$obj->name.'</h1>';
	echo '</header>';
	echo '<div class="alert alert-warning"><p>This edition is not yet published. Please come back soon.</p></div>';
	echo '</main>';
	echo '</div></div></div>';
} else {
	?>

	<div class="container">
		<div class="row">
			<div id="primary" class="col-sm-12 content-area">
				<main id="main" class="site-main" role="main">

					<?php

					if ( have_posts() ) : ?>

					<header class="page-header">
						<?php

						?>
						<h1 class="page-title text-center"><?php echo $obj->name; ?></h1>
						<p class="lead text-center"><?php echo $obj->description; ?></p>
						<?php

						if ( \FredBradley\CranleighCulturePlugin\TaxCustomField::hasIssuuEmbed( $obj ) ) {
							echo \FredBradley\CranleighCulturePlugin\TaxCustomField::getIssuuEmbed( $obj );
						}

						?>

					</header><!-- .page-header -->

					<?php
					if (\FredBradley\CranleighCulturePlugin\TaxCustomField::hasIssuuEmbed($obj) === false) {
						echo '<div class="alert alert-warning">This page is not currently visable to vistors, because you have not published the document on ISSUU and supplied an Embed code. <a href="'.get_edit_term_link($obj->term_id).'">Edit here.</a></div>';
					}
					?>

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



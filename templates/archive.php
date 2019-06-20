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


?>

	<div class="container">
		<div class="row">
			<div id="primary" class="col-sm-12 content-area">
				<main id="main" class="site-main" role="main">

					<?php

					if ( have_posts() ) :
						?>

					<header class="page-header">
						<?php
						the_archive_title( '<h1 class="page-title text-center">', '</h1>' );
						echo '<div class="row"><div class="col-md-8 col-md-offset-2" style="text-align:justify">';
						echo apply_filters( 'the_content', wpautop( Plugin::setting( 'welcome-paragraph' ) ) );
						echo '</div></div>';
						?>
					</header><!-- .page-header -->
					<h2 class="text-center">Editions</h2>
					<div class="row">
						<div class="col-md-8 col-md-offset-2">
							<div class="row">
								<?php
								foreach ( get_terms( 'culture-mag-edition' ) as $edition ) :
									if ( \FredBradley\CranleighCulturePlugin\TaxCustomField::hasIssuuEmbed( $edition ) ) :
										?>
									<div class="col-md-6">
										<div class="card landscape">
											<div class="row">
												<div class="col-xs-12">
													<div class="card-image">
														<?php
														echo \FredBradley\CranleighCulturePlugin\TaxCustomField::getIssuuEmbed( $edition );
														?>
													</div>
												</div>
												<div class="col-xs-12">
													<div class="card-text">
														<a href="
														<?php
														echo get_term_link(
															$edition,
															'culture-mag-edition'
														);
														?>
															">
															<h4 class="text-center" style="padding:10px;"><?php echo $edition->name; ?></h4>
														</a>
														<p style="padding:10px;"><?php echo $edition->description; ?></p>
													</div>
												</div>
											</div>
										</div>
									</div>
									<?php endif; ?>


									<?php
								endforeach;
								?>
							</div>
						</div>
					</div>
					<?php endif; ?>

				</main><!-- #main -->
			</div><!-- #primary -->
		</div>
	</div>

	<?php

	get_footer();



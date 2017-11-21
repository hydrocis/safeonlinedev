<?php /* Template Name: Page Template */ get_header(); ?>

<div id="post">
		<div class="container">
			<div class="row">
				<div class="col-sm-offset-1 col-sm-10 col-xs-12">

		        <?php if (have_posts()): while (have_posts()) : the_post(); ?>

			<!-- article -->
			        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<div class="post-title">
							<h2><?php the_title(); ?></h2>
						</div>


				<?php the_content(); ?>

				<?php comments_template( '', true ); // Remove if you don't want comments ?>

				<br class="clear">

				<?php edit_post_link(); ?>

			</article>
			<!-- /article -->

		<?php endwhile; ?>

		<?php else: ?>

			<!-- article -->
			<article>

				<h2><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h2>

			</article>
			<!-- /article -->

		<?php endif; ?>

		</div>
		
						<!--Sidebar begins here -->
					</div>
				</div>
			</div>


<?php get_footer(); ?>
<?php get_header(); ?>

	<?php if (have_posts()): while (have_posts()) : the_post(); ?>
		<div id="post">
			<div class="container">
				<div class="row">
					<div class="col-sm-9 col-xs-12">
						<article>
							<div class="post-title">
								<h2><?php the_title(); ?></h2>
							</div>

							<div class="context">
								<h4>Background</h4>
								<?php $cc = get_the_excerpt(); print_r($cc); ?>
							</div>

							<?php the_content(); // Dynamic Content ?>
							
							<div class="_comments">
								<?php comments_template(); ?>
							</div>
						</article>

						<div class="readnext">
							<span>Read next article </span>
							<a href="article.html">Backing up phone contacts remotely</a>
							<i class="fa fa-long-arrow-right"></i>
						</div>
					</div>

					<!--Sidebar begins here -->
					<div class="col-sm-3 col-xs-12">
						<?php get_template_part('module-post-summary' ); ?>

						<?php get_template_part('module-post-useful-links' ); ?>

						<?php get_template_part('module-post-videos' ); ?>
					
					</div>
				</div>
			</div>
		</div>
		
		<?php get_template_part('module-related-post' ); ?>

	<?php endwhile; ?>

	<?php else: ?>
		<div id="listing">
		<div class="container">
			<div class="row">
				<div class="col-sm-9">
					<div class="wrapper">
						<div class="empty">
							<i class="fa fa-frown-o" aria-hidden="true"></i>
							<h3>Sorry we don't have anything on this yet. Come back soon</h3>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>

	<?php endif; ?>

<?php get_footer(); ?>

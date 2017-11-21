<?php 
// Check if we have a related post, then continue rendering them
$related = so_get_related_posts( get_the_ID(), 3 );

if( $related->have_posts() ):
                  
?>

<div class="related">
		<div class="container">
			<div class="row">
				<?php  while( $related->have_posts() ): $related->the_post(); ?>
				<div class="col-sm-4">
					<a href="<?php the_permalink(); ?>" onclick="ga('send', 'event', 'Related Post', 'Read', '<?php echo the_title(); ?>', {'nonInteraction': 1});">
						<div class="card">
							<h4><?php echo the_title(); ?></h4>
							<div class="brief">
								<p><?php html5wp_excerpt('html5wp_index'); ?> </p>
							</div>
						</div>
					</a>
				</div>

				<?php endwhile; ?>

		</div>
	</div>
</div>

<?php endif ?>
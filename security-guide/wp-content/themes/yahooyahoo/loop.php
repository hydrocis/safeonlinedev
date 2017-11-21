<?php if (have_posts()): while (have_posts()) : the_post(); ?>
  
  <div class="stub">
    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
      <h3><?php the_title(); ?></h3>
      <div class="brief">
        <p><?php echo get_the_excerpt(); ?></p>
      </div>
    </a>
  </div>
 
<?php endwhile; ?>

<?php else: ?>

	<div class="empty">
    <i class="fa fa-frown-o" aria-hidden="true"></i>
    <h3>Sorry we don't have anything on this yet. Come back soon</h3>
  </div>

<?php endif; ?>
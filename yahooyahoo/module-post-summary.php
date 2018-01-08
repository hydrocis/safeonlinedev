<?php if (get_field('summary')) {//if(get_post_meta($post->ID, 'summary', true)) {  ?>

  <div class="summary">
    <div class="title">
      <p>Summary steps</p>
    </div>
    <div class="points">
      <?php //echo get_field('steps_summary'); ?>
      <?php echo the_field('summary'); //get_post_meta($post->ID, 'summary', true); ?>
    </div>
  </div>

<?php } ?>

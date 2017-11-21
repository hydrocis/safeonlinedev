<?php if(get_field('useful_links')) {  ?>

  <div class="links">
    <div class="title">
      <p>Useful links</p>
    </div>
    <div class="points">
      <?php //echo get_field('useful_links'); ?>
      <?php echo the_field('useful_links'); ?>
    </div>
  </div>

<?php } ?>

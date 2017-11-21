<?php if(get_field('useful_links')) { ?>

  <div class="links">
    <div class="title">
      <h4><i class="fa fa-cloud-download"></i>Useful links</h4>
    </div>
    <div class="points">
      <?php echo get_field('useful_links'); ?>
    </div>
  </div>

<?php } ?>

<?php if(get_field('steps_summary')) { ?>

  <div class="summary">
    <div class="title">
      <h4>Summary steps!</h4>
    </div>
    <div class="points">
      <?php echo get_field('steps_summary'); ?>
    </div>
  </div>

<?php } ?>


<?php
$exclude = get_cat_ID('videos');
$categories = get_categories('hide_empty=0&exclude='.$exclude);
$color = ['one', 'two', 'three', 'four', 'five', 'six', 'one', 'two', 'three', 'four', 'five', 'six'];

foreach ($categories as $cat => $value) { ?>

<div class="col-sm-4">
  <div class="category-card">
    <a href="<?php echo $value->category_nicename; ?>">
      <div class="content">
        <div class="count"><span><?php echo $value->category_count; ?></span> Articles</div>
        <h2><?php echo $value->cat_name ?></h2>
      </div>

      <div class="bottom-bar <?php echo $color[$cat] ?>"></div>      
      
      
    </a>
  </div>
</div>

<?php } ?>
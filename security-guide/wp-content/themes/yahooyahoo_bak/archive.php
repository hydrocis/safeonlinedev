<?php get_header(); ?>
  <div class="header-category">
    <div class="container">
      <div class="row">
        <div class="col-sm-12 col-xs-12">
          <div class="head-title">
            <?php
              the_archive_title( '<h1 style="text-transform:capitalize;">', '</h1>' );
              the_archive_description( '<span>', '</span>' );
            ?>
            
          </div>
        </div>
      </div>
    </div>
  </div>



  <div id="listing">
    <div class="container">
      <div class="row">
        <div class="col-sm-9">
          <div class="wrapper">
            <?php get_template_part('loop'); ?>
            <?php get_template_part('pagination'); ?>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php get_footer(); ?>

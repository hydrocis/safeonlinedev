<?php get_header(); ?>
    
   <?php $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); ?>

  <div class="header-category">
    <div class="container">
      <div class="row">
        <div class="col-sm-12 col-xs-12">
          <div class="head-title">
            <h1><?php echo $term->name; ?></h1>
            <span><?php echo $term->description; ?></span>
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
          </div>

        </div>
      </div>
    </div>
  </div>

<?php get_footer(); ?>
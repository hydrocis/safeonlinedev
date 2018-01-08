<?php get_header(); ?>

 <div class="header-category">
    <div class="container">
      <div class="row">
        <div class="col-sm-12 col-xs-12">
          <div class="head-title">
            
             <?php
                the_archive_title( '<h2 style="text-transform:capitalize;">', '</h2>' );
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

  <div id="category">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="_title">
                        <h4>Select another category below</h4>
                    </div>
                </div>
                <!-- <div class="col-sm-4">
                    <div class="category-card">
                        <a href="">
                            <div class="content">
                                <div class="count"><span>21</span> Articles</div>
                                <h2>Device Security</h2>
                            </div>
                            <div class="bottom-bar one"></div>
                        </a>
                    </div>
                </div> -->
                <?php get_template_part('module-list-categories'); ?>

            </div>
        </div>
    </div>
  
<?php get_footer(); ?>

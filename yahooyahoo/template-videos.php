<?php /* Template Name: Video Template */ get_header(); ?>
	
<div class="header-category">
<div class="container">

    <div class="row">
        <div class="col-sm-12 col-xs-12">
            <div class="head-title">
                <h1>Videos</h1>
                <span>Information you need right now to secure your social accounts from identity theft related threats</span>
            </div>
        </div>
    </div>
</div>
</div>

<div id="video-listing">
		<div class="container">
			<h3>All videos</h3>
			<div class="row">
				<!-- <div class="col-sm-3">
					<div class="video-thumb">
						<a href="videos-single.html"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/thumb1.jpg" alt="">
							<span class="title">How to encrypt data on your computer</span>
							<span class="duration">Duration:  23:21</span>
						</a>
					</div>
                </div> -->
                
                
                <?php echo do_shortcode('[fancygallery id="2"]'); ?>

			</div>
		</div>
	</div>



<div class="clearfix"></div>


<?php get_footer(); ?>



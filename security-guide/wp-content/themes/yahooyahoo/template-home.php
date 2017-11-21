<?php /* Template Name: Home Page Template */ get_header(); ?>
	
	<div id="user-roles">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<h4>I want to be safe online. I am:</h4>
					<div class="wrap">
						<?php get_template_part('home-link-profile'); ?>
						<!-- <ul>
							<li><a href="article-list.html">an NGO</a></li>
							<li><a href="article-list.html">a journalist</a></li>
							<li><a href="article-list.html">a blogger</a></li>
							<li><a href="article-list.html">a developer</a></li>
							<li><a href="article-list.html">a human rights activist</a></li>
						</ul> -->
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
						<h4>Select a category to start with</h4>
					</div>
				</div>
				<?php get_template_part('module-homepage-categories'); ?>
				
			</div>
		</div>
	</div>

	<div id="scenario">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<div class="_title">
						<h4>Choose a scenario that applies to you</h4>
					</div>
				</div>
				<div class="clearfix"></div>
				<div class="scenario-wrap">
					<?php
					// your taxonomy name
					$tax = 'scenario';

					// get the terms of taxonomy
					$terms = get_terms( $tax, $args = array(
					  'hide_empty' => false, // do not hide empty terms
					));
        ?>

				
					<?php foreach( $terms as $term ) { 
						$term_link = get_term_link($term);

					?>
					<?php if( $term->count > 0 ) ?>

					<div class="scenario-card">
						<a href="<?php echo esc_url($term_link); ?>">

							<h2><?php echo $term->name; ?></h2>
							<p><?php echo $term->description; ?></p>
							<div class="count"><span><?php echo $term->count ?></span> Articles</div>
						</a>
					</div>

					<?php } ?>

				</div>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>


<?php get_footer(); ?>

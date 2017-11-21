<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
    <meta charset="utf-8">
    <meta name="description" content="SafeOnline | Find out ways to secure your self against perils that come with being connected to the global community">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="cache-control" content="max-age=0" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="expires" content="0" />
    <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
    <meta http-equiv="pragma" content="no-cache" />
    <meta http-equiv="cache-control" content="max-age=0" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="expires" content="0" />
    <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
    <meta http-equiv="pragma" content="no-cache" />


    <!-- OpenGraph for Facebook. -->
    <meta property="og:type" content="website" />
    <meta property="og:title" content="<?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?>" />
    <meta property="og:url" content="https://www.safeonline.ng" />
    <meta property="og:description" content="<?php bloginfo('description'); ?>" />
    <meta property="og:image" content="http://safeonline.ng/img/social-media.jpg" />
    <meta property="og:locale" content="en_US" />
    <!-- Twitter Cards -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@cc_hub">
    <meta name="twitter:title" content="<?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?>">
    <meta name="twitter:description" content="<?php bloginfo('description'); ?>">
    <meta name="twitter:image:src" content="http://safeonline.ng/img/social-media.jpg">


    <title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>

		<link href="//www.google-analytics.com" rel="dns-prefetch">
    
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo get_template_directory_uri(); ?>/img/icons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo get_template_directory_uri(); ?>/img/icons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo get_template_directory_uri(); ?>/img/icons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo get_template_directory_uri(); ?>/img/icons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo get_template_directory_uri(); ?>/img/icons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo get_template_directory_uri(); ?>/img/icons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo get_template_directory_uri(); ?>/img/icons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo get_template_directory_uri(); ?>/img/icons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri(); ?>/img/icons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo get_template_directory_uri(); ?>/img/icons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_template_directory_uri(); ?>/img/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo get_template_directory_uri(); ?>/img/icons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_template_directory_uri(); ?>/img/icons/favicon-16x16.png">
    <link rel="manifest" href="<?php echo get_template_directory_uri(); ?>/img/icons/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/img/icons/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">


		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="<?php bloginfo('description'); ?>">

		<?php wp_head(); ?>

	</head>
	<body>
  <div class="particle-wrap">
    <div class="count-particles">
      <span class="js-count-particles"></span>
    </div>
  </div>
  <?php if (is_singular()) { ?>
  <header class="article-header">
  <?php } else { ?>
  <header>
  <?php } ?>
  
    <div id="nav">
      <div class="container">
        <div class="row">
          <div class="col-sm-3 col-xs-4 ">

            <div class="logo">
              <a href="<?php echo home_url(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.png" alt=""></a>
            </div>
          </div>
          <div class="col-sm-5 col-xs-12 pull-right header-navigation">
            <?php wp_nav_menu( array( 'theme_location' => 'header-menu' ) ); ?>

          </div>
        </div>
      </div>
    </div>
  </header>

  <?php if ( is_front_page() || is_home() ) { ?>

    
    <div id="header-blurb">
      <div class="container">
        <div class="row">
          <div class="col-sm-5"></div>
          <div class="col-sm-7">
            <div class="blurb">
              <h1>SafeOnline</h1>
              <p>The SafeOnline guide is an actionable guide to educate citizen groups on simple steps to protect their privacy online, to secure the intergrity of their web properties and to respond in the event of malicious attacks.</p>
              <a class="blue_btn" href="">Explore the guide</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php } ?>
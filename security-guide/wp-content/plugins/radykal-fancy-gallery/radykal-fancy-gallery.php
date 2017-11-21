<?php
/*
Plugin Name: Fancy Gallery (radykal)
Plugin URI: http://codecanyon.net/item/fancy-gallery-wordpress-plugin/400535
Description: Create your own galleries with unlimited of albums. You can upload different types of media. Use the generator for external usage of a gallery.
Version: 2.3.4
Author: Rafael Dery
Author URI: http://codecanyon.net/user/radykal
*/


if (!defined('FG_PLUGIN_DIR'))
    define( 'FG_PLUGIN_DIR', dirname(__FILE__) );

if (!defined('FG_ADDON_DIR'))
	define( 'FG_ADDON_DIR', dirname(__FILE__).'/addons' );

if (!defined('FG_DIR'))
	define( 'FG_DIR', WP_CONTENT_DIR.'/uploads/fancygallery_dir' );

if(!class_exists('FancyGallery')) {
	class FancyGallery {

		private $wpdb;
		private $version = '2.3.4';
		private $version_field_name = 'fancygallery_version';
		private $default_options;
		private $maximum_filesize;
		public $content_dir;
		public $gallery_table_name;
		public $album_table_name;
		public $images_table_name;

		const CAPABILITY = "edit_fancy_galleries";
		const DEMO = false;

		public static $add_script = false; //loads the core js files
		public static $add_pp_script = false; //loads prettyphoto js files
		public static $add_fb_script = false; //loads fancybox js files
		public static $add_inline_script = false; //loads inline js files

	    public function __construct() {

			global $wpdb;

			$this->maximum_filesize = 1024 * 10000; //Maximum upload size in MB, default 10MB

			//set table option names
			$this->wpdb = $wpdb;
			$this->gallery_table_name = $wpdb->prefix . "fg_gallery";
			$this->album_table_name = $wpdb->prefix . "fg_album";
			$this->images_table_name = $wpdb->prefix . "fg_media";

			$this->default_options = array(//layout
										   'background_color' => '#F5F5F5',
			                               'border_color' => '#bdc3c7',
										   'thumbnail_width' => 200,
										   'thumbnail_height' => 150,
										   'thumbnails_per_page' => 8,
										   'thumbnail_zc' => 1,
										   'border_thickness' => 3,
										   'row_offset' => 50,
										   'column_offset' => 30,
										   'shadow_offset' => 0,
										   'shadow_image' => plugins_url('/images/fancygallery/shadows/shadow1.png', __FILE__),
										   'nav_position' => 'bottom',
										   'theme' => 'white',
										   'select_album' => '',
										   'all_medias_selector' => '',
										   'album_selection' => 'dropdown',
										   'navigation' => 'arrows',
										   'nav_alignment' => 'left',
										   'nav_previous_text' => '<',
										   'nav_next_text' => '>',
										   'nav_back_text' => '&crarr;',
										   'columns' => 0,
										   'media_label' => 'Media',
										   'show_only_first_thumbnail' => 0,
										   'album_description_position' => 'top',
										   'title_placement' => 'outside',
										   'title_options_background' => '#F5F5F5',
										   'title_options_color' => '#2C3E50',
										   'title_options_stretchToWidth' => 1,
										   //hover effects
										   'thumbnail_hover_effect' => 'fadeIn',
										   'title_hover_effect' => 'slide',
										   'fadeIn_opacity' => 0.6,
										   'fadeOut_opacity' => 0.6,
										   'filter_type' => 'grayscale',
										   'filter_reverse' => 0,
										   'icon_url' => plugins_url('/images/fancygallery/hover_icons/circle-magnifier_32x32.png', __FILE__),
										   'icon_transition' => 'fade',
										   'slide_overflow' => 0,
										   'scale_overflow' => 0,
										   'scale_direction' => 'down',
										   'overlay_opacity' => 0.6,
										   'overlay_background_color' => '#ffffff',
										   //gallery options
										   'gallery' => 'prettyphoto',
										   'prettyphoto_theme' => 'pp_default',
										   'prettyphoto_overlay' => 1,
										   'prettyphoto_image_resize' => 1,
										   'prettyphoto_slideshow' => 0,
										   'fancybox_width' => 800,
										   'fancybox_height' => 600,
										   'fancybox_padding' => 15,
										   'fancybox_margin' => 20,
										   'fancybox_autoplay' => 0,
										   'fancybox_arrows' => 1,
										   'fancybox_loop' => 1,
										   'fancybox_buttons_position' => 'none',
										   'fancybox_thumbs_position' => 'none',
										   'fancybox_open_effect' => 'fade',
										   'fancybox_close_effect' => 'fade',
										   'fancybox_next_effect' => 'elastic',
										   'fancybox_previous_effect' => 'elastic',
										   'inline_gallery_width' => '100%',
										   'inline_gallery_height' => 500,
										   'inline_gallery_youtube_parameters' => '&showinfo=1&autoplay=1',
										   'inline_gallery_vimeo_parameters' => 'autoplay=1',
										   'inline_gallery_show_first_media' => 0,
										   'thumbnail_selection_layout' => 'default',
										   'thumbnail_selection_width' => 250,
										   'thumbnail_selection_height' => 150,
										   'thumbnail_selection_albumsPerPage' => 0,
										   'none_gallery_target_window' => '_blank',
										   'facebook_like_button' => 1,
										   'tweet_button' => 1,
										   'pin_it_button' => 1
									    );

			if(is_multisite()) {
				global $blog_id;
				if (isset($blog_id) && $blog_id > 1) {
					$this->content_dir = WP_CONTENT_DIR . "/blogs.dir/" .$blog_id . "/fancygallery";
				}
				else {
					$this->content_dir = WP_CONTENT_DIR . "/fancygallery";
				}
			}
			else {
				$this->content_dir = WP_CONTENT_DIR . "/fancygallery";
			}



		}

		public function init() {

			require_once(FG_PLUGIN_DIR . '/widgets.php');

			//create fancygallery directory in uploads
			if(!file_exists(FG_DIR)) {
				wp_mkdir_p(FG_DIR);
			}

			//activation and actions
            register_activation_hook(  __FILE__, array( &$this, 'activate_plugin' ) );
			//Uncomment this line to delete all database tables when deactivating the plugin
            //register_deactivation_hook( __FILE__, array( &$this,'deactive_plugin' ) );

			//action hooks
			add_action( 'wpmu_new_blog', array( &$this, 'new_blog'), 10, 6);
			add_action( 'init', array( &$this,'init_plugin' ) );
			add_action( 'admin_init', array( &$this,'init_admin' ) );
			add_action( 'plugins_loaded', array( &$this,'check_version' ) );
			add_action( 'wp_enqueue_scripts',array( &$this,'enqueue_styles' ) );
			add_action( 'wp_footer', array(&$this, 'enqueue_scripts') );
			add_action( 'admin_menu', array( &$this,'add_menu_pages' ) );
			add_action( 'admin_enqueue_scripts', array( &$this, 'enqueue_admin_styles_scripts') );
			add_action( 'widgets_init', create_function( '', 'return register_widget("FancyGalleryListWidget");' ) );
			add_action( 'widgets_init', create_function( '', 'return register_widget("FancyGalleryAlbumWidget");' ) );
			add_action( 'widgets_init', create_function( '', 'return register_widget("FancyGalleryMediaWidget");' ) );

			//include addons
			if(file_exists(FG_PLUGIN_DIR . '/gallery_shortcode.php')) {
				require_once(FG_PLUGIN_DIR . '/gallery_shortcode.php');
			}
			if(file_exists(FG_ADDON_DIR . '/gallery-shortcode/gallery-shortcode-addon.php')) {
				require_once(FG_ADDON_DIR . '/gallery-shortcode/gallery-shortcode-addon.php');
			}
			if(file_exists(FG_ADDON_DIR . '/nextgen/nextgen-addon.php')) {
				require_once(FG_ADDON_DIR . '/nextgen/nextgen-addon.php');
			}
			if(file_exists(FG_ADDON_DIR . '/tools/tools-addon.php')) {
				require_once(FG_ADDON_DIR . '/tools/tools-addon.php');
			}


			//filter hooks
            add_filter('widget_text', 'do_shortcode');

			//shortcodes
	        add_shortcode('fancygallery', array($this,'add_fancyGallery'));
	        add_shortcode('fancygallery_dir', array($this,'add_fancyGallery_dir'));

		}

		public function new_blog($blog_id, $user_id, $domain, $path, $site_id, $meta ) {

			if ( ! function_exists( 'is_plugin_active_for_network' ) )
				require_once( ABSPATH . '/wp-admin/includes/plugin.php' );

		    global $wpdb;

		    if (is_plugin_active_for_network('radykal-fancy-gallery/radykal-fancy-gallery.php')) {
		        $old_blog = $wpdb->blogid;
		        switch_to_blog($blog_id);
		        $this->activate_plugin();
		        switch_to_blog($old_blog);
		    }

		}

		public function init_plugin() {

			load_plugin_textdomain('radykal', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/');

		}

		public function init_admin() {

			// get value for safe mode
			if( !defined('SAFE_MODE') ) {
				if ( (gettype( ini_get('safe_mode') ) == 'string') ) {
					if ( ini_get('safe_mode') == 'off' ) define('SAFE_MODE', FALSE);
					else define( 'SAFE_MODE', ini_get('safe_mode') );
				} else
				define( 'SAFE_MODE', ini_get('safe_mode') );
			}

			//action hooks for the admin
			add_action( 'wp_ajax_newgallery', array( &$this, 'new_gallery' ) );
			add_action( 'wp_ajax_editgallery', array( &$this, 'edit_gallery' ) );
			add_action( 'wp_ajax_deletegallery', array( &$this, 'delete_gallery' ) );
			add_action( 'wp_ajax_newalbum', array( &$this, 'new_album' ) );
			add_action( 'wp_ajax_editalbum', array( &$this, 'edit_album' ) );
			add_action( 'wp_ajax_editalbumdescription', array( &$this, 'edit_album_description' ) );
			add_action( 'wp_ajax_deletealbum', array( &$this, 'delete_album' ) );
			add_action( 'wp_ajax_updatealbums', array( &$this, 'update_albums' ) );
			add_action( 'wp_ajax_loadfiles', array( &$this, 'load_files' ) );
			add_action( 'wp_ajax_uploadfile', array( &$this, 'upload_file' ) );
			add_action( 'wp_ajax_savefile', array( &$this, 'save_file' ) );
			add_action( 'wp_ajax_deletefiles', array( &$this, 'delete_files' ) );
			add_action( 'wp_ajax_updatefiles', array( &$this, 'update_files' ) );
			add_action( 'wp_ajax_updatemedia', array( &$this, 'update_media' ) );
			add_action( 'wp_ajax_editalbumthumbnail', array( &$this, 'edit_album_thumbnail' ) );
			add_action( 'wp_ajax_editmediatitle', array( &$this, 'edit_media_title' ) );


			wp_register_script('ajax-utils', plugins_url('/admin/js/ajax-utils.js', __FILE__));

			$role = get_role( 'administrator' );
			$role->add_cap( FancyGallery::CAPABILITY );

		}

		public function check_version() {

			if( get_option($this->version_field_name) != $this->version)
			    $this->upgrade();
		}

		public function activate_plugin($networkwide) {

		   if(version_compare(PHP_VERSION, '5.2.0', '<')) {
			  deactivate_plugins(plugin_basename(__FILE__)); // Deactivate plugin
			  wp_die("Sorry, but you can't run this plugin, it requires PHP 5.2 or higher.");
			  return;
			}

			global $wpdb;

			if ( is_multisite() ) {
	    		if (isset($_GET['networkwide']) && ($_GET['networkwide'] == 1)) {
	                $current_blog = $wpdb->blogid;
	    			// Get all blog ids
	    			$blogids = $wpdb->get_col($wpdb->prepare("SELECT blog_id FROM $wpdb->blogs"));
	    			foreach ($blogids as $blog_id) {
	    				switch_to_blog($blog_id);
	    				$this->install();
	    			}
	    			switch_to_blog($current_blog);
	    			return;
	    		}
	    	}

			$this->install();

		}

		public function deactive_plugin($networkwide) {

			global $wpdb;

		    if (is_multisite()) {
		        if ($networkwide) {
		            $old_blog = $wpdb->blogid;
		            // Get all blog ids
		            $blogids = $wpdb->get_col($wpdb->prepare("SELECT blog_id FROM $wpdb->blogs"));
		            foreach ($blogids as $blog_id) {
		                switch_to_blog($blog_id);
		                $this->deinstall();
		            }
		            switch_to_blog($old_blog);
		            return;
		        }
		    }

		    $this->deinstall();

		}

		public function add_menu_pages() {

			//create own admin menu with subs
			add_menu_page( 'Fancy Gallery', 'Fancy Gallery',  FancyGallery::CAPABILITY, 'fancy-gallery', array($this, 'manage_galleries_admin_page'), plugins_url('/admin/images/menu_icon.png', __FILE__) );
			add_submenu_page( 'fancy-gallery', __('Manage galleries', 'radykal'), __('Manage galleries', 'radykal'),  FancyGallery::CAPABILITY, 'fancy-gallery', array($this, 'manage_galleries_admin_page') );
			add_submenu_page( 'fancy-gallery', __('Options', 'radykal'), __('Options', 'radykal'),  FancyGallery::CAPABILITY, 'fancy-gallery-options', array($this, 'options_admin_page') );

		}

		public function enqueue_admin_styles_scripts( $hook ) {

			//enqueue css and js for Manage galleries page
			if($hook == 'toplevel_page_fancy-gallery') {

				//enqueue media uploader
				if(function_exists('wp_enqueue_media'))
					wp_enqueue_media();

				//enqueue scripts
				$nonce = wp_create_nonce( 'fg-upload-nonce' );


				wp_enqueue_script('jquery-iframe-transport', plugins_url('/admin/js/jquery.iframe-transport.js', __FILE__), array('jquery', 'jquery-ui-core', 'jquery-ui-widget', 'jquery-ui-mouse', 'jquery-ui-sortable', 'wp-ajax-response', 'ajax-utils'));
				wp_enqueue_script('jquery-file-upload', plugins_url('/admin/js/jquery.fileupload.js', __FILE__));
				wp_enqueue_script('fg-manage-galleries', plugins_url('/admin/js/manage-galleries.js', __FILE__) );


				$content_url = content_url();
				if(is_multisite()) {
					global $blog_id;
					if (isset($blog_id) && $blog_id > 1) {
						$blog_details = get_blog_details(1);
						$content_url = $blog_details->siteurl . "/wp-content/blogs.dir/" .$blog_id;
					}
				}
				wp_localize_script('fg-manage-galleries', 'options', array( 'uploadNonce' => $nonce, 'Ajax_Url' => admin_url( 'admin-ajax.php'), 'adminUrl' => plugins_url("admin", __FILE__), 'contentUrl' => $content_url ));
			}
			//enqueue css and js for Options page
			else if($hook == 'fancy-gallery_page_fancy-gallery-options') {
				//enqueue media uploader
				if(function_exists('wp_enqueue_media'))
					wp_enqueue_media();

				//enqueue styles
				wp_enqueue_style('fg-colorpicker', plugins_url('/admin/css/spectrum.css', __FILE__));

				//enqueue scripts
				wp_enqueue_script('fg-bootstrap', plugins_url('/admin/bootstrap/js/bootstrap.min.js', __FILE__));
				wp_enqueue_script('fg-colorpicker', plugins_url('/admin/js/spectrum.js', __FILE__));
				wp_enqueue_script('fg-options', plugins_url('/admin/js/options.js', __FILE__), array('jquery', 'media-upload','thickbox'), $this->version);
			}

			if (strpos($hook,'fancy-gallery') !== false) {

				wp_enqueue_style( 'fg-bootstrap', plugins_url('/admin/bootstrap/css/bootstrap.css', __FILE__) );
				wp_enqueue_style('fg-admin', plugins_url('/admin/css/admin.css', __FILE__), array('thickbox'), $this->version);
				wp_enqueue_script('fg-bootstrap', plugins_url('/admin/bootstrap/js/bootstrap.min.js', __FILE__));
				wp_enqueue_script('fg-admin', plugins_url('/admin/js/admin.js', __FILE__) );
			}

		}

		public function manage_galleries_admin_page() {
			require_once(FG_PLUGIN_DIR . '/admin/manage-galleries.php');
		}

		public function options_admin_page() {

			//save options for gallery
			if(isset($_POST['fg_opts_save']) || isset($_POST['fg_generate_code']) || !empty($_POST['overwrite_gallery'])){

				if( isset($_POST['fg_opts_save']) ) {
					//enable general options
					if(isset($_POST['enable_general_options'])) {
						update_option( 'fg_general_options_name', $_POST['selected_gallery'] );
					}
					else if( $_POST['selected_gallery'] == get_option( 'fg_general_options_name' ) ) {
						//disable general options
						if( !isset($_POST['enable_general_options']) )
							delete_option( 'fg_general_options_name' );
					}
				}

				//overwrite options with another one
				if( !empty($_POST['overwrite_gallery']) ) {
					$_POST['selected_gallery'] = $_POST['overwrite_gallery'];
				}

				$new_opts;

				foreach($this->default_options as $key => $value) {
					$new_opts[$key] = $_POST[$key] === null ? 0 : $_POST[$key];
				}

				if( !isset($_POST['fg_generate_code']) ) {
					$this->wpdb->update( $this->gallery_table_name, array('options' => serialize($new_opts) ), array('ID'=> $_POST['selected_gallery']), array('%s') );
				}
				$options = $new_opts;

			}
			//reset options
			else if(isset($_POST['fg_opts_reset'])) {

				$this->wpdb->update( $this->gallery_table_name, array('options' => serialize($this->default_options) ), array('ID'=> $_POST['selected_gallery']), array('%s') );
				$options = $this->default_options;

			}
			//dropdown changed
			else if(isset($_POST['selected_gallery'])) {
				$requested_gallery_opts = $this->wpdb->get_results('SELECT options FROM '.$this->gallery_table_name.' WHERE ID="'.$_POST['selected_gallery'].'" LIMIT 1');
			    $options = unserialize($requested_gallery_opts[0]->options);
			}
			else {
				$first_gallery_opts = $this->wpdb->get_results('SELECT options FROM '.$this->gallery_table_name.' ORDER BY title LIMIT 1');
			    $options = unserialize($first_gallery_opts[0]->options);

			}

			//check if options is an array
			if(!is_array($options)) {
				$options = $this->default_options;
			}

			$options = $this->check_options_availability($options);
			//reset options
			if(isset($_POST['fg_generate_code'])) {
				require_once(FG_PLUGIN_DIR . '/admin/generate-code.php');
			}
			else {
				require_once(FG_PLUGIN_DIR . '/admin/options.php');
			}



		}

		public function add_fancyGallery( $atts ) {

			self::$add_script = true;

			$selectAlbum = '';
			if( isset( $_GET['album']) )
			    $selectAlbum = $_GET['album'];

			extract( shortcode_atts( array(
				'id' => '',
				'album' => '',
				'columns' => 0
			), $atts ) );

			//get albums of the gallery corresponding to the ID
			if(empty($album)) {
				$selector = 'fancygallery-'.$id;
				$albums = $this->wpdb->get_results("SELECT * FROM {$this->album_table_name} WHERE gallery_id='$id' ORDER BY sort ASC");
			}
			else {
				$selector = 'fancygallery-'.$id.'-'.$album;
				$albums = $this->wpdb->get_results("SELECT * FROM {$this->album_table_name} WHERE gallery_id='$id' && ID='$album'");
			}

			//check if gallery exists and has albums
			if(sizeof($albums) == 0)
				return sprintf(__('<p class="fg-error"><strong>Fancy Gallery Error:</strong><br />No gallery with the ID %s was found or you have not created albums for it yet.</p>', 'radykal'), $id);

			//get options for gallery
			if( get_option('fg_general_options_name') ) {
				$options_id = get_option('fg_general_options_name');
				$options = $this->wpdb->get_results("SELECT options FROM {$this->gallery_table_name} WHERE ID='$options_id'");
			}
			else {
				$options = $this->wpdb->get_results("SELECT options FROM {$this->gallery_table_name} WHERE ID='$id'");
			}

			$options = unserialize($options[0]->options);

			//check if options is an array, fallback
			if(!is_array($options)) {
				$options = $this->default_options;
			}

			//check if columns value is set via an attribute
			if( $columns > 0 ) {
				$options['columns'] = $columns;
			}

			//add necessary scripts
			switch($options['gallery']) {
				case 'prettyphoto':
					self::$add_pp_script = true;
				break;
				case 'fancybox':
					self::$add_fb_script = true;
				break;
				case 'inline':
					self::$add_inline_script = true;
				break;
			}

			//custom thumbnail size for thumbnails selection
			if($options['album_selection'] == 'thumbnails') {

				if($options['thumbnail_selection_layout'] == 'default') {
					$thumbnails_selection_width = $options['thumbnail_selection_width'];
					$thumbnails_selection_height = $options['thumbnail_selection_height'];
				}
				else if($options['thumbnail_selection_layout'] == 'polaroid') {
					$thumbnails_selection_width = 151;
					$thumbnails_selection_height = 151;
				}

			}

			//html output
			ob_start();
			?><div id="<?php echo $selector; ?>" class="fg-panel" >
				<?php foreach($albums as $album) :
					$thumbnail = '';
					if($album->thumbnail && $options['album_selection'] == 'thumbnails') {
						$thumbnail = plugins_url('/admin/timthumb.php', __FILE__).'?src='.urlencode($album->thumbnail).'&w='.$thumbnails_selection_width.'&h='.$thumbnails_selection_height.'&zc=1&q=100';
					}
				?>
				<div title="<?php echo stripslashes($album->title); ?>" data-thumbnail="<?php echo $thumbnail; ?>"><?php
					$album_files = $this->wpdb->get_results("SELECT * FROM {$this->images_table_name} WHERE album_id='$album->ID' ORDER BY sort ASC");
					if($album->description) { echo '<div>'.stripslashes(htmlspecialchars_decode($album->description)).'</div>'; }
					foreach($album_files as $album_file) {
						echo $this->get_media_link($album_file->file, $album_file->thumbnail, $options['thumbnail_width'], $options['thumbnail_height'], $options['thumbnail_zc'], $album_file->title, $album_file->description);
					}
					?></div><?php endforeach; ?></div>
			<?php

			//js output
			$options = $this->check_options_availability($options);
			echo $this->get_js_code($options, $selector, $selectAlbum);

			$output_gallery = ob_get_contents();
			ob_end_clean();

			return $output_gallery;
		}

		public function add_fancyGallery_dir( $atts ) {

			self::$add_script = true;

			extract( shortcode_atts( array(
				'gallery_dir' => '',
				'album_dir' => '',
				'columns' => 0,
				'gallery_options' => ''
			), $atts ) );

			//get albums
			$albums = array();

			//get albums from gallery
			if(empty($album_dir)) {
				//check if gallery directory exists
				if( !is_dir(FG_DIR.'/'. $gallery_dir) ) {
					return '<p class="fg-error">'.sprintf(__('The gallery directory "%s" does not exist!', 'radykal'), $gallery_dir).'</p>';
				}
				else {
					//read gallery dir
					$gallery_directory_entries = scandir(FG_DIR.'/'.$gallery_dir);
					//get all albums dir from gallery dir
					$album_directories = glob(FG_DIR.'/'.$gallery_dir . '/*' , GLOB_ONLYDIR);

					//loop through all albums dirs
					foreach($album_directories as $album_directory) {
					    if( is_dir($album_directory) ) {
					    	$images = $this->_scan_album_dir($album_directory);
					    	$albums[basename($album_directory)] = $images;
					    }
					}
				}
			}
			//get single album
			else {
				//check if album directory exists
				if( !is_dir(FG_DIR.'/'. $gallery_dir . '/'. $album_dir) ) {
					return '<p class="fg-error">'.sprintf(__('The gallery "%s" or album directory "%s" does not exist!', 'radykal'), $gallery_dir, $album_dir).'</p>';
				}
				else {
					$images = $this->_scan_album_dir(FG_DIR.'/'. $gallery_dir . '/'. $album_dir);
					$albums[$album_dir] = $images;
				}

			}

			//get options for gallery
			if( get_option('fg_general_options_name') ) {
				$options_id = get_option('fg_general_options_name');
				$options = $this->wpdb->get_results("SELECT options FROM {$this->gallery_table_name} WHERE ID='$options_id'");
			}
			else {
				$options = $this->wpdb->get_results("SELECT options FROM {$this->gallery_table_name} WHERE title='$gallery_options'");
			}
			$options = unserialize($options[0]->options);

			//check if options is an array, fallback
			if(!is_array($options)) {
				$options = $this->default_options;
			}

			//check if columns value is set via an attribute
			if( $columns > 0 ) {
				$options['columns'] = $columns;
			}

			//add necessary scripts
			switch($options['gallery']) {
				case 'prettyphoto':
					self::$add_pp_script = true;
				break;
				case 'fancybox':
					self::$add_fb_script = true;
				break;
				case 'inline':
					self::$add_inline_script = true;
				break;
			}

			//custom thumbnail size for thumbnails selection
			if($options['album_selection'] == 'thumbnails') {

				if($options['thumbnail_selection_layout'] == 'default') {
					$thumbnails_selection_width = $options['thumbnail_selection_width'];
					$thumbnails_selection_height = $options['thumbnail_selection_height'];
				}
				else if($options['thumbnail_selection_layout'] == 'polaroid') {
					$thumbnails_selection_width = 151;
					$thumbnails_selection_height = 151;
				}

			}

			$selector = $gallery_dir;
			if( !empty($album_dir) )
				$selector .= '-'.basename($album_dir);

			$selector = sanitize_title($selector);

			//html output
			ob_start();
			?><div id="<?php echo $selector; ?>" class="fg-panel" >
				<?php foreach($albums as $key => $value) :
					$album_thumbnail = '';
					if($options['album_selection'] == 'thumbnails') {
						$album_thumbnail = plugins_url('/admin/timthumb.php', __FILE__).'?src='.urlencode($albums[$key][0]).'&w='.$thumbnails_selection_width.'&h='.$thumbnails_selection_height.'&zc=1&q=100';
					}
				?>
				<div title="<?php echo $key; ?>" data-thumbnail="<?php echo $album_thumbnail; ?>"><?php
					foreach($albums[$key] as $album_file) {
						echo $this->get_media_link($album_file, $album_file, $options['thumbnail_width'], $options['thumbnail_height'], $options['thumbnail_zc'], preg_replace("/\\.[^.\\s]{3,4}$/", "", basename($album_file)), '');
					}
					?></div><?php endforeach; ?></div>
			<?php

			//js output
			$options = $this->check_options_availability($options);
			echo $this->get_js_code($options, $selector, '');

			$output_gallery = ob_get_contents();
			ob_end_clean();

			return $output_gallery;
		}


		//includes scripts and styles in the frontend
		public function enqueue_styles() {

			wp_enqueue_script( 'jquery' );

			wp_enqueue_style( 'prettyphoto', plugins_url('/prettyphoto/css/prettyPhoto.css', __FILE__), '3.1.5' );
			wp_enqueue_style( 'fancybox', plugins_url('/fancybox/jquery.fancybox.css', __FILE__), '2.1.4' );
			wp_enqueue_style( 'fancybox-buttons', plugins_url('/fancybox/helpers/jquery.fancybox-buttons.css', __FILE__), '2.1.4' );
			wp_enqueue_style( 'fancybox-thumbs', plugins_url('/fancybox/helpers/jquery.fancybox-thumbs.css', __FILE__), '2.1.4' );
			wp_enqueue_style( 'mejs', plugins_url('/mejs/mediaelementplayer.css', __FILE__), '2.11.3' );
			wp_enqueue_style( 'mejs-skins', plugins_url('/mejs/mejs-skins.css', __FILE__), '2.11.3' );
			wp_enqueue_style( 'font-awesome-4', '//netdna.bootstrapcdn.com/font-awesome/4.0.1/css/font-awesome.css', false, '4.0.1' );
			wp_enqueue_style( 'radykal-fancy-gallery', plugins_url('/css/jquery.fancygallery.css', __FILE__), array(), $this->version );


		}

		public function enqueue_scripts() {

			if( self::$add_pp_script )
				wp_enqueue_script( 'prettyphoto', plugins_url('/prettyphoto/jquery.prettyPhoto.js', __FILE__), array(), '3.1.5' );

			if( self::$add_fb_script ) {
				wp_register_script( 'fancybox', plugins_url('/fancybox/jquery.fancybox.pack.js', __FILE__), array(), '2.1.4' );
				wp_register_script( 'fancybox-media', plugins_url('/fancybox/helpers/jquery.fancybox-media.js', __FILE__), array(), '2.1.4' );
				wp_register_script( 'fancybox-buttons', plugins_url('/fancybox/helpers/jquery.fancybox-buttons.js', __FILE__), array(), '2.1.4' );
				wp_enqueue_script( 'fancybox-thumbs', plugins_url('/fancybox/helpers/jquery.fancybox-thumbs.js', __FILE__), array('fancybox', 'fancybox-buttons','fancybox-media'), '2.1.4' );

			}

			if( self::$add_inline_script )
				wp_enqueue_script( 'mejs', plugins_url('/mejs/mediaelement-and-player.min.js', __FILE__), array(), '2.11.3' );

			if ( self::$add_script ) {
				wp_enqueue_script( 'svg-js', plugins_url('/js/svg.min.js', __FILE__) );
				wp_enqueue_script( 'radykal-fancy-gallery', plugins_url('/js/jquery.fancygallery.min.js', __FILE__), array(), $this->version);
			}

		}

		public function new_gallery() {

			//Get post data
		    if ( !isset( $_POST['title'] ) )
			    exit;

			$title = trim($_POST['title']);

			$error_response = $success_response = new WP_Ajax_Response();
			$errors = new WP_Error();

			//check if main gallery folder exists
			if(!file_exists($this->content_dir)) {
				//try to create main gallery folder
				if( !wp_mkdir_p($this->content_dir) ) {
				     $errors->add( 'makeroot-error', __(WP_CONTENT_DIR .': Could not create the fancygallery folder! Please check the permission. Set the CHMOD to 755 or 777 for the wp-content folder.', 'radykal'));
					 $this->ajax_error_handler($errors, $error_response);
					 exit;
				}

				//check if main gallery folder is writable
				if( !@is_writable($this->content_dir) ) {
					$errors->add( 'gallery-permission-error', sprintf(__('<strong>%s</strong> '.' is not writable! Please check the permission. Set the CHMOD to 755 or 777.', 'radykal')), $this->content_dir);
					$this->ajax_error_handler($errors, $error_response);
					exit;
				}
			}

			//insert gallery in DB
			$inserted = $this->wpdb->insert(
				$this->gallery_table_name,
				array( 'title' => $title, 'options' => serialize($this->default_options)),
				array( '%s', '%s')
			);

			if( $inserted ) {

				$id = $this->wpdb->insert_id;

				$gallery_directory = $this->content_dir . '/' . $id;
				if (wp_mkdir_p($gallery_directory)) {
					$success_response->add(array( 'what' => 'object', 'data' => __('Gallery successfully created!', 'radykal'), 'supplemental' => array('gallery_html' => $this->get_gallery_list_item($id, $title)) ) );
					$success_response->send();
					exit;
				}
				else {
					$errors->add( 'new-gallery-error', __('A new gallery directory could not be created. Please try again!', 'radykal'));
					$this->ajax_error_handler($errors, $error_response);
					exit;
				}

			}
			else {
				$errors->add( 'new-gallery-error', __('Database error: A new gallery could not be created!', 'radykal'));
				$this->ajax_error_handler($errors, $error_response);
				exit;
			}

		}

		public function edit_gallery() {

		    if ( !isset($_POST['id']) || !isset($_POST['newTitle']) )
			    exit;

			$id = trim($_POST['id']);
		    $newTitle = trim($_POST['newTitle']);

			$error_response = $success_response = new WP_Ajax_Response();
			$errors = new WP_Error();

			if( $this->wpdb->update( $this->gallery_table_name, array('title' => $newTitle ), array('ID' => $id )) ) {
				$success_response->add( array( 'what' => 'object', 'data' => __('Gallery title successfully changed!', 'radykal'), 'supplemental' => array('title' => $newTitle) ) );
				$success_response->send();
			}
			else {
				$errors->add( 'edit-album-error', __('Could not rename gallery, please try again!', 'radykal') );
				$this->ajax_error_handler($errors, $error_response);
			}

			exit;

		}

		public function delete_gallery() {

		    if ( !isset( $_POST['id'] ) )
			    exit;

			$id = trim($_POST['id']);

			$error_response = $success_response = new WP_Ajax_Response();
			$errors = new WP_Error();

			try {
				$this->wpdb->query("DELETE FROM {$this->images_table_name} WHERE album_id=(SELECT ID FROM {$this->album_table_name} WHERE gallery_id='$id') ");
				$this->wpdb->query("DELETE FROM {$this->album_table_name} WHERE gallery_id='$id'");
				$this->wpdb->query("DELETE FROM {$this->gallery_table_name} WHERE ID='$id'");
				$this->delete_directory($this->content_dir . '/' . $id);

				$success_response->add( array( 'what' => 'object', 'data' => __('Gallery successfully deleted!', 'radykal') ) );
				$success_response->send();

				exit;

			}
			catch(Exception $e) {
				$errors->add( 'delete-gallery-error', __('Could not delete gallery!', 'radykal') );
			}

			$this->ajax_error_handler($errors, $error_response);
			exit;

		}

		public function new_album() {

		    if ( !isset($_POST['title']) || !isset($_POST['gallery']) || !isset($_POST['sortId']) )
			    exit;

			$title = trim($_POST['title']);
			$sort_id = trim($_POST['sortId']);
			$gallery_id = trim($_POST['gallery']);

			$error_response = $success_response = new WP_Ajax_Response();
			$errors = new WP_Error();

			$inserted = $this->wpdb->insert(
				$this->album_table_name,
				array( 'gallery_id' => $gallery_id, 'title' => $title, 'sort' => $sort_id ),
				array( '%d', '%s', '%d')
			);

			if( $inserted ) {

				$id = $this->wpdb->insert_id;
				$album_directory = $this->content_dir . '/' . $gallery_id . '/'. $id;

				if (wp_mkdir_p($album_directory)) {
					$success_response->add(array( 'what' => 'object', 'data' => __('Album successfully created!', 'radykal'), 'supplemental' => array('album_html' => $this->get_album_list_item($id, $title, '', '')) ) );
					$success_response->send();
					exit;
				}
				else
				  $errors->add( 'new-album-error', __('An new album directory could not be created. Please try again!', 'radykal') );
			}
			else {
				$errors->add( 'new-album-error', __('Database error: A new album could not be created!', 'radykal'));
			}

			$this->ajax_error_handler($errors, $error_response);

			exit;

		}

		public function edit_album() {

			//Get post data
		    if ( !isset($_POST['id']) || !isset($_POST['newTitle']) )
			    exit;

			$id = trim($_POST['id']);
		    $newTitle = trim($_POST['newTitle']);

			$error_response = $success_response = new WP_Ajax_Response();
			$errors = new WP_Error();

			if( $this->wpdb->update($this->album_table_name, array('title' => $newTitle ), array('ID' => $id)) ) {
				$success_response->add( array( 'what' => 'object', 'data' => __('Album title successfully changed!', 'radykal'), 'supplemental' => array('title' => $newTitle) ) );
				$success_response->send();
				exit;
			}
			else {
				$errors->add( 'edit-album-error', __('Could not rename album directory!', 'radykal') );
			}

			$this->ajax_error_handler($errors, $error_response);

			exit;
		}

		public function edit_album_description() {

			//Get post data
		    if ( !isset($_POST['id']) || !isset($_POST['description']) )
			    exit;

			$id = trim($_POST['id']);
		    $description = htmlspecialchars(trim($_POST['description']));

			$error_response = $success_response = new WP_Ajax_Response();
			$errors = new WP_Error();

			if( $this->wpdb->update($this->album_table_name, array('description' => $description ), array('ID' => $id)) ) {
				$success_response->add( array( 'what' => 'object', 'data' => __('Album description successfully saved!', 'radykal') ) );
				$success_response->send();
				exit;
			}
			else {
				$errors->add( 'edit-album-description-error', __('You did not change the album description or there is a database error. Please try again!', 'radykal') );
			}

			$this->ajax_error_handler($errors, $error_response);

			exit;
		}

		public function delete_album() {

			//Get post data
		    if ( !isset($_POST['id']) || !isset($_POST['galleryId']) )
			    exit;

			$id = trim($_POST['id']);
			$gallery_id = trim($_POST['galleryId']);

			$error_response = $success_response = new WP_Ajax_Response();
			$errors = new WP_Error();

			try {
				$this->wpdb->query("DELETE FROM {$this->images_table_name} WHERE album_id='$id' ");
				$this->wpdb->query("DELETE FROM {$this->album_table_name} WHERE ID ='$id' ");
			    $this->delete_directory($this->content_dir . '/' . $gallery_id . '/' . $id);

				$success_response->add( array( 'what' => 'object', 'data' => __('Album successfully deleted!', 'radykal') ) );
				$success_response->send();

				exit;
			}
			catch(Exception $e) {
				$errors->add( 'delete-album-error', __('Could not delete album directory!', 'radykal') );
			}

			$this->ajax_error_handler($errors, $error_response);
			exit;
		}

		public function update_albums() {

			//Get post data
		    if ( !isset($_POST['albums']) || !isset($_POST['oldGallery']) || !isset($_POST['newGallery']) || !isset($_POST['albumId']) )
			    exit;

			$albums = $_POST['albums'];
			$oldGalleryId = trim($_POST['oldGallery']);
			$newGalleryId = trim($_POST['newGallery']);

			$error_response = $success_response = new WP_Ajax_Response();
			$errors = new WP_Error();

			try {

				if($oldGalleryId == $newGalleryId) {

					//update sort index
					for($i = 0; $i < sizeof($albums); $i++) {

						if(isset($albums[$i])) {
							 $this->wpdb->update(
							 	$this->album_table_name,
							 	array('sort' => $i),
							 	array(
							 		'gallery_id' => $oldGalleryId,
							 		'ID' =>  $albums[$i]
							 	),
							 	array('%d'),
							 	array('%d', '%d')
							 );
						}

					}

				}
				else {

					$album_id = trim($_POST['albumId']);

					//update sort index
					for($i = 0; $i < sizeof($albums); $i++) {

						if(isset($albums[$i])) {
							 $this->wpdb->update(
							 	$this->album_table_name,
							 	array(
							 		'gallery_id' => $newGalleryId,
							 		'sort' => $i
							 	),
							 	array(
							 		'gallery_id' => $oldGalleryId,
							 		'ID' =>  $albums[$i]
							 	),
							 	array('%d'),
							 	array('%d', '%d')
							 );
						}

					}

					//move album directory into new gallery folder
					$album_directory_old = $this->content_dir . '/' . $oldGalleryId . '/' . $album_id;
					rename($album_directory_old, $this->content_dir . '/' . $newGalleryId . '/' . $album_id);

					//update file pathes
					$this->wpdb->query("UPDATE {$this->images_table_name} SET file = REPLACE(file, '/$oldGalleryId/', '/$newGalleryId/') WHERE album_id='$album_id'");
					$this->wpdb->query("UPDATE {$this->images_table_name} SET thumbnail = REPLACE(thumbnail, '/$oldGalleryId/', '/$newGalleryId/') WHERE album_id='$album_id'");

				}

				$success_response->add( array( 'what' => 'object', 'data' => __('Album successfully updated!', 'radykal') ) );
				$success_response->send();

				exit;
			}
			catch(Exception $e) {
				$errors->add( 'update-album-error', __('Album could not be updated. Please try again!', 'radykal') );
			}

			$this->ajax_error_handler($errors, $error_response);

			exit;

		}

		public function load_files() {

		    if ( !isset($_POST['albumId']) )
			    exit;

			$album_id = trim($_POST['albumId']);
			$results = $this->wpdb->get_results("SELECT * FROM {$this->images_table_name} WHERE album_id='$album_id' ORDER BY sort DESC");

			$response = json_encode( $results );

			// response output
			header( "Content-Type: application/json" );
			echo $response;

			exit;
		}

		public function upload_file() {

			if ( !isset($_POST['albumDir']) )
				exit;

			$album_dir = trim($_POST['albumDir']);

			check_ajax_referer( 'fg-upload-nonce', 'security' );

			header( "Content-Type: application/json" );

			if(!file_exists($this->content_dir)) {
				echo json_encode(array('error' => 1, 'message' => __('The directory "'.$this->content_dir.'", where to store the images, does not exist. Please create a new gallery or create this folder by yourself!', 'radykal')));
				die();
			}

			foreach ($_FILES as $fieldName => $file) {

				$filename = $file['name'][0];

				//check if its an image
				if(!getimagesize($file['tmp_name'][0])) {
					echo json_encode(array('error' => 1, 'message' => __('File is not an image', 'radykal'), 'filename' => $filename));
					die;
				}

				//check for php errors
				if($file['error'][0] !== UPLOAD_ERR_OK) {
					echo json_encode(array('error' => 1, 'message' => __(file_upload_error_message($file['error'][0]), 'radykal'), 'filename' => $filename));
					die;
				}

				//check for maximum upload size
				if($file['size'][0] > $this->maximum_filesize) {
					echo json_encode(array('error' => 1, 'message' => __('Uploaded image is too big', 'radykal'), 'filename' => $filename));
					die;
				}

			    $myFileExt = sanitize_file_name($filename);
				$myTempFile = $this->content_dir.'/'.$album_dir.$myFileExt;
				if( @move_uploaded_file($file['tmp_name'][0], $myTempFile) ) {
					chmod($myTempFile, 0755);
					echo json_encode(array('error' => 0, 'filename' => preg_replace("/\\.[^.\\s]{3,4}$/", "", $filename), 'realFile' => $myFileExt));
				}
				else {
					echo json_encode(array('error' => 2, 'message' => __('PHP Issue - move_uploaed_file failed', 'radykal'), 'filename' => $filename));
				}
			}

			die;

		}

		public function save_file() {

			//Get post data
		    if ( !isset($_POST['album']) || !isset($_POST['file']) || !isset($_POST['thumbnail']) || !isset($_POST['sortId']) )
			    exit;

			$album_id = trim($_POST['album']);
			$file = trim($_POST['file']);
			$thumbnail = trim($_POST['thumbnail']);
			$sort_id = trim($_POST['sortId']);
			$title = trim($_POST['title']);

			$this->wpdb->insert(
				$this->images_table_name,
				array( 'album_id' => $album_id, 'file' => $file, 'thumbnail' => $thumbnail, 'title' => $title, 'description' => '', 'sort' => $sort_id ),
				array( '%d', '%s', '%s', '%s', '%s', '%d')
			);

			echo json_encode(array('ID' => $this->wpdb->insert_id));

			exit;

		}

		public function delete_files() {

			//Get post data
		    if ( !isset($_POST['files']) )
			    exit;

		    $files = $_POST['files'];

		    foreach($files as $file) {
			   $file_url = trim($file['value']);
			   $album_dir = strrchr(dirname($file_url), "/");
			   $gallery_dir = strrchr(dirname(dirname($file_url)), "/");

			   $this->wpdb->query("DELETE FROM {$this->images_table_name} WHERE file='$file_url' ");

			   $file_path = $this->content_dir . $gallery_dir . $album_dir . '/' . basename($file_url);
			   if(file_exists($file_path))
				   @unlink($file_path);
		    }
		    exit;
		}

		public function update_files() {

			//Get post data
		    if ( !isset($_POST['ids']) || !isset($_POST['albumId']) )
			    exit;

			$album_id = trim($_POST['albumId']);
			$ids = $_POST['ids'];

			for($i = 0; $i < sizeof($ids); $i++) {
				if(isset($ids[$i])) {
					$this->wpdb->update(
						$this->images_table_name,
						array(
							'sort' => $i
						),
						array(
							'ID' => $ids[$i]['value'],
							'album_id' => $album_id
						),
						array('%d'),
						array('%d','%d')
					);
				}
			}

			exit;
		}

		public function update_media() {

			//Get post data
		    if ( !isset($_POST['id']) || !isset($_POST['albumId']) )
			    exit;

			$album_id = trim($_POST['albumId']);
			$id = $_POST['id'];
			$file = $_POST['file'];
			$thumbnail = $_POST['thumbnail'];
			$description = htmlspecialchars($_POST['description']);

			$result = $this->wpdb->update(
				$this->images_table_name,
				array(
					'file' => $file,
					'thumbnail' => $thumbnail,
					'description' => stripslashes($description)
				),
				array(
					'ID' => $id,
					'album_id' => $album_id
				),
				array('%s','%s','%s'),
				array('%d','%d')
			);

			echo json_encode($result);

			exit;
		}

		public function edit_album_thumbnail() {

			//Get post data
		    if ( !isset($_POST['id']) || !isset($_POST['thumbnail']) )
			    exit;

			$id = trim($_POST['id']);
		    $thumbnail = trim($_POST['thumbnail']);

			$error_response = $success_response = new WP_Ajax_Response();
			$errors = new WP_Error();

			if( $this->wpdb->update($this->album_table_name, array('thumbnail' => $thumbnail ), array('ID' => $id)) ) {
				$success_response->add( array( 'what' => 'object', 'data' => __('Album thumbnail successfully saved!', 'radykal') ) );
				$success_response->send();
				exit;
			}
			else {
				$errors->add( 'edit-album-thumbnail-error', __('You did not change the album thumbnail or there is a database error. Please try again!', 'radykal') );
			}

			$this->ajax_error_handler($errors, $error_response);

			exit;
		}

		public function edit_media_title() {

			//Get post data
		    if ( !isset($_POST['id']) || !isset($_POST['title']) )
			    exit;

			$id = trim($_POST['id']);
		    $title = trim($_POST['title']);

			$result = $this->wpdb->update(
				$this->images_table_name,
				array(
					'title' => $title,
				),
				array(
					'ID' => $id,
				),
				array('%s'),
				array('%d')
			);

			if( $result ) {
				echo json_encode( array( 'what' => 'object', 'data' => __('Media title successfully updated!', 'radykal') ) );
			}

			exit;
		}

		private function install() {

			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

			global $wpdb;
			global $charset_collate;

			$this->gallery_table_name = $wpdb->prefix . "fg_gallery";
			$this->album_table_name = $wpdb->prefix . "fg_album";
			$this->images_table_name = $wpdb->prefix . "fg_media";

			//create tables in the db
			$gallery_sql = "ID BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			              title TEXT COLLATE utf8_general_ci NOT NULL,
			              options TEXT COLLATE utf8_general_ci NOT NULL,
						  PRIMARY KEY (ID)";

			$album_sql = "ID BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			              gallery_id BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
			              title TEXT COLLATE utf8_general_ci NOT NULL,
			              description TEXT COLLATE utf8_general_ci NULL,
			              thumbnail VARCHAR(255) COLLATE utf8_general_ci NULL,
						  sort INT COLLATE utf8_general_ci NOT NULL,
						  PRIMARY KEY (ID)";

			$images_sql = "ID BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			              album_id BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
						  file VARCHAR(255) COLLATE utf8_general_ci NOT NULL,
						  thumbnail VARCHAR(255) COLLATE utf8_general_ci NOT NULL,
						  title TEXT COLLATE utf8_general_ci NULL,
						  description TEXT COLLATE utf8_general_ci NULL,
						  sort INT COLLATE utf8_general_ci NOT NULL,
						  PRIMARY KEY (ID)";

			$sql = "CREATE TABLE {$this->gallery_table_name} ($gallery_sql) $charset_collate;";
			$sql .= "CREATE TABLE {$this->album_table_name} ($album_sql) $charset_collate;";
			$sql .= "CREATE TABLE {$this->images_table_name} ($images_sql) $charset_collate;";

			dbDelta($sql);

			$wpdb->query("ALTER TABLE {$this->album_table_name} ADD CONSTRAINT fk_fg_gallery_id FOREIGN KEY (gallery_id) references {$this->gallery_table_name}(ID) on DELETE CASCADE;");
			$wpdb->query("ALTER TABLE {$this->images_table_name} ADD CONSTRAINT fk_fg_album_id FOREIGN KEY (album_id) references {$this->album_table_name}(ID) on DELETE CASCADE;");

			add_option($this->version_field_name, $this->version);

			$cache_dir = FG_PLUGIN_DIR . '/admin/cache/';

			//create cache for timthumb and set chmod to 755
			if(!file_exists($cache_dir)) {
				wp_mkdir_p($cache_dir);
			}
			chmod($cache_dir, 0755);

	   }

	   private function deinstall() {

	   		global $wpdb;

	   		$this->gallery_table_name = $wpdb->prefix . "fg_gallery";
			$this->album_table_name = $wpdb->prefix . "fg_album";
			$this->images_table_name = $wpdb->prefix . "fg_media";

			//delete everything
			delete_option($this->version_field_name);
			$wpdb->query("SET FOREIGN_KEY_CHECKS=0;");
			$wpdb->query("DROP TABLE {$this->images_table_name}");
			$wpdb->query("DROP TABLE {$this->album_table_name}");
			$wpdb->query("DROP TABLE {$this->gallery_table_name}");
			$wpdb->query("SET FOREIGN_KEY_CHECKS=1;");
			if(file_exists($this->content_dir))
			    $this->delete_directory($this->content_dir);


	   }

	   private function upgrade() {

	   		global $wpdb;

			if( get_option($this->version_field_name) < '1.2.3') {
				//UPGRADE TO 1.2.3

		   		//add new column to gallery table
		   		$this->wpdb->query( 'ALTER TABLE '.$this->gallery_table_name.' ADD COLUMN options TEXT' );

		   		//get all gallery slugs
		   		$gallery_slugs = $this->wpdb->get_results('SELECT slug FROM '.$this->gallery_table_name.'');
		   		//get options
		   		$options = get_option('fg_gallery_options');

		   		//move options from options table to gallery table
		   		foreach($gallery_slugs as $gallery_slug) {
		   			$gallery_opts = empty($options[$gallery_slug->slug]) ? $this->default_options : $options[$gallery_slug->slug];
		   			$this->wpdb->update( $this->gallery_table_name, array('options' => serialize($gallery_opts) ), array('slug'=> $gallery_slug->slug), array('%s') );
		   		}

		   		//delete options from option tabale
		   		delete_option('fg_gallery_options');

		   		//update version in db
		   		update_option($this->version_field_name, '1.2.3');

			}

			//upgrade to V1.2.4
			if( get_option($this->version_field_name) == '1.2.3') {
				//update version in db
		   		update_option($this->version_field_name, '1.2.4');
			}

			//upgrade to V1.2.5
			if( get_option($this->version_field_name) == '1.2.4') {
				//update version in db
		   		update_option($this->version_field_name, '1.2.5');
			}

			//upgrade to V2.0.0
			if( get_option($this->version_field_name) == '1.2.5') {
				//update version in db
		   		update_option($this->version_field_name, '2.0.0');
			}

			//upgrade to 2.1.0
	   		if( get_option($this->version_field_name) == '2.0.0' ) {

	   			//rename album folders and update album path
	   			$albums = $wpdb->get_results("SELECT id, slug, gallery FROM {$this->album_table_name}");
				foreach ( $albums as $album ) {
					$wpdb->query("UPDATE {$this->images_table_name} SET thumbnail = REPLACE(thumbnail, '{$album->slug}', '{$album->id}') WHERE album='{$album->slug}'");
					$wpdb->query("UPDATE {$this->images_table_name} SET file = REPLACE(file, '{$album->slug}', '{$album->id}') WHERE album='{$album->slug}'");
					$old_album_directory = $this->content_dir . '/' . $album->gallery . '/' . $album->slug;

					if( file_exists($old_album_directory) ) {
						rename($old_album_directory, $this->content_dir . '/' . $album->gallery . '/' . $album->id);
					}
				}

				//rename gallery folders update gallery path
	   			$galleries = $wpdb->get_results("SELECT id, slug FROM {$this->gallery_table_name}");
				foreach ( $galleries as $gallery ) {
					$wpdb->query("UPDATE {$this->images_table_name} SET thumbnail = REPLACE(thumbnail, '{$gallery->slug}', '{$gallery->id}') WHERE gallery='{$gallery->slug}'");
					$wpdb->query("UPDATE {$this->images_table_name} SET file = REPLACE(file, '{$gallery->slug}', '{$gallery->id}') WHERE gallery='{$gallery->slug}'");
					$old_gallery_directory = $this->content_dir . '/' . $gallery->slug;

					if( file_exists($old_gallery_directory) ) {
						rename($old_gallery_directory, $this->content_dir . '/' . $gallery->id);
					}
				}

	   			//change structure for gallery table
	   			$wpdb->query("ALTER TABLE {$this->gallery_table_name} CHANGE id ID BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT;");
				$wpdb->query("ALTER TABLE {$this->gallery_table_name} ADD CONSTRAINT PRIMARY KEY(ID);");

				//change structure for album table
				$wpdb->query("ALTER TABLE {$this->album_table_name} CHANGE id ID BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT;");
				$wpdb->query("ALTER TABLE {$this->album_table_name} ADD gallery_id BIGINT(20) UNSIGNED NOT NULL DEFAULT '0';");
				$wpdb->query("ALTER TABLE {$this->album_table_name} ADD CONSTRAINT PRIMARY KEY(ID);");
				$wpdb->query("ALTER TABLE {$this->album_table_name} ADD CONSTRAINT fk_fg_gallery_id FOREIGN KEY (gallery_id) references {$this->gallery_table_name}(ID) on DELETE CASCADE;");

				//update rows in album table
				$galleries = $wpdb->get_results("SELECT ID, slug FROM {$this->gallery_table_name}");
				foreach ( $galleries as $gallery ) {
					$wpdb->update(
						$this->album_table_name,
						array('gallery_id' => $gallery->ID),
						array('gallery' => $gallery->slug),
						array('%d'),
						array('%s')
					);
				}

				//change structure for media table
				$wpdb->query("ALTER TABLE {$this->images_table_name} CHANGE id ID BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT;");
				$wpdb->query("ALTER TABLE {$this->images_table_name} ADD album_id BIGINT(20) UNSIGNED NOT NULL DEFAULT '0';");
				$wpdb->query("ALTER TABLE {$this->images_table_name} ADD CONSTRAINT PRIMARY KEY(ID);");
				$wpdb->query("ALTER TABLE {$this->images_table_name} ADD CONSTRAINT fk_fg_album_id FOREIGN KEY (album_id) references {$this->album_table_name}(ID) on DELETE CASCADE;");

				//update rows in media table
				$albums = $wpdb->get_results("SELECT ID, slug, gallery FROM {$this->album_table_name}");
				foreach ( $albums as $album ) {
					$wpdb->update(
						$this->images_table_name,
						array('album_id' => $album->ID),
						array('gallery' => $album->gallery, 'album' => $album->slug),
						array('%d'),
						array('%s', '%s')
					);
				}

				//drop old columns
				$wpdb->query("ALTER TABLE {$this->gallery_table_name} DROP slug;");
				$wpdb->query("ALTER TABLE {$this->album_table_name} DROP slug, DROP gallery;");
				$wpdb->query("ALTER TABLE {$this->images_table_name} DROP gallery, DROP album;");

		   		update_option($this->version_field_name, '2.1.0');
	   		}

			//upgrade to V2.1.1
			if( get_option($this->version_field_name) == '2.1.0') {
				//update version in db
		   		update_option($this->version_field_name, '2.1.1');
			}

			//upgrade to V2.2.0
			if( get_option($this->version_field_name) == '2.1.1') {
				$wpdb->query("ALTER TABLE {$this->album_table_name} ADD description TEXT COLLATE utf8_general_ci NULL DEFAULT '';");
				//update version in db
		   		update_option($this->version_field_name, '2.2.0');
			}

			//upgrade to V2.3.0
			if( get_option($this->version_field_name) == '2.2.0') {
				$wpdb->query("UPDATE {$this->gallery_table_name} SET options = '".serialize($this->default_options)."'");
				$wpdb->query("ALTER TABLE {$this->album_table_name} ADD thumbnail VARCHAR(255) COLLATE utf8_general_ci NULL DEFAULT '';");
				//update version in db
		   		update_option($this->version_field_name, '2.3.0');
			}

			//upgrade to V2.3.1
			if( get_option($this->version_field_name) == '2.3.0') {
		   		update_option($this->version_field_name, '2.3.1');
			}

			//upgrade to V2.3.2
			if( get_option($this->version_field_name) == '2.3.1') {
		   		//delete all media entries with albums that does not exist anymore
		   		$wpdb->query("DELETE FROM {$this->images_table_name} WHERE album_id NOT IN(SELECT ID FROM {$this->album_table_name}) ");
		   		update_option($this->version_field_name, '2.3.2');
			}

			//upgrade to V2.3.3
			if( get_option($this->version_field_name) == '2.3.2') {
		   		update_option($this->version_field_name, '2.3.3');
			}

			//upgrade to V2.3.4
			if( get_option($this->version_field_name) == '2.3.3') {
		   		update_option($this->version_field_name, '2.3.4');
			}

	   }

	   //deletes a directory and is content
	   private function delete_directory($dir) {
			$iterator = new RecursiveDirectoryIterator($dir);
			foreach (new RecursiveIteratorIterator($iterator, RecursiveIteratorIterator::CHILD_FIRST) as $file) {
			if ($file->isDir()) {
				@rmdir($file->getPathname());
			 }
			 else {
			    @unlink($file->getPathname());
			 }
		   }
		   @rmdir($dir);
	   }

	   //returns an error to the ajax handler
	   private function ajax_error_handler($errors, $error_response) {
		   if ( count ( $errors->get_error_codes() ) > 0 ) {
				$error_response->add( array( 'what' => 'errors', 'id' => $errors ) );
				$error_response->send();

				exit;
			}
	   }

	   private function get_gallery_list_item($id, $title) {
	   	   return '<li><div id="' . $id . '" class="gallery-item clearfix"><span class="fg-title">' . stripslashes($title) . '</span><span class="fg-meta-bar"><a href="#" title="' . __('Add new album', 'radykal') . '" class="fg-add-album" data-toggle="tooltip"><i class="glyphicon glyphicon-plus"></i></a><a href="#" title="' . __('Edit gallery title', 'radykal') . '" class="fg-edit fg-edit-gallery" data-toggle="tooltip"><i class="glyphicon glyphicon-pencil"></i></a><a href="#" title="' . __('Show Shortcode', 'radykal') . '" class="fg-show-shortcode" data-toggle="tooltip"><i class="glyphicon glyphicon-link"></i></a><a href="#" title="' . __('Delete gallery', 'radykal') . '" class="fg-delete fg-delete-gallery" data-toggle="tooltip"><i class="glyphicon glyphicon-trash"></i></a></span></div><ul class="sub-menu">';
	   }

	   private function get_album_list_item($id, $title, $description, $album_thumbnail) {
		   return '<li><div id="' . $id . '" class="clearfix"><span class="dragger glyphicon glyphicon-move"></span><span class="fg-title">' . stripslashes($title) . '</span><span class="fg-meta-bar"><a href="#" title="' . __('Edit album title', 'radykal') . '" class="fg-edit fg-edit-album" data-toggle="tooltip"><i class="glyphicon glyphicon-pencil"></i></a><a href="#fg-album-description-modal" title="' . __('Edit album description', 'radykal') . '" class="fg-edit-album-description" data-toggle="tooltip"><i class="glyphicon glyphicon-edit"></i><input type="hidden" value="'.$description.'" /></a><a href="#fg-album-thumbnail-modal" title="' . __('Edit album thumbnail', 'radykal') . '" class="fg-edit-album-thumbnail" data-toggle="tooltip"><i class="glyphicon glyphicon-picture"></i><input type="hidden" value="'.$album_thumbnail.'" /></a><a href="#" title="' . __('Show Shortcode', 'radykal') . '" class="fg-show-shortcode fg-album-shortcode" data-toggle="tooltip"><i class="glyphicon glyphicon-link"></i></a><a href="#" title="' . __('Delete album', 'radykal') . '" class="fg-delete" data-toggle="tooltip"><i class="glyphicon glyphicon-trash"></i></a></span></div></li>';
	   }

	   private function file_upload_error_message($error_code) {
		    switch ($error_code) {
		        case UPLOAD_ERR_INI_SIZE:
		            return 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
		        case UPLOAD_ERR_FORM_SIZE:
		            return 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
		        case UPLOAD_ERR_PARTIAL:
		            return 'The uploaded file was only partially uploaded';
		        case UPLOAD_ERR_NO_FILE:
		            return 'No file was uploaded';
		        case UPLOAD_ERR_NO_TMP_DIR:
		            return 'Missing a temporary folder';
		        case UPLOAD_ERR_CANT_WRITE:
		            return 'Failed to write file to disk';
		        case UPLOAD_ERR_EXTENSION:
		            return 'File upload stopped by extension';
		        default:
		            return 'Unknown upload error';
		    }
		}

		//scan directory and return all images
		private function _scan_album_dir($album_dir) {

			$images = array();

			$album_directory_entries = scandir($album_dir);
			foreach($album_directory_entries as $album_directory_entry) {
				if(!is_dir($album_directory_entry)) {
					if (preg_match("/.png/",$album_directory_entry) || preg_match("/.jpg/",$album_directory_entry) || preg_match("/.gif/",$album_directory_entry) || preg_match("/.JPG/",$album_directory_entry) || preg_match("/.PNG/",$album_directory_entry) || preg_match("/.GIF/",$album_directory_entry) ) {
						array_push($images, WP_CONTENT_URL.substr($album_dir, strpos($album_dir, '/uploads/')).'/'.$album_directory_entry);
					}
				}
	    	}

	    	return $images;
		}

		public function check_options_availability($options) {
			foreach($this->default_options as $key => $value) {
				$options[$key] = $options[$key] === null ? $value : $options[$key];
			}
			return $options;
		}

		public function get_media_link($file, $thumbnail, $tn_width, $tn_height, $tn_zc, $title, $description) {

			global $blog_id;

			//get correct content path
			$content_url = content_url();

			//check if its a network site
			if( is_multisite() ) {

				if (isset($blog_id) && $blog_id > 1) {
					$blog_details = get_blog_details(1);
					$content_url = $blog_details->siteurl . "/wp-content/blogs.dir/" .$blog_id;
				}

				//check if multisite and path contains files string to get real file path
				if( strpos($thumbnail, '/files/') ) {
					$imageParts = explode('/files/', $thumbnail);
					$blog_details = get_blog_details(1);
					$thumbnail = $blog_details->siteurl . "/wp-content/blogs.dir/" .$blog_id . "/files/" . $imageParts[1];
				}

			}

			$file = strpos($file, '/fancygallery/') === 0 ? $content_url.substr($file, strpos($file, '/fancygallery/')) : $file;
			$thumbnail = strpos($thumbnail, '/fancygallery/') === 0 ? $content_url.substr($thumbnail, strpos($thumbnail, '/fancygallery/')) : $thumbnail;

			return '<a href="'.$file.'" data-thumbnail="'.plugins_url('/admin/timthumb.php', __FILE__).'?src='.urlencode($thumbnail).'&w='.$tn_width.'&h='.$tn_height.'&zc='.$tn_zc.'&q=100" title="'.strip_tags(stripslashes($title)).'" data-description="'.str_replace('"', "'", stripslashes(htmlspecialchars_decode($description))).'"></a>';

		}

		public function get_js_code($options, $selector, $selectAlbum) {

			$prettyphoto_options = $fancybox_options = '';
			if($options['gallery'] == 'prettyphoto') {
				$prettyphoto_options = "theme: '" . $options['prettyphoto_theme'] . "', allow_resize: " . $options['prettyphoto_image_resize'] . " , overlay_gallery: " . $options['prettyphoto_overlay'] . ", autoplay_slideshow: " . $options['prettyphoto_slideshow'] . " ";
			}
			else if($options['gallery'] == 'fancybox') {
				$fancybox_options = "$.fancybox.defaults.helpers={overlay: true, media: {}, buttons: {position: '" . $options['fancybox_buttons_position'] . "'}, thumbs: {position: '" . $options['fancybox_thumbs_position'] . "'} }; $.fancybox.defaults.arrows=" . $options['fancybox_arrows'] . "; $.fancybox.defaults.width=" . $options['fancybox_width'] . "; $.fancybox.defaults.height=" . $options['fancybox_height'] . "; $.fancybox.defaults.autoPlay=" . $options['fancybox_autoplay'] . "; $.fancybox.defaults.loop=". $options['fancybox_loop'] . "; $.fancybox.defaults.padding=". $options['fancybox_padding'] . ";$.fancybox.defaults.margin=". $options['fancybox_margin'] . ";$.fancybox.defaults.openEffect='". $options['fancybox_open_effect'] . "';$.fancybox.defaults.closeEffect='". $options['fancybox_close_effect'] . "';$.fancybox.defaults.nextEffect='". $options['fancybox_next_effect'] . "';$.fancybox.defaults.prevEffect='". $options['fancybox_previous_effect'] . "';";
			}

			//get thumbnail hover effect options
			$thumbnailHoverEffect = $options['thumbnail_hover_effect'];
			$hoverEffectOptions = "{}";
			switch($thumbnailHoverEffect) {
				case 'fadeIn':
					$hoverEffectOptions = "{opacity: ".$options['fadeIn_opacity']."}";
				break;
				case 'fadeOut':
					$hoverEffectOptions = "{opacity: ".$options['fadeOut_opacity']."}";
				break;
				case 'filter':
					$hoverEffectOptions = "{type: '".$options['filter_type']."', reverse: ".$options['filter_reverse']."}";
				break;
				case 'icon':
					$hoverEffectOptions = "{iconUrl: '".$options['icon_url']."', transition: '".$options['icon_transition']."'}";
				break;
				case 'slide':
					$hoverEffectOptions = "{overflow: ".$options['slide_overflow']."}";
				break;
				case 'scale':
					$hoverEffectOptions = "{overflow: ".$options['scale_overflow'].", direction: '".$options['scale_direction']."'}";
				break;
				case 'overlay':
					$hoverEffectOptions = "{opacity: ".$options['overlay_opacity'].", color: '".$options['overlay_background_color']."'}";
				break;
				case 'direction_aware_hover':
					$hoverEffectOptions = "{opacity: ".$options['overlay_opacity'].", color: '".$options['overlay_background_color']."'}";
				break;
			}

			$js_code = "<script type='text/javascript'>jQuery(document).ready(function($){
  $ = jQuery.noConflict(); ".$fancybox_options."
  jQuery('#".$selector."').fancygallery({
	  backgroundColor: '" . $options['background_color'] . "',
	  borderColor: '" . $options['border_color'] . "',
	  theme: '". $options['theme'] ."',
	  thumbWidth: " . $options['thumbnail_width'] . ",
	  thumbHeight: " . $options['thumbnail_height'] . ",
	  imagesPerPage: " . $options['thumbnails_per_page'] . ",
	  borderThickness: " . $options['border_thickness'] . ",
	  rowOffset: " . $options['row_offset'] . ",
	  scaleMode: 'stretch',
	  columnOffset: " . $options['column_offset'] . ",
	  shadowOffset: " . $options['shadow_offset'] . ",
	  shadowImage: '" . $options['shadow_image'] . "',
	  navPosition: '" . $options['nav_position'] . "',
	  selectAlbum: '" . $selectAlbum . "',
	  allMediasSelector: '" . $options['all_medias_selector'] . "',
	  albumSelection: '" . $options['album_selection'] . "',
	  navigation: '" . $options['navigation'] . "',
	  navAlignment: '" . $options['nav_alignment'] . "',
	  navPreviousText: '" . $options['nav_previous_text'] . "',
	  navNextText: '" . $options['nav_next_text'] . "',
	  navBackText: '" . $options['nav_back_text'] . "',
	  lightbox: '" . $options['gallery'] . "',
	  prettyphotoOptions: {". $prettyphoto_options ."},
	  columns: " . $options['columns'] . ",
	  showOnlyFirstThumbnail: " . $options['show_only_first_thumbnail'] . ",
	  mediaText: '" . $options['media_label'] . "',
	  inlineGalleryOptions: {width: '" . $options['inline_gallery_width'] . "', height: '" . $options['inline_gallery_height'] . "', youtubeParameters: '" . $options['inline_gallery_youtube_parameters'] . "', vimeoParameters: '" . $options['inline_gallery_vimeo_parameters'] . "', showFirstMedia: " . $options['inline_gallery_show_first_media'] . "},
	  thumbnailSelectionOptions : {layout: '" . $options['thumbnail_selection_layout'] . "', width: " . $options['thumbnail_selection_width'] . ", height: " . $options['thumbnail_selection_height'] . ", albumsPerPage: '" . $options['thumbnail_selection_albumsPerPage'] . "'},
	  albumDescriptionPosition: '" . $options['album_description_position'] . "',
	  directionAwareHoverEffect: ". intval($thumbnailHoverEffect == 'direction_aware_hover') .",
	  titlePlacement: '". $options['title_placement'] ."',
	  titleOptions: {background: '". $options['title_options_background'] ."', color: '". $options['title_options_color'] ."', stretchToWidth: ". $options['title_options_stretchToWidth'] ."},
	  thumbnailHoverEffect: '". $thumbnailHoverEffect ."',
	  thumbnailEffectOptions: ". $hoverEffectOptions .",
	  titleHoverEffect: '". $options['title_hover_effect'] ."',
	  target: '". $options['none_gallery_target_window'] ."',
	  facebookLikeButton: " . $options['facebook_like_button'] . ",
	  tweetButton: " . $options['tweet_button'] . ",
	  pinItButton: " . $options['pin_it_button'] . "
  });
});
</script>";
			return $js_code;

		}
	}
}

//init Fancy Gallery
if(class_exists('FancyGallery')) {
	$fg = new FancyGallery();
	$fg->init();
}

function fg_disabled_button() {
	if(FancyGallery::DEMO && !current_user_can('manage_options')) {
		echo 'disabled';
	}
}

?>
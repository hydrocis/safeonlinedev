<div class="wrap <?php fg_disabled_button(); ?>" id="fg-options-admin">
  <div class="icon32" id="icon-options-general"><br/></div>
  <h2><?php _e('Options', 'radykal'); ?></h2>

  <div id="fg-content" class="clearfix">

	  <div id="accordion-wrapper">
		<h3><?php _e('Galleries', 'radykal'); ?></h3>

		<ul id="galleries-accordion">
		<?php
		$galleries = $this->wpdb->get_results("SELECT * FROM {$this->gallery_table_name} ORDER BY title");
		foreach($galleries as $gallery) {

			echo '<li><div id="'.$gallery->ID.'" class="clearfix"><span class="fg-title">'.$gallery->title.'</span><span class="fg-meta-bar"><a href="#" class="fg-paste-options" data-toggle="tooltip" title="'. __('Paste current showing options to this gallery', 'radykal').'"><i class="glyphicon glyphicon-save"></i></a></span></div></li>';
		}
		$selected_gallery = isset($_POST['selected_gallery']) ? $_POST['selected_gallery'] : $galleries[0]->ID;
		?>
		</ul>
	  </div>

	  <!-- Right content starts -->
	  <div id="fg-right-col">
	  	<form action="" method="post" id="fg-options-form">
	  		<input type="hidden" value="<?php echo $selected_gallery ?>" name="selected_gallery" />
	  		<input type="hidden" value="" name="overwrite_gallery" />
	  		<?php require_once( dirname(__FILE__)."/options-form.php" ); ?>

	  		<div class="checkbox">
		  		<label><input type="checkbox" name="enable_general_options" value="1" <?php checked(get_option('fg_general_options_name') == $selected_gallery); ?> /><?php _e('Use these options as general options for all galleries?', 'radykal'); ?> </label>
	  		</div>


	  		<input type="submit" name="fg_opts_save" value="<?php _e('Save Changes', 'radykal'); ?>" title="<?php _e('Save Options Changes', 'radykal'); ?>" class="btn btn-primary" <?php fg_disabled_button(); ?> />
	  		<input type="submit" name="fg_opts_reset" value="<?php _e('Reset Options', 'radykal'); ?>" title="<?php _e('Reset Options for this gallery', 'radykal'); ?>" class="btn btn-default" <?php fg_disabled_button(); ?> />
	  		<input type="submit" name="fg_generate_code" value="<?php _e('Generate Code', 'radykal'); ?>" title="<?php _e('Generate code for external usage', 'radykal'); ?>" class="btn btn-success" />

		</form>
	  </div>
	  <!-- Right content ends -->

  </div>
</div>
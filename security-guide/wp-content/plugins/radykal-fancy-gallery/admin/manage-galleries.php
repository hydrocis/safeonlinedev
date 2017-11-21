<div class="alert alert-success clearfix hidden fade in" id="fg-success-alert">
	<i class="glyphicon glyphicon-ok-circle"></i>
	<p></p>
</div>

<div class="wrap <?php fg_disabled_button(); ?>">

  <div class="icon32" id="icon-upload"><br/></div>
  <h2><?php _e('Manage galleries', 'radykal'); ?></h2>

  <div id="fg-content" class="clearfix">

	  <div id="accordion-wrapper">
		<h3><?php _e('Galleries', 'radykal'); ?></h3>
		<div class="input-group input-group-sm">
			<input type="text" name="gallery_title" class="form-control" id="gallery-title" />
			<span class="input-group-btn">
				<button class="btn btn-primary" id="fg-add-gallery" type="button" <?php fg_disabled_button(); ?>><?php _e('Add Gallery', 'radykal'); ?></button>
			</span>
		</div>

		<ul id="galleries-accordion">
		<?php
		$galleries = $this->wpdb->get_results("SELECT * FROM {$this->gallery_table_name} ORDER BY title");
		foreach($galleries as $gallery) {

			echo $this->get_gallery_list_item($gallery->ID, $gallery->title);

			 $album_results = $this->wpdb->get_results("SELECT * FROM {$this->album_table_name} WHERE gallery_id='{$gallery->ID}' ORDER BY sort ASC");
			 foreach($album_results as $album_result) {
				 echo $this->get_album_list_item($album_result->ID, $album_result->title, $album_result->description, $album_result->thumbnail);
			 }

			echo "</ul></li>";
		}
		?>
		</ul>

		<label>Shortcode:</label>
		<input type="text" id="shortcode-output" value="" class="widefat" readonly="readyonly" />
		<span class="description"><?php _e('Paste the shortcode anywhere in your page or post.', 'radykal'); ?></span>
		<br /><br /><br /><br />
		<a href="http://fancy-gallery.com/documentation/" target="_blank"><?php _e('Get instructions and hints in the documentation!', 'radykal'); ?></a>
	  </div>

	  <div id="fg-right-col">
	  	<div id="media-buttons">

	  		<div style="float: left;">
	  			<div id="image-upload-form">
		  			<form>
		  				<a href="#" title="" id="upload-images-button" class="btn btn-success" <?php fg_disabled_button(); ?>><?php _e('Upload Images', 'radykal'); ?> <span title='<?php _e('Multiple image selection is only supported in following browsers: Firefox 3.6+, Safari 5+, Google Chrome and Opera 11+. Use CTRL or SHIFT for selecting multiple images. Maximum upload size for every image is 1MB.', 'radykal'); ?>' class="glyphicon glyphicon-question-sign"></span></a>
				    	<input type="file" name="files[]" multiple>
				    </form>
	  			</div>

	  			<a href="#" title="" id="upload-media-button" class="btn btn-success"><?php _e('Upload other media', 'radykal'); ?> <span title='<?php _e('You can only upload one media after another. This could be a Video(Quicktime, Youtube, Vimeo or Flash), an external site and more. Check out the documentation to get an overview which media types are supported in the different lightboxes!', 'radykal'); ?>' class="glyphicon glyphicon-question-sign"></span></a>
	  			<div class="checkbox clear">
				    <label>
				      <input type="checkbox" id="titles-from-filenames" /> <?php _e('Get titles from filenames', 'radykal'); ?>
				    </label>
	  			</div>
	  		</div>

	  		<div style="float: right;">
	  			<a href="#" id="update-media" class="btn btn-primary" <?php fg_disabled_button(); ?>><?php _e('Save Changes', 'radykal'); ?></a>
		  		<a href="#" id="select-all" class="btn btn-default btn-sm" title="<?php _e('Select all media', 'radykal'); ?>" ><?php _e('Select all', 'radykal'); ?></a>
			  	<a href="#" id="deselect-all" class="btn btn-default btn-sm" title="<?php _e('Deselect all media', 'radykal'); ?>" ><?php _e('Deselect all', 'radykal'); ?></a>
			  	<a href="#" id="delete-files" class="btn btn-default btn-sm" title="<?php _e('Delete selected media', 'radykal'); ?>" <?php fg_disabled_button(); ?>><?php _e('Delete', 'radykal'); ?></a>
	  		</div>

	  	</div>

	  	<div id="fg-notification"></div>

	  	<div id="fg-alert" class="alert alert-danger">
	  		<button class="close" type="button">&times;</button>
		  	<ul></ul>
	  	</div>

		<ol id="mediaList" class="clearfix"></ol>

	  </div>

  </div>

</div>

<!-- Modal for upload other media -->
<div id="fg-upload-other-modal" class="fg-modal" tabindex="-1" role="dialog" aria-labelledby="uploadOtherModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h3 id="uploadOtherModalLabel"><?php _e('Upload other media', 'radykal'); ?></h3>
			</div>
			<div class="modal-body">
				<h5><?php _e('Enter the URL of the media or choose one from the media library, e.g. a youtube URL', 'radykal'); ?></h5>
				<div class="input-group input-group-sm">
					<input type="text" class="form-control fg-modal-media" />
					<span class="input-group-btn">
						<button class="btn btn-primary fg-add-from-media-library" type="button"><?php _e('Add from media library', 'radykal'); ?></button>
					</span>
				</div>
				<h5><?php _e('Enter the URL of the thumbnail or choose one from the media library', 'radykal'); ?></h5>
				<div class="hidden fg-load-from-container">
					<label data-text="<?php _e('Load thumbnail from ', 'radykal'); ?>">
						<span></span>
						<input type="checkbox" name="fg-load-from" />
					</label>
				</div>
				<div class="input-group input-group-sm">
					<input type="text" class="form-control fg-modal-thumbnail" />
					<span class="input-group-btn">
						<button class="btn btn-primary fg-add-from-media-library" type="button"><?php _e('Add from media library', 'radykal'); ?></button>
					</span>
				</div>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn btn-primary" id="fg-add-media" <?php fg_disabled_button(); ?>><?php _e('Add media', 'radykal'); ?></a>
				<button class="btn btn-default btn-sm fg-close-modal"><?php _e('Cancel', 'radykal'); ?></button>
			</div>
		</div>
	</div>
</div>

<!-- Modal album description -->
<div id="fg-album-description-modal" class="fg-modal" tabindex="-1" role="dialog" aria-labelledby="albumDescriptionModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h3 id="albumDescriptionModalLabel"><?php _e('Write a description for the album', 'radykal'); ?></h3>
			</div>
			<div class="modal-body">
			<?php
			$args = array(
				'media_buttons' => false,
				'textarea_name' => 'fgAlbumDescription',
				'textarea_rows' => 5,
				'tinymce' => array(
					'theme_advanced_buttons1' =>'bold,italic,underline,separator,strikethrough,separatorforecolor,backcolor,separator,fontsizeselect,separator,link,unlink,separator,undo,redo',
					'theme_advanced_buttons2' => ''
				)
			);
			wp_editor( '', 'fgAlbumDescription', $args );
			?>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn btn-primary" id="fg-save-album-description" <?php fg_disabled_button(); ?>><?php _e('Save description', 'radykal'); ?></a>
				<button class="btn btn-default btn-sm fg-close-modal"><?php _e('Cancel', 'radykal'); ?></button>
			</div>
		</div>
	</div>
</div>

<!-- Modal for editing a media -->
<div id="fg-edit-media-modal" class="fg-modal" tabindex="-1" role="dialog" aria-labelledby="editMediaModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h3 id="editMediaModalLabel"><?php _e('Edit media', 'radykal'); ?></h3>
			</div>
			<div class="modal-body">
				<h5><?php _e('Change here the media URL', 'radykal'); ?></h5>
				<div class="input-group input-group-sm">
					<input type="text" class="form-control fg-modal-media" />
					<span class="input-group-btn">
						<button class="btn btn-primary fg-add-from-media-library" type="button"><?php _e('Add from media library', 'radykal'); ?></button>
					</span>
				</div>
				<h5><?php _e('Change here the thumbnail for the media', 'radykal'); ?></h5>
				<div class="hidden fg-load-from-container">
					<label data-text="<?php _e('Load thumbnail from ', 'radykal'); ?>">
						<span></span>
						<input type="checkbox" name="fg-load-from" />
					</label>
				</div>
				<div class="input-group input-group-sm">
					<input type="text" class="form-control fg-modal-thumbnail" />
					<span class="input-group-btn">
						<button class="btn btn-primary fg-add-from-media-library" type="button"><?php _e('Add from media library', 'radykal'); ?></button>
					</span>
				</div>
				<h5><?php _e('Description', 'radykal'); ?></h5>
				<textarea class="form-control" rows="4" id=""></textarea>
				<span class="help-block"><?php _e('You can also use HTML tags in the description.', 'radykal'); ?></span>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary" id="fg-update-media" <?php fg_disabled_button(); ?>><?php _e('Save Changes', 'radykal'); ?></button>
				<button class="btn btn-default btn-sm fg-close-modal"><?php _e('Cancel', 'radykal'); ?></button>
			</div>
		</div>
	</div>
</div>

<!-- Modal for album thumbnail -->
<div id="fg-album-thumbnail-modal" class="fg-modal" tabindex="-1" role="dialog" aria-labelledby="albumThumbnailModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h3 id="albumThumbnailModalLabel"><?php _e('Edit album thumbnail', 'radykal'); ?></h3>
			</div>
			<div class="modal-body">
				<p class="help-block"><?php _e('You can set custom thumbnails for your albums. These thumbnails will be shown when the album selection is set to "Thumbnails".', 'radykal'); ?></p>
				<div id="fg-current-album-thumbnail">
					<h5><?php _e('The current album thumbnail', 'radykal'); ?></h5>
					<img src="" />
				</div>
				<h5><?php _e('Set the album thumbnail', 'radykal'); ?></h5>
				<div class="input-group input-group-sm">
					<span class="input-group-btn">
						<button class="btn btn-danger fg-remove-media-url" type="button"><i class="glyphicon glyphicon-minus-sign"></i></button>
					</span>
					<input type="text" class="form-control" id="fg-modal-album-thumbnail-input" />
					<span class="input-group-btn">
						<button class="btn btn-primary fg-add-from-media-library" type="button"><?php _e('Add from media library', 'radykal'); ?></button>
					</span>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary" id="fg-save-album-thumbnail" <?php fg_disabled_button(); ?>><?php _e('Save Changes', 'radykal'); ?></button>
				<button class="btn btn-default btn-sm fg-close-modal"><?php _e('Cancel', 'radykal'); ?></button>
			</div>
		</div>
	</div>
</div>

<!-- Modal for ajax stuff -->
<div id="fg-ajax-modal">
	<div id="ajax-loader"></div>
</div>
<div class="options-container">
  <h3><?php _e('Layout', 'radykal'); ?></h3>
  <table class="table table-striped table-bordered table-hover">
  	<tbody>
	    <tr>
	      <td><?php _e('Background Color', 'radykal'); ?></td>
	      <td>
	         <input type="text" name="background_color" class="colorpicker" value="<?php echo $options['background_color']; ?>" />
	      </td>
	    </tr>
	    <tr>
	      <td><?php _e('Border Color', 'radykal'); ?></td>
	      <td>
	        <input type="text" name="border_color" class="colorpicker" value="<?php echo $options['border_color']; ?>" />
	      </td>
	    </tr>
	    <tr>
	      <td><?php _e('Title Background Color', 'radykal'); ?></td>
	      <td>
	         <input type="text" name="title_options_background" class="colorpicker" value="<?php echo $options['title_options_background']; ?>" />
	      </td>
	    </tr>
	    <tr>
	      <td><?php _e('Title Color', 'radykal'); ?></td>
	      <td>
	        <input type="text" name="title_options_color" class="colorpicker" value="<?php echo $options['title_options_color']; ?>" />
	      </td>
	    </tr>
	    <tr>
	      <td><?php _e('Theme', 'radykal'); ?></td>
	      <td>
	        <select name="theme">
	          <option value="white" <?php selected($options['theme'], "white"); ?>><?php _e('White', 'radykal'); ?></option>
	          <option value="black" <?php selected($options['theme'], "black"); ?>><?php _e('Black', 'radykal'); ?></option>
	          <option value="blue" <?php selected($options['theme'], "blue"); ?>><?php _e('Blue', 'radykal'); ?></option>
	          <option value="red" <?php selected($options['theme'], "red"); ?>><?php _e('Red', 'radykal'); ?></option>
	          <option value="orange" <?php selected($options['theme'], "orange"); ?>><?php _e('Orange', 'radykal'); ?></option>
	          <option value="green" <?php selected($options['theme'], "green"); ?>><?php _e('Green', 'radykal'); ?></option>
	          <option value="purple" <?php selected($options['theme'], "purple"); ?>><?php _e('Purple', 'radykal'); ?></option>
	        </select>
	      </td>
	    </tr>
	    <tr>
	      <td><?php _e('Thumbnail Width', 'radykal'); ?></td>
	      <td><input type="text" name="thumbnail_width" size="3" maxlength="5" value="<?php echo $options['thumbnail_width']; ?>" /></td>
	    </tr>
	    <tr>
	      <td><?php _e('Thumbnail Height', 'radykal'); ?></td>
	      <td><input type="text" name="thumbnail_height" size="3" maxlength="5" value="<?php echo $options['thumbnail_height']; ?>" /></td>
	    </tr>
	    <tr>
	      <td>
		      <?php _e('Thumbnails per Page', 'radykal'); ?>
		      <span title="<?php _e('Set value to 0 to show all images of album at once.', 'radykal'); ?>" class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="bottom"></span>
		  </td>
	      <td>
	      	<input type="text" name="thumbnails_per_page" size="3" maxlength="5" value="<?php echo $options['thumbnails_per_page']; ?>" />

	      </td>
	    </tr>
	    <tr>
	      <td>
	      	<?php _e('Number of columns', 'radykal'); ?>
	      	<span title="<?php _e('If the value is higher than 0, the column offset will be calculated automatically and the gallery is centered.', 'radykal'); ?>" class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="bottom"></span>
	      </td>
	      <td><input type="text" name="columns" size="3" value="<?php echo esc_textarea($options['columns']); ?>" /></td>
	    </tr>
	    <tr>
	      <td><?php _e('Minimum Column Offset', 'radykal'); ?></td>
	      <td><input type="text" name="column_offset" size="3" maxlength="3" value="<?php echo $options['column_offset']; ?>" /></td>
	    </tr>
	    <tr>
	      <td><?php _e('Row Offset', 'radykal'); ?></td>
	      <td><input type="text" name="row_offset" size="3" maxlength="3" value="<?php echo $options['row_offset']; ?>" /></td>
	    </tr>
	    <tr>
	      <td><?php _e('Border thickness', 'radykal'); ?></td>
	      <td><input type="text" name="border_thickness" size="3" maxlength="2" value="<?php echo $options['border_thickness']; ?>" /></td>
	    </tr>
	    <tr>
	      <td>
	      	<?php _e('Shadow Image', 'radykal'); ?>
	      	<span title="<?php _e('Upload a shadow png that appears under the thumbnail box.', 'radykal'); ?>" class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="bottom"></span>
	      </td>
	      <td>
	      	<div class="input-group input-group-sm">
	      		<span class="input-group-btn">
					<button class="btn btn-danger fg-remove-media-url" type="button"><i class="glyphicon glyphicon-minus-sign"></i></button>
				</span>
				<input type="text" name="shadow_image" class="form-control"value="<?php echo $options['shadow_image']; ?>" />
				<span class="input-group-btn">
					<button class="btn btn-primary fg-add-from-media-library" type="button"><i class="glyphicon glyphicon-plus-sign"></i></button>
				</span>
			</div>

	      </td>
	    </tr>
	    <tr>
	      <td><?php _e('Thumbnail Scale Mode', 'radykal'); ?></td>
	      <td>
	      <?php
			if($_GET['page'] == 'fancy-gallery-generator') {
				echo '<select name="thumbnail_scalemode">
					  <option value="stretch" '.  selected($options['thumbnail_scalemode'], "stretch", false) .'>'.__('Stretch').'</option>
					  <option value="prop" '.selected($options['thumbnail_scalemode'], "prop", false) .'>'.__('Proportional').'</option>
					  <option value="crop" '. selected($options['thumbnail_scalemode'], "crop", false) .'>'.__('Crop').'</option>
					</select>';
			}
			else {
				echo '<select name="thumbnail_zc">
					  <option value="0" '. selected($options['thumbnail_zc'], 0, false) .'>'.__('No Cropping').'</option>
					  <option value="1" '. selected($options['thumbnail_zc'], 1, false) .'>'.__('Best Fit (recommend)').'</option>
					  <option value="2" '. selected($options['thumbnail_zc'], 2, false) .'>'.__('Proportional (gaps)').'</option>
					  <option value="3" '. selected($options['thumbnail_zc'], 3, false) .'>'.__('Proportional (no gaps)').'</option>
					</select>';
			}
		  ?>
	      </td>
	    </tr>
	    <tr>
	      <td>
		      <?php _e('All media selector', 'radykal'); ?>
		      <span title="<?php _e('Enable a button in the album selection to show all media of a gallery by setting a text for it. Leave it empty, when you do not need this button.', 'radykal'); ?>" class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="bottom"></span>
		  </td>
	      <td>
	      	<input type="text" name="all_medias_selector" class="widefat" value="<?php echo $options['all_medias_selector']; ?>" />
	      </td>
	    </tr>
	    <tr>
	      <td><?php _e('Album Selection', 'radykal'); ?></td>
	      <td>
	        <select name="album_selection">
	          <option value="dropdown" <?php selected($options['album_selection'], "dropdown"); ?>>Dropdown</option>
	          <option value="thumbnails" <?php selected($options['album_selection'], "thumbnails"); ?>>Thumbnails</option>
	          <option value="menu" <?php selected($options['album_selection'], "menu"); ?>>Menu</option>
	        </select>
	      </td>
	    </tr>
	    <tr class="<?php echo $options['album_selection'] == 'thumbnails' ? 'active' : ''; ?>">
	      <td><span class="sub-options"><?php _e('Layout', 'radykal'); ?></span></td>
	      <td>
	        <select name="thumbnail_selection_layout">
	          <option value="default" <?php selected($options['thumbnail_selection_layout'], "default"); ?>>Default</option>
	          <option value="polaroid" <?php selected($options['thumbnail_selection_layout'], "polaroid"); ?>>Polaroid</option>
	        </select>
	      </td>
	    </tr>
	    <tr class="<?php echo $options['album_selection'] == 'thumbnails' ? 'active' : ''; ?>">
	      <td>
	      	<span class="sub-options"><?php _e('Thumbnails Width', 'radykal'); ?></span>
	      	<span title="<?php _e('When using polaroid as style, the width is fixed to 151 automatically.', 'radykal'); ?>" class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="bottom"></span>
	      </td>
	      <td>
		      <input type="text" name="thumbnail_selection_width" size="3" maxlength="5" value="<?php echo $options['thumbnail_selection_width']; ?>" />
		  </td>
	    </tr>
	    <tr class="<?php echo $options['album_selection'] == 'thumbnails' ? 'active' : ''; ?>">
	      <td>
	      	<span class="sub-options"><?php _e('Thumbnails Height', 'radykal'); ?></span>
	      	<span title="<?php _e('When using polaroid as style, the width is fixed to 151 automatically.', 'radykal'); ?>" class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="bottom"></span>
	      </td>
	      <td>
		      <input type="text" name="thumbnail_selection_height" size="3" maxlength="5" value="<?php echo $options['thumbnail_selection_height']; ?>" />
		  </td>
	    </tr>
	    <tr  class="<?php echo $options['album_selection'] == 'thumbnails' ? 'active' : ''; ?>">
	      <td><span class="sub-options"><?php _e('Media label', 'radykal'); ?></span></td>
	      <td>
	      	<input type="text" name="media_label" class="widefat" value="<?php echo esc_textarea($options['media_label']); ?>" />
	      </td>
	    </tr>
	    <tr  class="<?php echo $options['album_selection'] == 'thumbnails' ? 'active' : ''; ?>">
	      <td>
	      	<span class="sub-options"><?php _e('Albums per page', 'radykal'); ?></span>
	      	<span title="<?php _e('Set it to 0 to show albums at once.', 'radykal'); ?>" class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="bottom"></span>
	      </td>
	      <td>
	      	<input type="text" name="thumbnail_selection_albumsPerPage" size="3" value="<?php echo $options['thumbnail_selection_albumsPerPage']; ?>" />
	      </td>
	    </tr>
	    <tr>
	      <td><?php _e('Navigation', 'radykal'); ?></td>
	      <td>
	        <select name="navigation">
	          <option value="arrows" <?php selected($options['navigation'], "arrows"); ?>>Arrows</option>
	          <option value="pagination" <?php selected($options['navigation'], "pagination"); ?>>Pagination</option>
	          <option value="dots" <?php selected($options['navigation'], "dots"); ?>>Dots</option>
	        </select>
	      </td>
	    </tr>
	    <tr>
	      <td><?php _e('Navigation Position', 'radykal'); ?></td>
	      <td>
	        <select name="nav_position">
	          <option value="top" <?php selected($options['nav_position'], "top"); ?>><?php _e('Top', 'radykal'); ?></option>
	          <option value="bottom" <?php selected($options['nav_position'], "bottom"); ?>><?php _e('Bottom', 'radykal'); ?></option>
	        </select>
	      </td>
	    </tr>
	    <tr>
	      <td><?php _e('Navigation Alignment', 'radykal'); ?></td>
	      <td>
	        <select name="nav_alignment">
	          <option value="left" <?php selected($options['nav_alignment'], "left"); ?>>Left</option>
	          <option value="center" <?php selected($options['nav_alignment'], "center"); ?>>Center</option>
	          <option value="right" <?php selected($options['nav_alignment'], "right"); ?>>Right</option>
	        </select>
	      </td>
	    </tr>
	    <tr>
	      <td><?php _e('Navigation Previous Button Text', 'radykal'); ?></td>
	      <td><input type="text" name="nav_previous_text" class="widefat" value="<?php echo esc_textarea($options['nav_previous_text']); ?>" /></td>
	    </tr>
	    <tr>
	      <td><?php _e('Navigation Next Button Text', 'radykal'); ?></td>
	      <td><input type="text" name="nav_next_text" class="widefat" value="<?php echo esc_textarea($options['nav_next_text']); ?>" /></td>
	    </tr>
	    <tr>
	      <td><?php _e('"Back to albums" Button Text', 'radykal'); ?></td>
	      <td><input type="text" name="nav_back_text" class="widefat" value="<?php echo esc_textarea($options['nav_back_text']); ?>" /></td>
	    </tr>
	    <tr>
	      <td>
		      <?php _e('Show only first thumbnail of an album', 'radykal'); ?>
		      <span title="<?php _e('This will only show the first thumbnail of an album. Use this if you want to show a whole gallery in the lightbox from just one thumbnail.', 'radykal'); ?>" class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="bottom"></span>
		  </td>
	      <td>
		      <input type="checkbox" name="show_only_first_thumbnail" value="1" <?php checked($options['show_only_first_thumbnail'], 1) ?> />
		  </td>
	    </tr>
	    <tr>
	      <td><?php _e('Album description position', 'radykal'); ?></td>
	      <td>
	      	<select name="album_description_position">
	          <option value="top" <?php selected($options['album_description_position'], "top"); ?>><?php _e('Top', 'radykal'); ?></option>
	          <option value="bottom" <?php selected($options['album_description_position'], "bottom"); ?>><?php _e('Bottom', 'radykal'); ?></option>
	        </select>
	      </td>
	    </tr>
	    <tr>
	      <td>
		      <?php _e('Title Placement', 'radykal'); ?>
		  </td>
	      <td>
		      <select name="title_placement">
		          <option value="outside" <?php selected($options['title_placement'], "outside"); ?>><?php _e('Outside', 'radykal'); ?></option>
		          <option value="inside" <?php selected($options['title_placement'], "inside"); ?>><?php _e('Inside', 'radykal'); ?></option>
	          </select>
		  </td>
	    </tr>
	    <tr>
	      <td>
		      <?php _e('Stretch title to thumbnail width ', 'radykal'); ?>
		      <span title="<?php _e('Only available when title placement is inside.', 'radykal'); ?>" class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="bottom"></span>
		  </td>
	      <td>
		      <input type="checkbox" name="title_options_stretchToWidth" value="1" <?php checked($options['title_options_stretchToWidth'], 1) ?> />
		  </td>
	    </tr>
  	</tbody>
  </table>

  <!-- Hover effects options -->
  <h3><?php _e('Hover Effect', 'radykal'); ?></h3>
  <h4><?php _e('Thumbnail', 'radykal'); ?></h4>
  <div id="hover-effect-switcher" class="form-inline">
	  <div class="radio">
		  <label>
		    <input type="radio" name="thumbnail_hover_effect" value="fadeIn" data-options="fadeIn" <?php checked($options['thumbnail_hover_effect'], "fadeIn"); ?> /> Fade In
		  </label>
	  </div>
	  <div class="radio">
		  <label>
		    <input type="radio" name="thumbnail_hover_effect" value="fadeOut" data-options="fadeOut" <?php checked($options['thumbnail_hover_effect'], "fadeOut"); ?> /> Fade Out
		  </label>
	  </div>
	  <div class="radio">
		  <label>
		    <input type="radio" name="thumbnail_hover_effect" value="filter" data-options="filter" <?php checked($options['thumbnail_hover_effect'], "filter"); ?> /> Filter
		  </label>
	  </div>
	  <div class="radio">
		  <label>
		    <input type="radio" name="thumbnail_hover_effect" value="icon" data-options="icon" <?php checked($options['thumbnail_hover_effect'], "icon"); ?> /> Icon
		  </label>
	  </div>
	  <div class="radio">
		  <label>
		    <input type="radio" name="thumbnail_hover_effect" value="slide" data-options="slide" <?php checked($options['thumbnail_hover_effect'], "slide"); ?> /> Slide
		  </label>
	  </div>
	  <div class="radio">
		  <label>
		    <input type="radio" name="thumbnail_hover_effect" value="scale" data-options="scale" <?php checked($options['thumbnail_hover_effect'], "scale"); ?> /> Scale
		  </label>
	  </div>
	  <div class="radio">
		  <label>
		    <input type="radio" name="thumbnail_hover_effect" value="overlay" data-options="overlay" <?php checked($options['thumbnail_hover_effect'], "overlay"); ?> /> Overlay
		  </label>
	  </div>
	  <div class="radio">
	      <label>
		  	<input type="radio" name="thumbnail_hover_effect" value="direction_aware_hover" data-options="overlay" <?php checked($options['thumbnail_hover_effect'], 'direction_aware_hover') ?> /> Direction Aware
		  </label>
	  </div>
  </div>
  <table id="hover-effects-options" class="table table-striped table-bordered table-hover">
	  <tbody id="fadeIn" class="<?php echo $options['thumbnail_hover_effect'] == 'fadeIn' ? '' : 'hidden'; ?>">
		<tr>
	      <td><?php _e('Opacity', 'radykal'); ?></td>
	      <td><input type="text" name="fadeIn_opacity" size="3" value="<?php echo $options['fadeIn_opacity']; ?>" /></td>
	    </tr>
	  </tbody>
	  <tbody id="fadeOut" class="<?php echo $options['thumbnail_hover_effect'] == 'fadeOut' ? '' : 'hidden'; ?>">
		<tr>
	      <td><?php _e('Opacity', 'radykal'); ?></td>
	      <td><input type="text" name="fadeOut_opacity" size="3" value="<?php echo $options['fadeOut_opacity']; ?>" /></td>
	    </tr>
	  </tbody>
	  <tbody id="filter" class="<?php echo $options['thumbnail_hover_effect'] == 'filter' ? '' : 'hidden'; ?>">
		<tr>
			<td><?php _e('Type', 'radykal'); ?></td>
			<td>
				<select name="filter_type">
					<option value="grayscale" <?php selected($options['filter_type'], "grayscale"); ?> ><?php _e('Grayscale', 'radykal'); ?></option>
					<option value="sepia"<?php selected($options['filter_type'], "sepia"); ?> ><?php _e('Sepia', 'radykal'); ?></option>
					<option value="blur"<?php selected($options['filter_type'], "blur"); ?> ><?php _e('Blur', 'radykal'); ?></option>
					<option value="contrast" <?php selected($options['filter_type'], "contrast"); ?> ><?php _e('Contrast', 'radykal'); ?></option>
					<option value="invert" <?php selected($options['filter_type'], "invert"); ?> ><?php _e('Invert', 'radykal'); ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php _e('Reverse', 'radykal'); ?></td>
			<td><input type="checkbox" name="filter_reverse" value="1" class="control-label" <?php checked($options['filter_reverse'], 1); ?> /></td>
		</tr>
	  </tbody>
	  <tbody id="icon" class="<?php echo $options['thumbnail_hover_effect'] == 'icon' ? '' : 'hidden'; ?>">
		<tr>
			<td><?php _e('Icon URL', 'radykal'); ?></td>
			<td>
				<div class="input-group input-group-sm">
					<input type="text" name="icon_url" class="form-control" value="<?php echo $options['icon_url']; ?>" />
					<span class="input-group-btn">
						<button class="btn btn-primary fg-add-from-media-library" type="button"><i class="glyphicon glyphicon-plus-sign"></i></button>
					</span>
				</div>
			</td>
		</tr>
		<tr>
			<td><?php _e('Transition', 'radykal'); ?></td>
			<td>
				<select name="icon_transition">
					<option value="fade" <?php selected($options['icon_transition'], "fade"); ?> ><?php _e('Fade', 'radykal'); ?></option>
					<option value="l2r"<?php selected($options['icon_transition'], "l2r"); ?> ><?php _e('Left to Right', 'radykal'); ?></option>
					<option value="r2l"<?php selected($options['icon_transition'], "r2l"); ?> ><?php _e('Right to Left', 'radykal'); ?></option>
					<option value="t2b" <?php selected($options['icon_transition'], "t2b"); ?> ><?php _e('Top to Bottom', 'radykal'); ?></option>
					<option value="b2t" <?php selected($options['icon_transition'], "b2t"); ?> ><?php _e('Bottom to Top', 'radykal'); ?></option>
				</select>
			</td>
		</tr>
	  </tbody>
	  <tbody id="slide" class="<?php echo $options['thumbnail_hover_effect'] == 'slide' ? '' : 'hidden'; ?>">
	  	<tr>
		  	<td><?php _e('Overflow', 'radykal'); ?></td>
		  	<td><input type="checkbox" name="slide_overflow" value="1" class="control-label" <?php checked($options['slide_overflow'], 1); ?> /></td>
	  	</tr>
	  </tbody>
	  <tbody id="scale" class="<?php echo $options['thumbnail_hover_effect'] == 'scale' ? '' : 'hidden'; ?>">
	  	<tr>
		  	<td><?php _e('Overflow', 'radykal'); ?></td>
		  	<td><input type="checkbox" name="scale_overflow" value="1" class="control-label" <?php  checked($options['scale_overflow'], 1) ?> /></td>
	  	</tr>
	  	<tr>
		  	<td><?php _e('Direction', 'radykal'); ?></td>
			<td>
				<select name="scale_direction">
				  <option value="down" <?php selected($options['scale_direction'], "down"); ?> ><?php _e('Down', 'radykal'); ?></option>
				  <option value="up"<?php selected($options['scale_direction'], "up"); ?> ><?php _e('Up', 'radykal'); ?></option>
				</select>
			</td>
	  	</tr>
	  </tbody>
	  <tbody id="overlay" class="<?php echo $options['thumbnail_hover_effect'] == 'overlay' || $options['thumbnail_hover_effect'] == 'direction_aware_hover' ? '' : 'hidden'; ?>">
	  	<tr>
	      <td><?php _e('Opacity', 'radykal'); ?></td>
	      <td><input type="text" name="overlay_opacity" size="3" value="<?php echo $options['overlay_opacity']; ?>" /></td>
	    </tr>
	    <tr>
		   <td><?php _e('Background Color', 'radykal'); ?></td>
	      <td>
	         <input type="text" name="overlay_background_color" class="colorpicker" value="<?php echo $options['overlay_background_color']; ?>" />
	      </td>
	    </tr>
	  </tbody>
  </table>

  <h4><?php _e('Title', 'radykal'); ?></h4>
  <div class="form-inline">
	  <div class="radio">
		  <label>
		    <input type="radio" name="title_hover_effect" value="slide" <?php checked($options['title_hover_effect'], "slide"); ?> /> <?php _e('Slide', 'radykal'); ?>
		  </label>
	  </div>
	  <div class="radio">
		  <label>
		    <input type="radio" name="title_hover_effect" value="scale" <?php checked($options['title_hover_effect'], "scale"); ?> /> <?php _e('Scale - only inside', 'radykal'); ?>
		  </label>
	  </div>
	  <div class="radio">
		  <label>
		    <input type="radio" name="title_hover_effect" value="fade" <?php checked($options['title_hover_effect'], "fade"); ?> /> <?php _e('Fade', 'radykal'); ?>
		  </label>
	  </div>
	  <div class="radio">
		  <label>
		    <input type="radio" name="title_hover_effect" value="visible" <?php checked($options['title_hover_effect'], "visible"); ?> /> <?php _e('Visible', 'radykal'); ?>
		  </label>
	  </div>
	  <div class="radio">
		  <label>
		    <input type="radio" name="title_hover_effect" value="none" <?php checked($options['title_hover_effect'], "none"); ?> /> <?php _e('None', 'radykal'); ?>
		  </label>
	  </div>
  </div>

  <!-- Gallery options -->
  <h3><?php _e('Gallery', 'radykal'); ?></h3>
  <div id="gallery-switcher" class="form-inline">
	  <div class="radio">
		  <label>
		    <input type="radio" name="gallery" value="prettyphoto" <?php checked($options['gallery'], "prettyphoto"); ?> /> Prettyphoto
		  </label>
	  </div>
	  <div class="radio">
		  <label>
		    <input type="radio" name="gallery" value="fancybox" <?php checked($options['gallery'], "fancybox"); ?> /> Fancybox
		  </label>
	  </div>
	  <div class="radio">
		  <label>
		    <input type="radio" name="gallery" value="inline" <?php checked($options['gallery'], "inline"); ?> /> Inline Gallery
		  </label>
	  </div>
	  <div class="radio">
		  <label>
		    <input type="radio" name="gallery" value="none" <?php checked($options['gallery'], "none"); ?> /> None
		  </label>
	  </div>
  </div>
  <table id="gallery-options" class="table table-striped table-bordered table-hover">
  	<!-- Prettyphoto options -->
  	<tbody id="prettyphoto" class="<?php echo $options['gallery'] == 'prettyphoto' ? '' : 'hidden'; ?>">
	    <tr>
	      <td><?php _e('Theme', 'radykal'); ?></td>
	      <td>
	        <select name="prettyphoto_theme">
	          <option value="pp_default" <?php selected($options['prettyphoto_theme'], "pp_default"); ?>>Default</option>
	          <option value="light_rounded"<?php selected($options['prettyphoto_theme'], "light_rounded"); ?>>Light rounded</option>
	          <option value="dark_rounded"<?php selected($options['prettyphoto_theme'], "dark_rounded"); ?>>Dark rounded</option>
	          <option value="light_square" <?php selected($options['prettyphoto_theme'], "light_square"); ?>>Light square</option>
	          <option value="dark_square" <?php selected($options['prettyphoto_theme'], "dark_square"); ?>>Dark square</option>
	          <option value="facebook" <?php selected($options['prettyphoto_theme'], "facebook"); ?>>Facebook</option>
	        </select>
	      </td>
	    </tr>
	    <tr>
	      <td><?php _e('Enable overlay gallery', 'radykal'); ?></td>
	      <td><input type="checkbox" name="prettyphoto_overlay" value="1" <?php checked($options['prettyphoto_overlay'], 1) ?> /></td>
	    </tr>
	    <tr>
	      <td><?php _e('Allow image resizing', 'radykal'); ?></td>
	      <td><input type="checkbox" name="prettyphoto_image_resize" value="1" <?php checked($options['prettyphoto_image_resize'], 1); ?> /></td>
	    </tr>
	    <tr>
	      <td><?php _e('Autoplay slideshow', 'radykal'); ?></td>
	      <td><input type="checkbox" name="prettyphoto_slideshow" value="1" <?php checked($options['prettyphoto_slideshow'], 1); ?> /></td>
	    </tr>
  	</tbody>
  	<!-- Fancybox options -->
  	<tbody id="fancybox" class="<?php echo $options['gallery'] == 'fancybox' ? '' : 'hidden'; ?>">
	    <tr>
	      <td><?php _e('Width', 'radykal'); ?></td>
	      <td><input type="text" name="fancybox_width" size="3" maxlength="5" value="<?php echo $options['fancybox_width']; ?>" /></td>
	    </tr>
	    <tr>
	      <td><?php _e('Height', 'radykal'); ?></td>
	      <td><input type="text" name="fancybox_height" size="3" maxlength="5" value="<?php echo $options['fancybox_height']; ?>" /></td>
	    </tr>
	    <tr>
	      <td>
	      	<?php _e('Padding', 'radykal'); ?>
	      	<span title="<?php _e('Space inside fancyBox around content.', 'radykal'); ?>" class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="top"></span>
	      </td>
	      <td><input type="text" name="fancybox_padding" size="3" maxlength="5" value="<?php echo $options['fancybox_padding']; ?>" /></td>
	    </tr>
	    <tr>
	      <td>
	      	<?php _e('Margin', 'radykal'); ?>
	      	<span title="<?php _e('Minimum space between viewport and fancyBox.', 'radykal'); ?>" class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="top"></span>
	      </td>
	      <td><input type="text" name="fancybox_margin" size="3" maxlength="5" value="<?php echo $options['fancybox_margin']; ?>" /></td>
	    </tr>
	    <tr>
	      <td><?php _e('Autoplay', 'radykal'); ?></td>
	      <td><input type="checkbox" name="fancybox_autoplay" value="1" <?php checked($options['fancybox_autoplay'], 1); ?> /></td>
	    </tr>
	    <tr>
	      <td><?php _e('Arrows', 'radykal'); ?></td>
	      <td><input type="checkbox" name="fancybox_arrows" value="1" <?php checked($options['fancybox_arrows'], 1); ?> /></td>
	    </tr>
	    <tr>
	      <td><?php _e('Loop', 'radykal'); ?></td>
	      <td><input type="checkbox" name="fancybox_loop" value="1" <?php checked($options['fancybox_loop'], 1); ?> /></td>
	    </tr>
	    <tr>
	      <td><?php _e('Button Helpers Position', 'radykal'); ?></td>
	      <td>
	        <select name="fancybox_buttons_position">
	          <option value="none" <?php selected($options['fancybox_buttons_position'], "none"); ?>><?php _e('None', 'radykal'); ?></option>
	          <option value="top"<?php selected($options['fancybox_buttons_position'], "top"); ?>><?php _e('Top', 'radykal'); ?></option>
	          <option value="bottom"<?php selected($options['fancybox_buttons_position'], "bottom"); ?>><?php _e('Bottom', 'radykal'); ?></option>
	        </select>
	      </td>
	    </tr>
	    <tr>
	      <td><?php _e('Thumbnail Helpers Position', 'radykal'); ?></td>
	      <td>
	        <select name="fancybox_thumbs_position">
	          <option value="none" <?php selected($options['fancybox_thumbs_position'], "none"); ?>><?php _e('None', 'radykal'); ?></option>
	          <option value="top"<?php selected($options['fancybox_thumbs_position'], "top"); ?>><?php _e('Top', 'radykal'); ?></option>
	          <option value="bottom"<?php selected($options['fancybox_thumbs_position'], "bottom"); ?>><?php _e('Bottom', 'radykal'); ?></option>
	        </select>
	      </td>
	    </tr>
	    <tr>
	      <td><?php _e('Open Effect', 'radykal'); ?></td>
	      <td>
			<select name="fancybox_open_effect">
				<option value="fade" <?php selected($options['fancybox_open_effect'], "fade"); ?>><?php _e('Fade', 'radykal'); ?></option>
				<option value="elastic"<?php selected($options['fancybox_open_effect'], "elastic"); ?>><?php _e('Elastic', 'radykal'); ?></option>
				<option value="none"<?php selected($options['fancybox_open_effect'], "none"); ?>><?php _e('None', 'radykal'); ?></option>
			</select>
	      </td>
	    </tr>
	    <tr>
	      <td><?php _e('Close Effect', 'radykal'); ?></td>
	      <td>
			<select name="fancybox_close_effect">
				<option value="fade" <?php selected($options['fancybox_close_effect'], "fade"); ?>><?php _e('Fade', 'radykal'); ?></option>
				<option value="elastic"<?php selected($options['fancybox_close_effect'], "elastic"); ?>><?php _e('Elastic', 'radykal'); ?></option>
				<option value="none"<?php selected($options['fancybox_close_effect'], "none"); ?>><?php _e('None', 'radykal'); ?></option>
			</select>
	      </td>
	    </tr>
	    <tr>
	      <td><?php _e('Next Effect', 'radykal'); ?></td>
	      <td>
			<select name="fancybox_next_effect">
				<option value="fade" <?php selected($options['fancybox_next_effect'], "fade"); ?>><?php _e('Fade', 'radykal'); ?></option>
				<option value="elastic"<?php selected($options['fancybox_next_effect'], "elastic"); ?>><?php _e('Elastic', 'radykal'); ?></option>
				<option value="none"<?php selected($options['fancybox_next_effect'], "none"); ?>><?php _e('None', 'radykal'); ?></option>
			</select>
	      </td>
	    </tr>
	    <tr>
	      <td><?php _e('Previous Effect', 'radykal'); ?></td>
	      <td>
			<select name="fancybox_previous_effect">
				<option value="fade" <?php selected($options['fancybox_previous_effect'], "fade"); ?>><?php _e('Fade', 'radykal'); ?></option>
				<option value="elastic"<?php selected($options['fancybox_previous_effect'], "elastic"); ?>><?php _e('Elastic', 'radykal'); ?></option>
				<option value="none"<?php selected($options['fancybox_previous_effect'], "none"); ?>><?php _e('None', 'radykal'); ?></option>
			</select>
	      </td>
	    </tr>
  	</tbody>
  	<!-- Inline Gallery options -->
  	<tbody id="inline" class="<?php echo $options['gallery'] == 'inline' ? '' : 'hidden'; ?>">
	    <tr>
	      <td><?php _e('Width', 'radykal'); ?></td>
	      <td><input type="text" name="inline_gallery_width" size="3" maxlength="5" value="<?php echo $options['inline_gallery_width']; ?>" /></td>
	    </tr>
	    <tr>
	      <td><?php _e('Height', 'radykal'); ?></td>
	      <td><input type="text" name="inline_gallery_height" size="3" maxlength="5" value="<?php echo $options['inline_gallery_height']; ?>" /></td>
	    </tr>
	    <tr>
	      <td><?php _e('Youtube Parameters', 'radykal'); ?></td>
	      <td><input type="text" name="inline_gallery_youtube_parameters" value="<?php echo $options['inline_gallery_youtube_parameters']; ?>"  /></td>
	    </tr>
	    <tr>
	      <td><?php _e('Vimeo Parameters', 'radykal'); ?></td>
	      <td><input type="text" name="inline_gallery_vimeo_parameters" value="<?php echo $options['inline_gallery_vimeo_parameters']; ?>"  /></td>
	    </tr>
	    <tr>
	      <td><?php _e('Show first media', 'radykal'); ?></td>
	      <td><input type="checkbox" name="inline_gallery_show_first_media" value="1" <?php checked($options['inline_gallery_show_first_media'], 1); ?> /></td>
	    </tr>
  	</tbody>
  	<!-- None Gallery options -->
  	<tbody id="none" class="<?php echo $options['gallery'] == 'none' ? '' : 'hidden'; ?>">
  		<tr>
	      <td><?php _e('Target Window', 'radykal'); ?></td>
	      <td>
		      <select name="none_gallery_target_window">
				  <option value="_blank" <?php selected($options['none_gallery_target_window'], "_blank"); ?>><?php _e('New Window', 'radykal'); ?></option>
				  <option value="_self"<?php selected($options['none_gallery_target_window'], "_self"); ?>><?php _e('Same Window', 'radykal'); ?></option>
		      </select>
	      </td>
	    </tr>
  	</tbody>
  </table>

  <h3><?php _e('Social Buttons', 'radykal'); ?></h3>
  <table id="social-options" class="table table-striped table-bordered table-hover">
  	<!-- Prettyphoto options -->
  	<tbody>
  		<tr>
	      <td><?php _e('Facebook Like Button', 'radykal'); ?></td>
	      <td><input type="checkbox" name="facebook_like_button" value="1" <?php checked($options['facebook_like_button'], 1); ?> /></td>
	    </tr>
	    <tr>
	      <td><?php _e('Tweet Button', 'radykal'); ?></td>
	      <td><input type="checkbox" name="tweet_button" value="1" <?php checked($options['tweet_button'], 1); ?> /></td>
	    </tr>
	    <tr>
	      <td><?php _e('Pin It Button', 'radykal'); ?></td>
	      <td><input type="checkbox" name="pin_it_button" value="1" <?php checked($options['pin_it_button'], 1); ?> /></td>
	    </tr>
  	</tbody>
  </table>

</div>
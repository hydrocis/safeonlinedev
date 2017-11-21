<div class="wrap">
  <h2><?php _e('Your HTML Code', 'radykal'); ?></h2>
  <?php
    $gallery = trim($_POST['selected_gallery']);

    //get albums of the gallery corresponding to the ID
	$albums = $this->wpdb->get_results("SELECT * FROM {$this->album_table_name} WHERE gallery_id='$gallery' ORDER BY sort ASC");

  ?>
  <p class="help-block">Copy this code and paste in your head tag:</p>
  <textarea rows="20" class="form-control">
<?php
echo htmlentities("<!-- Style Sheets -->");
echo "\n";
if($options['gallery'] == 'prettyphoto') {
	echo htmlentities("<link rel='stylesheet' href='" . plugins_url('/radykal-fancy-gallery/prettyphoto/css/prettyPhoto.css') . "' />");
	echo "\n";
}
else if($options['gallery'] == 'fancybox') {
	echo htmlentities("<link rel='stylesheet' href='" . plugins_url('/radykal-fancy-gallery/fancybox/jquery.fancybox.css') . "' />");
	echo "\n";
	echo htmlentities("<link rel='stylesheet' href='" . plugins_url('/radykal-fancy-gallery/fancybox/helpers/jquery.fancybox-buttons.css') . "' />");
	echo "\n";
	echo htmlentities("<link rel='stylesheet' href='" . plugins_url('/radykal-fancy-gallery/fancybox/helpers/jquery.fancybox-thumbs.css') . "' />");
	echo "\n";
}
else if($options['gallery'] == 'inline') {
	echo htmlentities("<link rel='stylesheet' href='" . plugins_url('/mejs/mediaelementplayer.css') . "' />");
	echo "\n";
	echo htmlentities("<link rel='stylesheet' href='" . plugins_url('/mejs/mejs-skins.css') . "' />");
	echo "\n";
}

echo htmlentities("<link rel='stylesheet' href='" . plugins_url('/radykal-fancy-gallery/css/jquery.fancygallery.css') . "' />");
echo "\n";
echo htmlentities("<link rel='stylesheet' href='http://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css' />");
echo "\n\n";

echo htmlentities("<!-- Javascript Files -->");
echo "\n";
echo htmlentities("<script src='http://code.jquery.com/jquery-latest.min.js' type='text/javascript'></script>");
echo "\n";
if($options['gallery'] == 'prettyphoto') {
	echo htmlentities("<script src='". plugins_url('/radykal-fancy-gallery/prettyphoto/jquery.prettyPhoto.js') ."' type='text/javascript'></script>");
	echo "\n";
}
else if($options['gallery'] == 'fancybox') {
	echo htmlentities("<script src='". plugins_url('/radykal-fancy-gallery/fancybox/jquery.fancybox.pack.js') ."' type='text/javascript'></script>");
	echo "\n";
	echo htmlentities("<script src='". plugins_url('/radykal-fancy-gallery/fancybox/helpers/jquery.fancybox-media.js') ."' type='text/javascript'></script>");
	echo "\n";
	echo htmlentities("<script src='" . plugins_url('/radykal-fancy-gallery/fancybox/helpers/jquery.fancybox-buttons.js') . "' type='text/javascript'></script>");
	echo "\n";
	echo htmlentities("<script src='" . plugins_url('/radykal-fancy-gallery/fancybox/helpers/jquery.fancybox-thumbs.js') . "' type='text/javascript'></script>");
	echo "\n";
}
else if($options['gallery'] == 'inline') {
	echo htmlentities("<script src='" . plugins_url('/mejs/mediaelement-and-player.min.js') . "' type='text/javascript'></script>");
	echo "\n";
}

echo htmlentities("<script src='". plugins_url('/radykal-fancy-gallery/js/svg.min.js') ."' type='text/javascript'></script>");
echo "\n";
echo htmlentities("<script src='". plugins_url('/radykal-fancy-gallery/js/jquery.fancygallery.min.js') ."' type='text/javascript'></script>");

echo "\n\n";
echo htmlentities("<!-- Calling the plugin -->");
echo "\n";

echo $this->get_js_code($options, 'fancygallery-' . $gallery, '');
  ?>
  </textarea>
  <br /><br />
  <p class="help-block"><?php _e('Copy this code and paste it in your body tag:', 'radykal'); ?></p>
  <textarea rows="30" class="form-control">
<?php
echo htmlentities("<div id='fancygallery-$gallery'>\n");

foreach($albums as $album) {
	$thumbnail = '';
	if($album->thumbnail && $options['album_selection'] == 'thumbnails') {
		$thumbnail = plugins_url('/admin/timthumb.php', __FILE__).'?src='.urlencode($album->thumbnail).'&w='.$thumbnails_selection_width.'&h='.$thumbnails_selection_height.'&zc=1&q=100&s=1';
	}
	echo htmlentities("  <div title='{$album->title}' data-thumbnail='{$album->thumbnail}'>\n");

	$album_files = $this->wpdb->get_results("SELECT * FROM {$this->images_table_name} WHERE album_id='{$album->ID}' ORDER BY sort ASC");
	if($album->description) { echo '    <div>'.stripslashes(htmlspecialchars_decode($album->description)).'</div>'; }
	echo "\n";
	foreach($album_files as $album_file) {
		echo '      '.htmlentities($this->get_media_link($album_file->file, $album_file->thumbnail, $options['thumbnail_width'], $options['thumbnail_height'], $options['thumbnail_zc'], $album_file->title, $album_file->description));
    echo "\n";
	}

	echo htmlentities("  </div>\n");
}
echo htmlentities("</div>");
  ?>
  </textarea>
</div>
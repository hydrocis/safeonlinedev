
//-----------Document ready----------

jQuery(document).ready(function($) {

	$ = jQuery.noConflict();

	$('textarea').focus(function() {
		$(this).select();
	});

	//add active class to current gallery item in accordion
	$('#galleries-accordion > li > div[id="'+$('input[name="selected_gallery"]').val()+'"]').addClass('active');

	//show active lightbox options
	$('table#lightbox-options tbody.active').show();

	//show active thumbnails selection options
	$('select[name="album_selection"]').parent().parent().nextAll(':lt(5)').hide();
	$('table tr.active').show();

	//submit form with selected gallery
	$('#galleries-accordion > li > div, .fg-paste-options').click(function() {
		var $this = $(this);
		if($this.is('a')) {
			if( $this.parent().parent().attr('id') != $('input[name="selected_gallery"]').val() && $('.wrap').hasClass('fg-disable-links') ) {
				$('input[name="overwrite_gallery"]').val($this.parent().parent().attr('id'));
				$('#fg-options-form').submit();
			}
		}
		else {
			if( $this.attr('id') != $('input[name="selected_gallery"]').val() ) {
				$('input[name="selected_gallery"]').val($this.attr('id'));
				$('#fg-options-form').submit();
			}
		}

		return false;
	});

	//show selected lightbox options
	$('input[name="gallery"]').change(function() {
		$('#gallery-options').children('tbody').addClass('hidden').filter('#'+this.value).removeClass('hidden');
		if(this.value == 'prettyphoto' || this.value == 'fancybox') {
			$('#social-options').show().prev('h3').show();
		}
		else {
			$('#social-options').hide().prev('h3').hide();
		}
	});

	//show selected thumbnail hover effect options
	$('input[name="thumbnail_hover_effect"]').change(function() {
		$('#hover-effects-options').children('tbody').addClass('hidden').filter('#'+$(this).data('options')).removeClass('hidden');
	});

	//show thumbnails dimension for default
	$('[name="thumbnail_selection_layout"]').change(function() {

		if($(this).val() == 'default' && $('select[name="album_selection"]').val() == 'thumbnails') {
			$('[name="thumbnail_selection_width"],[name="thumbnail_selection_height"]').parents('tr').show();
		}
		else {
			$('[name="thumbnail_selection_width"],[name="thumbnail_selection_height"]').parents('tr').hide();
		}

	}).change();

	//show selected lightbox options
	$('select[name="album_selection"]').change(function() {

		if($(this).val() == 'thumbnails') {
			$(this).parent().parent().nextAll(':lt(5)').addClass('active').show();
		}
		else {
			$(this).parent().parent().nextAll(':lt(5)').removeClass('active').hide();
		}

		$('[name="thumbnail_selection_layout"]').change();

	}).change();

	if($('.wrap').hasClass('disabled')) {
		$('.btn-primary, btn-default').click(function() {
			return false;
		});
    }

});
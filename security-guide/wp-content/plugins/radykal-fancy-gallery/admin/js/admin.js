
//-----------Document ready----------

jQuery(document).ready(function($) {

	var mediaUploader = $currentMediaInput = null;

	//add a media from the media library and assign media url to input
    $('.fg-add-from-media-library').click(function() {

    	if(wp == undefined || wp.media == undefined) {
	    	alert('The new media uploader is only available since Wordpress 3.5!');
	    	return false;
    	}

    	$currentMediaInput = $(this).parents('.input-group').children('input[type="text"]');

    	if (mediaUploader) {
            mediaUploader.open();
            return;
        }

    	mediaUploader = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });

        mediaUploader.on('select', function() {
        	var attachment = mediaUploader.state().get('selection').first().changed.url;
        	$currentMediaInput.val(attachment).change();
        });

		mediaUploader.open();

	    return false;
    });

    //remove the media url from the input
    $('.fg-remove-media-url').click(function() {
		$(this).parents('.input-group').children('input[type="text"]').val('').change();
		return false;
    });

	//set colorpickers
	if($(document).find('.colorpicker').length) {
		$('.colorpicker').spectrum({
			color: $(this).val(),
			preferredFormat: "hex",
			showInput: true,
			chooseText: "Change Color",
			change: function(color) {
				$(this).val(color.toHexString());
			}
		});
	}

	//disable all links
	if($(document).find('.fg-disable-links').length) {
		disableLinks = true;
		var galleriesAccordion = $('#galleries-accordion'),
			accordion_body = $('#galleries-accordion li > .sub-menu');
		$('.fg-disable-links').find('.button-secondary, .button-primary, .upload-button, .fg-button').unbind().fadeTo(0, 0.5);
		galleriesAccordion.undelegate('.fg-add-album', 'click');
		galleriesAccordion.undelegate('.fg-delete', 'click');
		galleriesAccordion.undelegate('.fg-edit', 'click');
		galleriesAccordion.undelegate('.fg-edit-album-description', 'click');
		$('.fg-disable-links').find('input:submit').attr('disabled', 'disabled');
		if(accordion_body.size() > 0) {
			accordion_body.sortable('disable');
		}
		$('.fg-paste-options').die('click');
	};


	$('.fg-close-modal').click(function() {
		$(this).parents('.fg-modal').removeClass('fg-show');
	});

});
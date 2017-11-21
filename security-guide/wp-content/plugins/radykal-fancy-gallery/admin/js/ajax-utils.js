
function toggleAjaxLoading() {
	var $ajaxModal = jQuery('#fg-ajax-modal');

	if($ajaxModal.is(':hidden')) {
		$ajaxModal.show();
	}
	else {
		$ajaxModal.hide();
	}

};

function showSuccessBox(txt) {
	jQuery('#fg-success-alert')
	.css({left: jQuery(window).width() * 0.5 - 200})
	.removeClass('hidden')
	.fadeIn(300)
	.stop(true, true).children('p').text(txt)
	.parent().delay(2500).fadeOut(300);
};

function getResponseMessage(res) {
	var msg = '';
	if(res.errors) {
		jQuery.each(res.responses, function() {
			jQuery.each(this.errors, function() {
				msg += this.message + '\n';
			});
		});
	}
	else {
		if(res.responses) {
			msg = res.responses[0].data;
		}
		else {
			msg = "Success!";
		}
	}
	return msg;
};

function getSupplemental(res) {
	var supplemental = {};
	if(!res.errors) {
		if(res.responses) {
			supplemental = res.responses[0].supplemental;
		}
	}
	return supplemental;
};
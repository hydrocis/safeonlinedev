(function( $ ) {
	function twoLightCoverQRCode() {
		$( '.twofas-light-uncover-button' ).show();
		$( '#qr_code' ).addClass( 'twofas-light-opacity' );
	}

	function twoLightScrollToTop() {
		$(function() {
			$( 'body' ).scrollTop( 0 );
		});
	}

	function twoLightAddErrorNotification( content ) {
		var notification = '<div class="notice notice-error is-dismissible error">' +
			'<p>' + content + '</p><button class="notice-dismiss" type="button"></button></div>';

		$( '#twofas-light-notifications' ).html( notification );

		twoLightScrollToTop();
	}

	function twoLightAddSuccessNotification( content ) {
		var notification = '<div class="notice notice-success is-dismissible updated">' +
			'<p>' + content + '</p><button class="notice-dismiss" type="button"></button></div>';

		$( '#twofas-light-notifications' ).html( notification );

		twoLightScrollToTop();
	}

	function twoLightDeleteCookie( name ) {
		document.cookie = name + '=;expires=Thu, 01 Jan 1970 00:00:01 UTC;path=/';
	}

	var showSecretButton = $( '#twofas-light-show-totp-private-key-button' );
	var uncoverButton    = $( '.twofas-light-uncover-button' );
	var reloadButton     = $( '.twofas-light-reload-qr-code' );
	var loginForm        = $( '#twofas-light-loginform' );

	if ( showSecretButton.length ) {
		showSecretButton.click(function() {
			$( '#twofas-light-totp-private-key' ).show();
		});
	}

	if ( uncoverButton.length ) {
		uncoverButton.click(function() {
			$( this ).hide();
			$( '#qr_code' ).removeClass( 'twofas-light-opacity' );
		});
	}

	if ( loginForm.length ) {
		loginForm.submit(function() {
			$( '#wp-submit' ).prop('disabled', 'disabled');
		});
	}

	// Close notification
	$( document ).on( 'click', '.notice-dismiss', function() {
		$( this ).parent().hide();
	});

	// Reload QR Code
	if ( reloadButton.length ) {
		reloadButton.click( function() {
			reloadButton.prop( 'disabled', 'disabled' );

			jQuery.ajax({
				url: twofas_light.ajax_url,
				type: 'post',
				data: {
					'page': twofas_light.twofas_light_menu_page,
					'twofas_light_action': 'twofas_light_reload_qr_code',
					'action': 'twofas_light_ajax',
					'security': $( '#_wpnonce' ).val()
				},
				success: function( response ) {
					response = JSON.parse( response );
					var totp_secret = response[ 'twofas_light_totp_secret' ];
					var qr_code = response[ 'twofas_light_qr_code' ];

					reloadButton.prop( 'disabled', false );
					$( '#qr_code' ).attr( 'src', qr_code );
					$( '#totp_secret' ).html( totp_secret );
					$( '#totp_secret_field' ).attr( 'value', totp_secret );
				}
			});
		} );
	}

	// Remove trusted device
	$( document ).on( 'click', '.twofas-light-remove-device-button', function() {
		var deviceId = $( this ).attr( 'data-device' );

		$( this ).addClass( 'twofas-light-disabled' );
		$( this ).addClass( 'twofas-light-not-clickable' );

		$.ajax({
			url: twofas_light.ajax_url,
			type: 'post',
			data: {
				'device_id': deviceId,
				'page': twofas_light.twofas_light_menu_page,
				'twofas_light_action': 'twofas_light_remove_trusted_device',
				'action': 'twofas_light_ajax',
				'security': $( '#_wpnonce' ).val()
			},
			success: function( response ) {
				response = JSON.parse( response );
				var result = response['twofas_light_result'];

				$( this ).removeClass( 'twofas-light-disabled' );
				$( this ).removeClass( 'twofas-light-not-clickable' );

				if ( 'success' !== result ) {
					return;
				}

				$( '.twofas-light-trusted-devices' ).html( response['twofas_light_trusted_devices'] );

				twoLightDeleteCookie( response['device_id'] );
				twoLightAddSuccessNotification( 'Trusted device has been removed' );
			}
		});
	});

	// Enable/disable TOTP
	$( document ).on( 'click', '#enable-disable-slider', function() {
		$( '#twofas-light-status-label-status' ).addClass( 'twofas-light-disabled' );
		$( '#enable-disable-slider' ).addClass( 'twofas-light-not-clickable' );

		$.ajax({
			url: twofas_light.ajax_url,
			type: 'post',
			data: {
				'page': twofas_light.twofas_light_menu_page,
				'twofas_light_action': 'twofas_light_totp_enable_disable',
				'action': 'twofas_light_ajax',
				'security': $( '#_wpnonce' ).val()
			},
			success: function( response ) {
				response = JSON.parse( response );

				$( '#twofas-light-status-label-status' ).removeClass( 'twofas-light-disabled' );
				$( '#enable-disable-slider' ).removeClass( 'twofas-light-not-clickable' );

				if ( 'success' !== response['twofas_light_result'] ) {
					return;
				}

				var status = response['twofas_light_totp_status'];

				if ( 'totp_enabled' === status ) {
					var enabled = '<span class="twofas-light-status-label">Status: </span>' +
						'<span id="twofas-light-status-label-status" class="twofas-light-green">' +
						'ENABLED' +
						'</span>';

					$( '#twofas-light-status-wrapper' ).html( enabled );
					$( '#twofas-light-status-description' ).html( 'Turn off two factor authentication' );
				}

				if ( 'totp_disabled' === status ) {
					var disabled = '<span class="twofas-light-status-label">Status: </span>' +
						'<span id="twofas-light-status-label-status" class="twofas-light-red">' +
						'DISABLED' +
						'</span>';

					$( '#twofas-light-status-wrapper' ).html( disabled );
					$( '#twofas-light-status-description' ).html( 'Turn on two factor authentication' );
				}
			}
		});
	});

	// Configure TOTP
	$( '#totp-form' ).submit(function() {
		var totp_token = $( '#totp_token_field' ).val();
		var totp_secret = $('#totp_secret_field').val();

		$( '#twofas-light-configure-submit-wrapper' ).addClass( 'twofas-light-disabled' );
		$( '.twofas-light-configure-button' ).addClass( 'twofas-light-not-clickable' );

		jQuery.ajax({
			url: twofas_light.ajax_url,
			type: 'post',
			data: {
				'page': twofas_light.twofas_light_menu_page,
				'twofas_light_action': 'twofas_light_configure_totp',
				'action': 'twofas_light_ajax',
				'security': jQuery( '#_wpnonce' ).val(),
				'twofas_light_totp_secret': totp_secret,
				'twofas_light_totp_token': totp_token
			},
			success: function( response ) {
				response = JSON.parse( response );

				var result = response['twofas_light_result'];

				if (  'success' === result ) {
					$( '.twofas-light-trusted-devices' ).html( response['twofas_light_trusted_devices'] );
					$( '.twofas-light-status-label' ).html( 'Status: <span class="twofas-light-green">ENABLED</span>' );
					$( '.totp-enable-disable' ).prop( 'checked', true );
					$( '#totp_token_field' ).val( '' );

					twoLightAddSuccessNotification( 'Two factor authentication has been configured successfully' );
					twoLightCoverQRCode();

					var toggleSwitch = '<span id="twofas-light-status-description">' +
						'Turn off two factor authentication: </span>' +
						'<div class="twofas-light-toggle-switch">' +
						'<input id="totp-disable" class="totp-enable-disable" type="checkbox" checked="checked" />' +
						'<label for="totp-disable" id="enable-disable-slider"></label>' +
						'</div>';

					var status = '<span class="twofas-light-status-label">Status: </span>' +
						'<span id="twofas-light-status-label-status" class="twofas-light-green">' +
						'ENABLED' +
						'</span>';

					$( '.twofas-light-slider-wrapper' ).html( toggleSwitch );
					$( '#twofas-light-status-wrapper' ).html( status );
				} else {
					twoLightAddErrorNotification( 'Token is invalid' );
				}

				$( '#twofas-light-configure-submit-wrapper' ).removeClass( 'twofas-light-disabled' );
				$( '.twofas-light-configure-button' ).removeClass( 'twofas-light-not-clickable' );
			}
		});

		return false;
	});
})( jQuery );

var disableLinks = false;

//-----------Document ready----------
jQuery(document).ready(function($) {

	var notification = $('#fg-notification'),
		galleriesAccordion = $('#galleries-accordion'),
		galleries = $('#galleries-accordion > li > div'),
   		accordion_body = $('#galleries-accordion li > .sub-menu')
   		currentGallery = galleries.first().attr('id'),
   		currentAlbum = $('#galleries-accordion > li:first').children('.sub-menu:first').find('li > div').attr('id'),
   		loadingIndex = 0,
   		filesLength = 0,
   		currentAlbumDescription = null,
   		currentAlbumThumbnail = null;

   	currentGallery = currentGallery === undefined ? null : currentGallery;
   	currentAlbum = currentAlbum === undefined ? null : currentAlbum;

   	// Open the first tab on load
    galleries.first().addClass('active').next('.sub-menu').slideDown('normal');

   	$('#mediaList').sortable();

   	//init sortable for image list
	accordion_body.sortable({
		connectWith: '.sub-menu',
		placeholder: 'fg-placeholder',
		start: function() {
			accordion_body.css({'min-height': 2}).filter($('.gallery-item:not(.active)').next('.sub-menu')).slideDown(0).sortable('refresh');
		},
		stop: function() {
			accordion_body.css({'min-height': 0}).filter($('.gallery-item:not(.active)').next('.sub-menu')).slideUp(100);
		},
		update: function(evt, ui) {

			if($('.wrap').hasClass('disabled')) {
		    	return false;
	    	}

			if(ui.sender == null) {

				var targetList = ui.item.parent(),
					albumId = ui.item.children('div').attr('id'),
					targetGallery = targetList.parent().children('.gallery-item').attr('id'),
					albums = [];


				targetList.children('li').children('div').each(function() {
					albums.push($(this).attr('id'));
				});

				toggleAjaxLoading();
				albumMovedToAnotherGallery = true;
				$.ajax({ url: options.Ajax_Url, data: { action: 'updatealbums', oldGallery: currentGallery, newGallery: targetGallery,  albums: albums, albumId: albumId }, type: 'post', success: function(data) {

					var res = wpAjax.parseAjaxResponse(data, 'ajax-response');
					var msg = getResponseMessage(res);

					if(!res.errors) {
						if(currentGallery != targetGallery) {
							if(currentAlbum == albumId) {
								$('#mediaList').empty();
								currentAlbum = null;
							}
						}

						showSuccessBox(msg);
					}
					else {
						alert(msg);
					}

					toggleAjaxLoading();

				  }
				});
			}
		}
	}).disableSelection();

	//start upload process
	$('#upload-images-button').click(function() {

		if($('.wrap').hasClass('disabled')) {
	    	return false;
    	}

		if(checkIds()) {
			alert(checkIds());
			return false;
		}

		$('#image-upload-form').fileupload('option',{formData: {action: 'uploadfile', security: options.uploadNonce, albumDir: currentGallery + '/' + currentAlbum + '/'}});

		$('#image-upload-form input').click();
		return false;
	});

	//get alert box
	var alertBox = $('#fg-alert > button').click(function() {
		$(this).parent().slideUp(200).children('ul').empty();
		return false;
	}).parent();


    //opens the window to select the images
    $('#image-upload-form').fileupload({
		url: options.Ajax_Url,
		sequentialUploads: true,
		acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
		change: function(e, data) {
			toggleAjaxLoading();
			loadingIndex = filesLength = 0;
		},
		add: function(e, data) {
			data.submit()
			.success(function(result, textStatus, jqXHR) {
				var filename = result.filename;
				if(textStatus == "success" && result.error == 0) {
					var file = '/fancygallery/'+currentGallery+"/"+currentAlbum+"/"+result.realFile;
					$.ajax({
						url: options.Ajax_Url,
						data: {
							action: 'savefile',
							album: currentAlbum,
							file: file,
							thumbnail: file,
							title: $('#titles-from-filenames').is(':checked') ? filename : '',
							sortId: $('#mediaList li').size()

						},
						type: 'post',
						dataType: 'json',
						success: function(data) {
							addListItem('append', data.ID, file, file, $('#titles-from-filenames').is(':checked') ? filename : '', '');

						}
					});
				}else {
					var errorMessage = "Upload failed";
					if(result.message) {
						errorMessage = result.message;
					}

					if(alertBox.is(':hidden')) { alertBox.slideDown(300); }
					if(result.error == 1) {
						alertBox.children('ul').append('<li><i class="glyphicon glyphicon-remove-circle"></i>'+errorMessage+'</li>');
					}
					else if(result.error == 2) {
						alertBox.children('ul').append('<li><i class="glyphicon glyphicon-remove-circle"></i><strong>'+filename+': </strong>'+errorMessage+'</li>');
					}

				}

				++loadingIndex;
				if(loadingIndex == filesLength) {
					//all images stored
					toggleAjaxLoading();
					if(!errorMessage) {
						notification.text('Upload completed!');
					}
					else {
						notification.text('Completed, but with errors!');
					}

				}
			})
			.error(function (jqXHR, textStatus, errorThrown) {
		        if (errorThrown === 'abort') {
		            //console.log('File Upload has been canceled');
		        }
	        })
		},
		send: function(e, data) {
			filesLength = data.originalFiles.length;
			notification.html('Loading: '+data.originalFiles[loadingIndex].name + ' - <strong>' + (loadingIndex+1) + '/' + filesLength + '</strong>');
		}
    });

    //upload other media modal

     //upload another media
	$('#upload-media-button').click(function(evt) {

		if(checkIds()) {
			alert(checkIds());
			return false;
		}

		$('#fg-upload-other-modal').addClass('fg-show');

	});

    $('.fg-modal-media').on('change', function() {

    	var type = getFileType(this.value),
    		$this = $(this),
    		$thumbnailInput = $this.parent().parent().find('.fg-modal-thumbnail'),
    		con = $this.parent().nextAll('.fg-load-from-container:first'),
    		label = con.children('label'),
    		$checkbox = label.children('input');

    	if(type == 'youtube' || type == 'vimeo') {

	    	label.children('span:first').html(label.data('text')+'<strong>'+type+'.com</strong> ?');
	    	$checkbox.unbind('change').change(function() {
		    	if($(this).is(':checked')) {
		    		var thumbnailSrc;

		    		//load thumbnail from youtube
			    	if(type == 'youtube') {
				    	var ytId = getParam($this.val(), 'v');
				    	$thumbnailInput.val('http://img.youtube.com/vi/'+ytId+'/0.jpg');
			    	}
			    	//load thumbnail from vimeo
			    	else if(type == 'vimeo') {
			    		toggleAjaxLoading();
				    	var vimeoId = /vimeo.*\/(\d+)/i.exec( $this.val() );
						vimeoId = vimeoId[1];

						if(vimeoId && vimeoId.length > 0) {
							//get thumbnail from json
							var timestamp = new Date().getTime();
							$.ajax({
								type: 'POST',
								dataType: 'jsonp',
								url: 'http://vimeo.com/api/v2/video/'+vimeoId+'.json?callback='+timestamp+''
							}).done(function(data) {
								$thumbnailInput.val(data[0].thumbnail_large);
								toggleAjaxLoading();
							});

						}
			    	}

		    	}
		    	else {
			    	$thumbnailInput.val('');
		    	}
	    	});

	    	con.removeClass('hidden');
    	}
    	else {
	    	con.addClass('hidden');
    	}

    });

    $('#fg-add-media').click(function() {

    	if($('.wrap').hasClass('disabled')) {
	    	return false;
    	}

	    var $this = $(this),
	    	$modalContent = $this.parent().parent(),
	    	media = $modalContent.find('.fg-modal-media').val(),
	    	thumbnail = $modalContent.find('.fg-modal-thumbnail').val();

	     if(media == null || media.length == 0) {
	     	alert('Please set a media!');
	     	return false;
	     }

	     if(thumbnail == null || thumbnail.length == 0) {
	     	alert('Please set a thumbnail!');
	     	return false;
	     }

	     toggleAjaxLoading();

	      $.ajax({
			url: options.Ajax_Url,
			data: {
				action: 'savefile',
				gallery: currentGallery,
				album: currentAlbum,
				file: media,
				thumbnail: thumbnail,
				title: '',
				sortId: $('#mediaList li').size()
			},
			type: 'post',
			dataType: 'json',
			success: function(data) {
				addListItem('append', data.ID, media, thumbnail, '', '');
				toggleAjaxLoading();
				$('#fg-upload-other-modal .fg-modal-media').val('');
				$('#fg-upload-other-modal .fg-modal-thumbnail').val('');
				$('#fg-upload-other-modal').removeClass('fg-show');
				showSuccessBox('Media successfully uploaded!');
			}
		  });

	     return false;

    });

     $('#mediaList').on('click', '.fg-edit-media', function() {
		$('#fg-edit-media-modal').addClass('fg-show');

		$currentMediaItem = $(this);

		var $editMediaModal = $(' #fg-edit-media-modal');

		$editMediaModal.find('.fg-load-from-container').addClass('hidden').find('input').prop('checked', false);
		$editMediaModal.find('.fg-modal-media').val($currentMediaItem.nextAll('[name="files[]"]').val());
    	$editMediaModal.find('.fg-modal-thumbnail').val($currentMediaItem.nextAll('[name="thumbnails[]"]').val());
    	$editMediaModal.find('textarea').val($currentMediaItem.nextAll('[name="descriptions[]"]').val());
    	$editMediaModal.find('#fg-update-media').data('id', $currentMediaItem.nextAll('[name="ids[]"]').val());

		return false;
    });

    $('#mediaList').on('change', '[name="titles[]"]', function(evt) {

    	if($('.wrap').hasClass('disabled')) {
	    	return false;
    	}

    	var mediaId = $(this).nextAll('[name="ids[]"]').val();

		$.ajax({
			url: options.Ajax_Url,
			data: {
				action: 'editmediatitle',
				id: mediaId,
				title: this.value
			},
			type: 'post',
			dataType: 'json',
			success: function(data) {
				showSuccessBox(data.data);
			}
		  });

    });

    $('#fg-update-media').click(function() {

    	if($('.wrap').hasClass('disabled')) {
	    	return false;
    	}

	    var $this = $(this),
	    	$modalContent = $this.parent().parent(),
	    	media = $modalContent.find('.fg-modal-media').val(),
	    	thumbnail = $modalContent.find('.fg-modal-thumbnail').val();

	     if(media == null || media.length == 0) {
	     	alert('Please set a media!');
	     	return false;
	     }

	     if(thumbnail == null || thumbnail.length == 0) {
	     	alert('Please set a thumbnail!');
	     	return false;
	     }
	     toggleAjaxLoading();

	      $.ajax({
			url: options.Ajax_Url,
			data: { action: 'updatemedia', albumId: currentAlbum, id: $this.data('id'), file: media, thumbnail: thumbnail, description: $modalContent.find('textarea').val()},
			type: 'post',
			dataType: 'json',
			success: function(data) {
				$currentMediaItem.nextAll('[name="files[]"]').val(media);
				$currentMediaItem.nextAll('[name="thumbnails[]"]').val(thumbnail);
				$currentMediaItem.nextAll('img').attr('src', thumbnail);
				$currentMediaItem.nextAll('[name="descriptions[]"]').val($modalContent.find('textarea').val());
				toggleAjaxLoading();
				$('#fg-edit-media-modal').removeClass('fg-show');
				showSuccessBox('Media successfully updated!');
			}
		  });
    });

    //show albums of a gallery
    galleriesAccordion.delegate('li > div', 'click', function(event) {

	    var $this = $(this),
	    	$subMenu = $this.next('.sub-menu');

        // Show and hide the tabs on click
        if (!$this.hasClass('active') && $this.hasClass('gallery-item')){
            accordion_body.slideUp('normal');
            $subMenu.stop(true,true).slideToggle('normal');
            galleries.removeClass('active');
            $this.addClass('active');
            currentGallery = $this.attr('id');
            if($subMenu.children('li').size() > 0) {
	            $subMenu.children('li:first').children('div').click();
            }
            else {
            	$('#mediaList').empty();
            	notification.text('The selected gallery has no albums yet!');
	            currentAlbum = null;
            }
        }

        return false;

    });

    //show media of an album
    galleriesAccordion.delegate('li > ul > li > div', 'click', function(event) {

	    var $this = $(this);
	    currentAlbum = $this.attr('id');
		loadAlbum();

        return false;

    });

    //add a new gallery to the gallery list
	$('#fg-add-gallery').click(function() {

		if($('.wrap').hasClass('disabled')) {
	    	return false;
    	}

		var titleInput =  $('input[name=gallery_title]');

		if(titleInput.val() != "") {
            toggleAjaxLoading();
			$.ajax({ url: options.Ajax_Url, data: { action: 'newgallery', title: titleInput.val() }, type: 'post', success: function(data) {

				var res = wpAjax.parseAjaxResponse(data, 'ajax-response'),
					supplemental = getSupplemental(res)
					msg = getResponseMessage(res);

				if(!res.errors) {
					$('#galleries-accordion').append(supplemental.gallery_html + '</ul></li>').children('li:last').children('div').click();
					titleInput.val('');
					galleries = $('#galleries-accordion > li > div');
					accordion_body = $('#galleries-accordion li > .sub-menu');
					accordion_body.sortable();
					currentAlbum = null;
					showSuccessBox(msg);
				}
				else {
					alert(msg);
				}

				toggleAjaxLoading();
			  }
			});
		}
		else {
			alert("Please enter a gallery title!");
		}

		return false;
	});

    //add album
    galleriesAccordion.delegate('.fg-add-album', 'click', function() {

    	var $this = $(this),
    		$albumList = $this.parents('.gallery-item').parent('li').children('.sub-menu'),
    		title =  prompt('Please enter a title for the album:', " ");

		if($('.wrap').hasClass('disabled')) {
	    	return false;
    	}

		if(title && title !== " ") {

			$this.parent().parent().click();

			$.ajax({ url: options.Ajax_Url, data: { action: 'newalbum', gallery: currentGallery, title: title, sortId: $albumList.children('li').size() }, type: 'post', success: function(data) {

				var res = wpAjax.parseAjaxResponse(data, 'ajax-response'),
					supplemental = getSupplemental(res)
					msg = getResponseMessage(res);

				if(!res.errors) {
					$albumList.append(supplemental.album_html);
					accordion_body = $('#galleries-accordion li > .sub-menu');
					accordion_body.sortable();
					$albumList.children('li:last').children('div').click();
					showSuccessBox(msg);
				}
				else {
					toggleAjaxLoading();
					alert(msg);
				}

			  }
			});
		}
		else if(title === " ") {
			alert("Not a valid title! Please enter a correct title for the album!");
			$this.click();
		}

		return false;

    });

    //edit titles
    galleriesAccordion.delegate('.fg-edit', 'click', function() {

    	var $this = $(this),
    		item = $this.parent().parent(),
    		oldTitle = item.children('.fg-title').text(),
    		newTitle = prompt($this.hasClass('fg-edit-gallery') ? 'Please enter a new title for the gallery:' : 'Please enter a new title for the album:', oldTitle);

    	if($('.wrap').hasClass('disabled')) {
	    	return false;
    	}

    	if(newTitle != null && newTitle != '' && newTitle != oldTitle) {
	    	toggleAjaxLoading();

	    	//edit gallery title
	    	if($this.hasClass('fg-edit-gallery')) {
		    	$.ajax({ url: options.Ajax_Url, data: { action: 'editgallery', id: item.attr('id'), newTitle: newTitle }, type: 'post', success: function(data) {

					var res = wpAjax.parseAjaxResponse(data, 'ajax-response'),
						supplemental = getSupplemental(res),
						msg = getResponseMessage(res);

					if(!res.errors) {
						$this.parent().parent().children('.fg-title').text(supplemental.title);
						showSuccessBox(msg);
					}
					else {
						alert(msg);
					}

					toggleAjaxLoading();
				  }
				});
	    	}
	    	//edit album title
	    	else {
		    	$.ajax({ url: options.Ajax_Url, data: { action: 'editalbum', id: item.attr('id'), newTitle: newTitle }, type: 'post', success: function(data) {

					var res = wpAjax.parseAjaxResponse(data, 'ajax-response'),
						supplemental = getSupplemental(res),
						msg = getResponseMessage(res);

					if(!res.errors) {
						$this.parent().parent().children('.fg-title').text(supplemental.title);
						showSuccessBox(msg);
					}
					else {
						alert(msg);
					}

					toggleAjaxLoading();
				  }
				});
	    	}

    	}
    	else if(newTitle == '') {
	    	if($this.hasClass('fg-edit-gallery')) { alert('Please enter a correct title for your gallery!'); }
	    	else { alert('Please enter a correct title for your album!'); }
	    	$this.click();
    	}

	    return false;
    });

    //edit album description
    galleriesAccordion.delegate('.fg-edit-album-description', 'click', function() {

    	currentAlbumDescription = $(this);

    	$('#fg-album-description-modal').addClass('fg-show');
    	$('.switch-tmce').click();

    	setTimeout(function() {
	    	tinymce.get('fgAlbumDescription').setContent(currentAlbumDescription.children('input').val());
    	}
    	, 200);

	    return false;

    });

    //edit album description
    galleriesAccordion.delegate('.fg-edit-album-thumbnail', 'click', function() {

    	currentAlbumThumbnail = $(this);

    	$('#fg-album-thumbnail-modal').addClass('fg-show')
    	.find('#fg-modal-album-thumbnail-input').val(currentAlbumThumbnail.children('input').val()).change();

	    return false;

    });

    $('#fg-modal-album-thumbnail-input').change(function() {
		if(this.value.length == 0) {
			$('#fg-current-album-thumbnail').hide()
			.children('img').attr('src', '');
		}
		else {
			$('#fg-current-album-thumbnail').show()
			.children('img').attr('src', this.value);
		}
    });

    $('#fg-save-album-description').click(function() {

    	if($('.wrap').hasClass('disabled')) {
	    	return false;
    	}

    	toggleAjaxLoading();

    	$('.switch-tmce').click();

    	var description = tinymce.get('fgAlbumDescription').getContent();
    	$.ajax({ url: options.Ajax_Url, data: { action: 'editalbumdescription', id: currentAlbumDescription.parent().parent().attr('id'), description: description }, type: 'post', success: function(data) {

			var res = wpAjax.parseAjaxResponse(data, 'ajax-response'),
				msg = getResponseMessage(res);

			if(!res.errors) {
				currentAlbumDescription.children('input').val(description);
				$('#fg-album-description-modal').removeClass('fg-show');
				showSuccessBox(msg);
			}
			else {
				alert(msg);
			}

			toggleAjaxLoading();
		  }
		});

	    return false;
    });

    $('#fg-save-album-thumbnail').click(function() {

    	if($('.wrap').hasClass('disabled')) {
	    	return false;
    	}

    	toggleAjaxLoading();

    	var thumbnail = $('#fg-modal-album-thumbnail-input').val();

    	$.ajax({ url: options.Ajax_Url, data: { action: 'editalbumthumbnail', id: currentAlbumThumbnail.parent().parent().attr('id'), thumbnail: thumbnail}, type: 'post', success: function(data) {

			var res = wpAjax.parseAjaxResponse(data, 'ajax-response'),
				msg = getResponseMessage(res);

			if(!res.errors) {
				currentAlbumThumbnail.children('input').val(thumbnail);
				$('#fg-album-thumbnail-modal').removeClass('fg-show');
				showSuccessBox(msg);
			}
			else {
				alert(msg);
			}

			toggleAjaxLoading();
		  }
		});

	    return false;
    });

    //trash gallery/album
    galleriesAccordion.delegate('.fg-delete', 'click', function() {

    	var $this = $(this),
    		item = $this.parent().parent(),
    		confirmMsg = $this.hasClass('fg-delete-gallery') ? 'Delete gallery: '+item.children('.fg-title').text() :  'Delete album: '+item.children('.fg-title').text(),
    		r = confirm(confirmMsg);

    	if($('.wrap').hasClass('disabled')) {
	    	return false;
    	}

		if(r) {
			toggleAjaxLoading();
			if($this.hasClass('fg-delete-gallery')) {

				$.ajax({ url: options.Ajax_Url, data: { action: 'deletegallery', id: item.attr('id') }, type: 'post', success: function(data) {
					var res = wpAjax.parseAjaxResponse(data, 'ajax-response');
					var msg = getResponseMessage(res);

					if(!res.errors) {
						if(item.attr('id') == currentGallery) {
							$('#mediaList').empty();
							currentGallery = null;
						}

						item.parent().remove();
						showSuccessBox(msg);
					}
					else {
						alert(msg);
					}

					toggleAjaxLoading();
				  }
				});
			}
			else {
				$.ajax({ url: options.Ajax_Url, data: { action: 'deletealbum', galleryId: currentGallery, id: item.attr('id') }, type: 'post', success: function(data) {
					var res = wpAjax.parseAjaxResponse(data, 'ajax-response');
					var msg = getResponseMessage(res);

					if(!res.errors) {
						if(item.attr('id') == currentAlbum) {
							$('#mediaList').empty();
							currentAlbum = null;
						}

						item.parent().remove();
						showSuccessBox(msg);
					}
					else {
						alert(msg);
					}

					toggleAjaxLoading();
				  }
				});
			}

		}

    	return false;
    });

    //show shortcode
    galleriesAccordion.delegate('.fg-show-shortcode', 'click', function() {
	    var $this = $(this),
	    	id = $this.parent().parent().attr('id'),
	    	shortcode = '[fancygallery id="'+ id +'"]';

	    if($this.hasClass('fg-album-shortcode')) {
	    	var galleryId = $this.parents('.sub-menu').parent('li').children('.gallery-item').attr('id');
		    shortcode = '[fancygallery id="'+ galleryId +'" album="'+ id +'"]'
	    }
	    $('#shortcode-output').val(shortcode).select();
	    return false;
    });

	//selects all list items
	$("#select-all, #deselect-all").click(function(evt) {
		$("#mediaList input:checkbox").each(function() {
		  this.checked = evt.currentTarget.id == 'select-all' ? 'checked' : '';
		});

		return false;
	});


	//delete media from the media list
	$('#delete-files').click(function(evt){

		if($('.wrap').hasClass('disabled')) {
	    	return false;
    	}

		if($("input:checked").length == 0) {
			alert("No media selected!");
			return false;
		}

		r = confirm("You are going to delete the selected media! Sure?");
		if(!r) {
			return false;
		}

		toggleAjaxLoading();

		var files = $("input:checked").serializeArray();
		$.ajax({ url: options.Ajax_Url, data: { action: 'deletefiles', files: files, gallery: currentGallery, album: currentAlbum }, type: 'post', success: function(data) {
			$("input:checked").parent().remove();
			toggleAjaxLoading();
			showSuccessBox('Media successfully deleted!');
		  }
		});

		return false;
	});

	//update all media
	$('#update-media').click(function() {

		if($('.wrap').hasClass('disabled')) {
	    	return false;
    	}

		toggleAjaxLoading();

		var ids = $('input[name*=ids]').serializeArray();

		$.ajax({
			url: options.Ajax_Url,
			dataType: 'json',
			type: 'post',
			data: { action: 'updatefiles', albumId: currentAlbum, ids: ids},
			success: function(data) {
				toggleAjaxLoading();
				showSuccessBox('Media successfully updated!');
		  }
		});

		return false;
	});

	//load the first album
	loadAlbum();

	//load all media of an album
    function loadAlbum() {

    	toggleAjaxLoading();

	    $('#mediaList').empty();

	    if(currentAlbum == undefined || currentAlbum == null) {
	    	toggleAjaxLoading();
		    return false;
	    }

	    accordion_body.find('div').removeClass('active');
	    galleries.filter('[id="'+currentGallery+'"]').next('.sub-menu').find('[id="'+currentAlbum+'"]').addClass('active');

	    $.ajax({ url: options.Ajax_Url, data: { action: 'loadfiles', albumId: currentAlbum }, type: 'post', success: function(data) {

			if(data.length > 0) {
				notification.text('');
				$.each(data, function() {
					addListItem('prepend', this.ID, this.file, this.thumbnail, this.title, this.description);
				});
			}
			else {
				 notification.text('The selected album has no media files yet!');
			}

			toggleAjaxLoading();
			showSuccessBox('Album successfully loaded!');

		  }
		});

    };

	//adds a new list item to the media list
	function addListItem(where, id, file, thumbnail, title, description) {
		var thumbnail_src = thumbnail.search('http://') == -1 && thumbnail.replace(/^\/([^\/]*).*$/, '$1') != 'wp-content' ? options.contentUrl+thumbnail : thumbnail;
		if (thumbnail_src.indexOf('/') === 0){
            thumbnail_src = thumbnail_src.replace('/','');
        }
		var listItem = '<li><a href="#" title="Edit media" class="fg-edit-media"><span class="glyphicon glyphicon-edit"></span></a><input type="checkbox" name="selected" value="'+file+'" /><input type="text" name="titles[]" value="'+stripslashes(title)+'" placeholder="Title" /><img src="'+thumbnail_src+'" /><input type="hidden" name="ids[]" value="'+id+'" /><input type="hidden" name="thumbnails[]" value="'+thumbnail+'" /><input type="hidden" name="files[]" value="'+file+'" /><textarea rows="4" name="descriptions[]" class="hidden">'+stripslashes(description)+'</textarea></li>';

		if(where == 'append') {
			$('#mediaList').append(listItem);
		}
		else {
			$('#mediaList').prepend(listItem);
		}

	};

	//strip slashes from text
	function stripslashes(str) {
		str=str.replace(/\\'/g,'\'');
		str=str.replace(/\\"/g,'"');
		str=str.replace(/\\0/g,'\0');
		str=str.replace(/\\\\/g,'\\');
		return str;
	};

	//check if an album and or gallery is set
	function checkIds() {
	    if(currentGallery == undefined || currentGallery == null) {
	    	return 'No gallery is selected!';
	    }
	    else if(currentAlbum == undefined || currentAlbum == null) {
		    return 'No album is selected!';
	    }
	    return false;
    };

    //returns the file type
	function getFileType(media){

		if (media.match(/youtube\.com\/watch/i) || media.match(/youtu\.be/i)) {
			return 'youtube';
		}else if (media.match(/vimeo\.com/i)) {
			return 'vimeo';
		}else {
			return '';
		};

	};

	//returns the value of a parameter in the url
	function getParam(url,key){

		key = key.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
		var regexS = "[\\?&]"+key+"=([^&#]*)";
		var regex = new RegExp( regexS );
		var results = regex.exec( url );
		return ( results == null ) ? "" : results[1];

	};

});
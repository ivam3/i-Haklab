/**
 * Requires:
 * jquery.cropit.min.js
 * initial.min.js
/*! VFM avatar setup */
function Avatars(username) {
	var $avaResponse, $btnRemove, $updated, $btnUpload, $btnUpdate, $avatarPanel, $cropPreview, $slider, $uploader, $btnUploader, imageData, imageName, avaimg;

	$avaResponse = $('.avatar-response');
	$btnRemove = $('.remove-avatar');
	$updated = $('<i class="bi bi-check-circle text-success"></i>');
	$updatedWrap = $('.updated');
	$btnUpload = $('.uppa');
	$btnUpdate = $('.export');
	$avatarPanel = $('.avatar-panel');
	$cropPreview = $('.cropit-preview');
	$slider = $('.slider');
	$uploader = $('.cropit-image-input');
	$btnUploader = $('.uppa');
	avaimg = $('.avatar');

	var attr = $(avaimg).attr('src');

	// hide default thumb and init cropit with current avatar
	if (typeof attr !== typeof undefined && attr !== false) {
		$avatarPanel.find('.avadefault').addClass('d-none');
		$avatarPanel.cropit({
			imageState: { 
				src: $(avaimg).attr('src')
			},
			allowDragNDrop: false
		});
	// hide cropit panel and leave default
	} else {
		$cropPreview.addClass('d-none');
		$slider.addClass('d-none');
		$btnRemove.addClass('d-none');
	}

	// Upload new image
    $btnUploader.on('click', function(){
    	// remove checked mark
		$updatedWrap.html('');
		// init cropit
		$avatarPanel.cropit({
			allowDragNDrop: false
		});
		// trigger uploader
		$uploader.click();
    });

    // Change image input
    $uploader.on('change', function(){
     	$btnUpdate.removeClass('d-none');
		// hide default
		$avatarPanel.find('.avadefault').addClass('d-none');
		// show cropit panel
		$cropPreview.removeClass('d-none');
		$slider.removeClass('d-none');
		$btnRemove.removeClass('d-none');
    });

    // Remove current avatar
    $btnRemove.on('click', function(){
    	// hide button and checked mark
    	$(this).addClass('d-none');
      	$updatedWrap.html('');

		$cropPreview.addClass('d-none');
		$('.cropit-preview-image').attr('src','');
    	$btnUpdate.removeClass('d-none');
    	$avatarPanel.find('.avadefault').removeClass('d-none');
	});

    // Save new avatar
    $(document).on('click', '.export', function(){
     	var d = new Date();
     	var randy = d.getTime();
      	var sendData;
      	var imageData = false;

      	if ($('.cropit-preview-image').attr('src') !== '') {
	    	imageData = $avatarPanel.cropit('export');
    	}
        imageName = $('.image-name').val();

		if (imageData == false) {
			// reset avatar and delete old image
			$('.avatar').attr('src', '').data('name', username).addClass('avadefault').initial({fontWeight:200, seed:13});
			sendData = { imgData: 0, imgName: imageName }
		} else {
			sendData = { imgData: imageData, imgName: imageName }
		}
        $.ajax({
            method: "POST",
            url: "vfm-admin/ajax/avatar.php",
            data: sendData
        })
        .done(function( msg ) {
        	$updatedWrap.html($updated);
	        $btnUpdate.addClass('d-none');
			// check if response is imge
	        if (msg.match(/\.(png)$/) != null) {
	            $('.avatar').attr('src', msg + '?' + randy);
	            $avatarPanel.cropit('imageSrc', msg + '?' + randy);
	       	} else {
	       		// print message
	       		$avaResponse.html(msg);
	       	}
        })
        .fail(function() {
        	$avaResponse.html('<div class="alert alert-danger" role="alert">Error saving avatar</div>');
        });
    });
}

// init default avatars
$(document).ready(function(){
    $('.avadefault').initial({fontWeight:200, seed:13});
});

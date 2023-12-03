/*! 
 * VFM - veno file manager 
 * upload functions 
 * require Resumable.js
 * require jquery.form
 */
$(document).ready(function(){

	$('#remote_uploader').on('submit', function(e){
		e.preventDefault();

		var $butt = $(this).find('.send_remote_upload_url');
        var $form = $(this);
        var $modalresponse = $form.parent().find(".modal_response");
        if ($form.find("input[name='get_upload_url']").val()) {
            var serialize = $form.serialize();
            var reloadpage = '?dir='+$form.find("input[name='get_location']").val();
            $form.addClass('d-none');
            $modalresponse.find(".zipicon").removeClass('d-none');
            $.ajax({
                type: "POST",
                url: "vfm-admin/ajax/get-remote.php",
                data: serialize
                })
                .done(function( msg ) {
                	// console.log(msg)
                	window.location.replace(reloadpage);
                })
                .fail(function() {
                    $('.modal_response').html('<div class="alert alert-danger">Error connecting: ajax/get-remote.php</div>').fadeIn();
                    $form.removeClass('d-none');
                    $modalresponse.find(".zipicon").addClass('d-none');
            });
        }
	});
});

/* 
 * Send upload notification 
 * to selected users, and refresh page
 */
function notifyupload() {

    var anyUserChecked = $('#userslist :checkbox:checked').length > 0;

    var locazio = window.location.pathname;
    var responseQS = '?';
    var urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('dir')){
        responseQS += 'dir=' + urlParams.get('dir') + '&';
    } 
    responseQS += 'response=1';
    
    if (anyUserChecked) {

    	var userslist = $("#userslist").serialize();
        var now = $.now();

        $.ajax({
            cache: false,
            type: "POST",
            url: "vfm-admin/ajax/sendupnotif.php?t=" + now,
            data: userslist
        })
        .done(function(msg) {
        	setTimeout(function() {
                location.href = locazio + responseQS;
            }, 200);
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
        	console.log(textStatus);
        	console.log(errorThrown);
        	setTimeout(function() {
                location.href = locazio + responseQS;
            }, 200);
        });
    } else {
        location.href = locazio + responseQS;
    }
}

/*
* call resumable.js
*/
function resumableJsSetup($android, $target, $placeholder, $singleprogress, $chunksize) {
	$android = $android || 'no';
	$singleprogress = $singleprogress || false;

	var ua = navigator.userAgent.toLowerCase();
	var android = $android;

	var r = new Resumable({
		target						: 'vfm-admin/ajax/chunk.php?loc='+$target,
		simultaneousUploads 		: 3, // Simultaneous chunks
		prioritizeFirstAndLastChunk	: true,
		chunkSize 					: $chunksize, // get available size from php ini, see class.setup.php
		// forceChunkSize 				: true, // Force all chunks to be less or equal than chunkSize. For some reason it fails the last chunk on some servers (Default: false)
		// maxFiles 					: 1, // uncomment this to disable multiple uploading
		// maxFileSize 					: 10*1024*1024, // uncomment this to limit the max file size (the example sets 10Mb)
	    minFileSizeErrorCallback:function(file, errorCount) {
	        setTimeout(function() {
	            alert(file.fileName||file.name +' is not valid.');
	        }, 1000);
	    },
	    permanentErrors : [403]
    });

    var percentVal = 0;
    var roundval = 0;

    if (r.support) {

        r.assignBrowse(document.getElementById('upchunk'));
        r.assignBrowse(document.getElementById('fileToUpload'));
        r.assignBrowse(document.getElementById('biguploader'));
        r.assignDrop(document.getElementById('uparea'));

        $("#fileToUpload").attr("placeholder", $placeholder);

        r.on('uploadStart', function(){
            $("#resumer").remove();
           	$("#upchunk").before('<button class="btn btn-primary" id="resumer"><i class="bi bi-pause"></i></button>');
            window.onbeforeunload = function() {
                return 'Are you sure you want to leave?';
            }
	        $('#resumer').on('click', function(){
	        	r.pause();
	        });
        });
        
        r.on('pause', function(){
            $("#resumer").remove();
            $("#upchunk").before('<button class="btn btn-primary" id="resumer"><i class="bi bi-play"></i></button>');
	        $('#resumer').on('click', function(){
	        	r.upload();
	        });
        });

        r.on('progress', function(){
            percentVal = r.progress()*100;
            roundval = percentVal.toFixed(1);
            $('.upbar p').html(roundval+'%');
            $(".upbar").width(percentVal+'%');
        });

        // upload progress for individual files
        if ($singleprogress == true) { 
            r.on('fileProgress', function(file){
                percentVal = file.progress(true)*100;
                $('.upbarfile p').html(file.fileName);
                $(".upbarfile").width(percentVal+'%');
            });
        }

        r.on('error', function(message, file){
            console.log(message);
        });

        r.on('fileAdded', function(file, event){
            r.upload();
        });

        // add file path 
        // to notification message
        r.on('fileSuccess', function(file, event){
            var newinput = '<input type="hidden" name="filename[]" value="'+file.fileName+'">';
            $("#userslist").append(newinput);
        });
 
        r.on('complete', function(){
            window.onbeforeunload = null;
            notifyupload();
        });

        // Drag & Drop
        $('#uparea').on(
            'dragstart dragenter dragover',
            function(e) {
                $(".overdrag").css('display','block');
        });
        $('.overdrag').on(
            'drop dragleave dragend mouseup',
            function(e) {
                $(".overdrag").css('display','none');
        });

    } else {

        // Resumable.js is not supported, fall back on the form.js method
        var ie = ((document.all) ? true : false);

        $("#upchunk").remove();
        $('#upformsubmit').prop('disabled', true).show();

        // // form.js is not supported ( IE < 10 or Safari on Windows), fall back on the old classic form method
        // if (ie || ($.client.profile().platform == 'win' && $.client.profile().name == 'safari' )) {
        // // if (ie || ($.client.os == 'Windows' && $.client.browser == 'Safari' ) || android == 'yes') {
        //     $('#upload_file').css('display','table-cell');
        //     $('.ie_hidden').remove();
        //     $(document).on('click', '#upformsubmit', function(e) {
        //         $('#fileToUpload').val('Loading....');
        //     });
        // } else {
        	// use form.js			
            $(document).on('click', '#fileToUpload', function() {
                $('.upload_file').trigger('click');
            });
            $(document).on('click', '#upformsubmit', function(e) {
                e.preventDefault();
                $('.upload_file').trigger('click');
            });
        
	        $(document).ready(function(){

	            var progress = $('#progress-up');
	            var probar = $('.upbar');
	            var prop = $('.upbar p');

	            $('#upForm').ajaxForm({
	                beforeSubmit: function() {            
	                    progress.css('opacity', 1);
	                },
	                uploadProgress: function(event, position, total, percentComplete) {
	                    
	                    probar.width(percentComplete + '%');
	                    prop.html(percentComplete.toFixed(1) + '%');
	                    if (percentComplete == 100) {
	                    	notifyupload();
	                    }
	                }
	            });
	        });
        // }
    
        $('.btn-file :file').on('fileselect', function (event, numFiles, label) {
            var input = $(this).parents('.input-group').find(':text'),
            log = numFiles > 1 ? numFiles + ' files selected' : label;

	        // add file path 
	        // to notification message
		    var files = $(this)[0].files;
		    for (var i = 0; i < files.length; i++) {
		        var newinput = '<input type="hidden" name="filename[]" value="'+files[i].name+'">';
		        $("#userslist").append(newinput);
		    }
            if (input.length) {
                input.val(log);
                // auto start upload after select if browser is not IE
                if (!ie) {
                    $("#upForm").submit();
                } else {
                    $('#upformsubmit').prop('disabled', false);
                }
            }
        });
    }
};

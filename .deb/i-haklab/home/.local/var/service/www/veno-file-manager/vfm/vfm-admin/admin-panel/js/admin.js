/*! VFM - veno file manager main administration functions
 * ================
 *
 * @Author  Nicola Franchini
 * @Support <http://www.veno.es>
 * @Email   <support@veno.it>
 * @version 3.6.0
 * @license Exclusively sold on CodeCanyon
 */
$(document).ready(function () {

    // Init EasyEditor inside appearance
    if (typeof EasyEditor !== 'undefined') {
        new EasyEditor('.easyeditor', {
            // css: ({
            //     minHeight: '300px',
            //     maxHeight: '500px'
            // }),
            onLoaded: function(){
            //     console.log('Easy Editor Loaded!');
            },
            buttons : ['bold', 'italic', 'link', 'h2', 'h3', 'h4', 'alignleft', 'aligncenter', 'alignright', 'quote', 'source', 'x'],
            buttonsHtml: {
                'bold': '<i class="bi bi-type-bold"></i>',
                'italic': '<i class="bi bi-type-italic"></i>',
                'link': '<i class="bi bi-link-45deg"></i>',
                'align-left': '<i class="bi bi-text-left"></i>',
                'align-center': '<i class="bi bi-text-center"></i>',
                'align-right': '<i class="bi bi-text-right"></i>',
                'quote': '<i class="bi bi-quote"></i>',
                'source': '<i class="bi bi-code-slash"></i>',
                'insert-image': '<i class="bi bi-image"></i>',
                'remove-formatting': '<i class="bi bi-slash-square"></i>'
            }
        });
    }
});
//
// Clear /thumbs/ folder
//
$(document).ready(function(){
    var regenicon = '<div class="spinner-border spinner-border-sm ms-1" role="status"><span class="visually-hidden">Loading...</span></div>';
    $('.regen-thumb').on('click', function(){

        var butt = $(this);
        var place_icon = butt.find('.place-icon');

        if (!butt.hasClass('disabled')) {

            butt.addClass('disabled');

            place_icon.html(regenicon);

            $.ajax({
                method: "GET",
                url: "admin-panel/ajax/regen-thumbnails.php",
            })
            .done(function( msg ) {
                butt.removeClass('disabled');
                place_icon.html('<i class="bi bi-check-lg"></i>');
            })
            .fail(function() {
                butt.removeClass('disabled');
                console.log('error clearing thumbs folder');
                place_icon.html('<i class="bi bi-x-lg"></i>');
            });
        }
    });
});

//
// call taginput plugin
//
$('.tagin').each(function(){
    new Tagin($(this)[0],{
        enter: true
    });
});


$('.toggle-sidebar').on('click', function(){
    var dest = $(this).data('bs-target');
    $(dest).toggleClass('open');
});

//
// toggle allow/reject extensions
//
function switchExtensions(){
    $('.togglext').each(function(){
        var collapser = $(this).closest('.toggle-wrap').find('.toggle-collapse');
        if ($(this).is(':checked')) {
            collapser.slideDown();
        } else {
            collapser.slideUp();
        }
    });
}

//
// setup user panel in admin area
//
$(document).on('click', '.usrblock', function(e) {
    e.preventDefault();
    $('#modaluser .getuser').val('');
    var username = '';
    var thisRow = $(this).closest('.userrow');
    var objectConstructor = ({}).constructor;

    thisRow.find('.send-userdata').each(function(){
        var key = $(this).data('key');
        if (key === 'disabled') {
            if ($(this).val() == 1) {
                $('#modaluser .getuser-'+key).attr("checked", "checked");
            } else {
                $('#modaluser .getuser-'+key).attr("checked", false);
            }
        } else {
            if (key === 'name') {
                username = $(this).val();
            }
            var json = false;
            try {  
                json = JSON.parse($(this).val());  
            } catch (e) {  
                console.log('invalid json');
            }
            if (json.constructor === objectConstructor) {
                $.each(json, function( index, value ) {
                    $("#modaluser .getuser-"+key+ " option[value='" + value + "']").prop("selected", true);
                });
            } else {
               $('#modaluser .getuser-'+key).val($(this).val());
            }
        }
    });

    $("#modaluser .modal-title .modalusername").html(username);
    $("#r-userpassnew").val('');

    var data = [];
    var hiddenfolders = thisRow.find(".s-userfolders");
    hiddenfolders.each(function(){
        data.push($(this).val());
    });

    $("#r-userfolders").val(data);

    $(".coolselect").selectpicker('refresh');
    $(".assignfolder").selectpicker('refresh');
    if ($('#r-userfolders').val().length){
        $('#modaluser .userquota').show();
    } else {
        $('#modaluser .userquota').hide();
    }
});

$('.togglequota').each(function(){
    showHideQuota($(this));
});

//
// Show / hide user quota menu when dropdown or new input
//
function showHideQuota(togglequota){
    var assign = togglequota.find('select.assignfolder');
    var setnew = togglequota.find('.assignnew');
    var quota = togglequota.find('.userquota');
    if ((assign.val() && assign.val().length) || (setnew.val() && setnew.val().length)) {
        quota.fadeIn();
    } else {
        quota.fadeOut();
    }
}

$(document).on('change', '.togglequota select.assignfolder', function() {
    var togglequota = $(this).closest('.togglequota');
    showHideQuota(togglequota);
});

$(document).on('input', '.togglequota .assignnew', function() {
    var togglequota = $(this).closest('.togglequota');
    showHideQuota(togglequota);
});

//
// confirm user deletion
//
$(document).on('click', '.remove', function(e) {
    //e.preventDefault();
    var todelete = $(this).closest(".removegroup").find(".deleteme").val();
    var answer = confirm('Are you sure you want to delete: ' + todelete + '?');
    if (answer == true) {
        $(".remove").find(".delme").val(todelete);
    }
    return answer;
});

//
// confirm language deletion
//
$(document).on('click', '.delete', function() {
    var answer = confirm('Are you sure you want entirely to delete this language?');
    return answer;
});

//
// delete logo
//
$(document).on('click', '.deletelogo', function(e) {
    e.preventDefault();
    $(this).addClass('d-none');
    var datasetting = $(this).data('setting');
    $('input[name=remove_'+datasetting+']').val(1);
    $('.'+datasetting+'-preview').attr('src', 'admin-panel/images/placeholder.png');
});

//
// Upload custom logo
//
$(document).on('change', '.btn-file :file', function() {
    var input = $(this),
    numFiles = input.get(0).files ? input.get(0).files.length : 1,
    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [numFiles, label]);
});

//
// Switch audio notifications
//
$(document).on('change', '.audio-notif', function(){
    var loadmp3 = $(this).val();
    var audio_ping = new Audio(loadmp3);
    audio_ping.play();
});

//
// Show / Hide New User notification checkbox
//
function checkUserNotif(){
    if ($('.newusermail').length) {
        if ($('.newusermail').val().length > 0){
            $('.usernotif').fadeIn();
        } else {
            $('.usernotif').fadeOut();
        }
    }
}
$('.newusermail').keyup(function() {
    checkUserNotif();
});

$(document).ready(function() {
    checkUserNotif();
});

//
// Update adminstration color scheme on the fly
//
function updateThemeColors(selector, hsl){
    var basecolor = Number(hsl.h) + ', ' + (Number(hsl.s)*100)+'%';
    var basecolortext = '#f8f9fa';
    if (Number(hsl.l) >= 0.6) {
        basecolortext = '#212529';
    }
    document.querySelector(":root").style.setProperty('--color-' + selector + '-text', basecolortext);
    document.querySelector(":root").style.setProperty('--base-color-' + selector, basecolor);
    document.querySelector(":root").style.setProperty('--base-l-' + selector, (hsl.l*100)+'%');
}

$(document).ready(function() {
    $(".admin-colorpicker").each(function(){
        var picker = $(this);
        var selector = picker.data('color-selector');
        picker.spectrum({
            type: "text",
            showPalette: true,
            showAlpha: false,
            showButtons: false,
            allowEmpty: false,
            preferredFormat: "hsl",
            move: function(color) {
                updateThemeColors(selector, color.toHsl());
            }
        });
    });
});

//
// switch header logo alignment on the fly
//
$(document).on('change', '.select-logo-alignment input:radio', function() {
    var value = 'text-start';
    switch($(this).val()) {
        case 'left':
            value = 'text-start';
            break;
        case 'center':
            value = 'text-center';
            break;
        case 'right':
            value = 'text-end';
            break;
        default:
            value = 'text-start';
    }
    $('.place-main-header').removeClass('text-start').removeClass('text-center').removeClass('text-end').addClass(value);
});

//
// switch wide / boxed header image
//
$(document).on('change', '.select-banner-width input:radio', function() {
    var value = '';
    switch($(this).val()) {
        case 'wide':
            value = '';
            break;
        case 'boxed':
            value = 'boxed';
            break;
        default:
            value = '';
    }
    $('.wrap-image-header').removeClass('boxed').addClass(value);
});

//
// toggle allow/reject extensions on the fly
//
$(document).on('change', '.togglext', function() {
    switchExtensions();
});

//
// toggle percent % in progress bar on the fly
//
$(document).on('change', "#percent", function() {
    var $input = $(this);
    if ($input.is( ":checked" )) {
        $('.progress-group').addClass('fullp');
    } else {
        $('.progress-group').removeClass('fullp');
    }
}).change();

//
// change individual progress bar color on the fly
//
function updateSingleBar($newclass) {
    $('.progress-single .progress-bar').removeClass().addClass('progress-bar').addClass($newclass);
}

function updateDefaultBar($newclass) {
    $('.first-progress').data('color', $newclass);
    $('.first-progress').next().find('.progress-bar').removeClass().addClass('progress-bar').addClass($newclass);

    if ($('.first-progress').is(':checked')) {
        updateSingleBar($newclass);
    }
}
$(document).on('change', '.pro input:radio', function() {
    var newclass = $(this).data('color');
    updateSingleBar(newclass);
});

$(document).on('click', '.fake-uploader', function() {
    var target = $(this).data('up-target');
    $(target).click();
});

function checkFixedlabel(){
    var scroll = $(window).scrollTop();
    var lab = $('.fixed-label');
    var labw = lab.width();
    if (scroll > 180) {
        $('.fixed-label').addClass('open');
    } else {
        $('.fixed-label').removeClass('open');
    }
}

$(window).scroll(function (event) {
    checkFixedlabel();
});

function updateSlider(selector){
    // selector.each(function(){
        var target = selector.data('vfm-target');
        $(target).val(selector.val());
    // });
}

function updateSliderRuler(selector){
    // selector.each(function(){
        var target = selector.data('vfm-target');
        $(target).val(selector.val()).change();
    // });
}

 /** 
 * ****************************************
 * Veno file manager Admin DocReady calls
 * ****************************************
 */
$(document).ready(function () {

    $('.easyeditor-wrapper .easyeditor').addClass('header-bg');

    $('#toggle-navbar-brand-view').on("change", function() {
        if($(this)[0].checked){
            $('.nav-brand-group').addClass('d-none');
        } else {
            $('.nav-brand-group').removeClass('d-none');
        }
    });

    $('.show-brand-text').on('click', function(){
        $(this).closest('.nav-brand-group').find('#navbar-brand-text').removeClass('d-none');
    });

    $('#dark_header').on("change", function() {
        if($(this)[0].checked){
            $('.easyeditor-wrapper .easyeditor, .header-bg').css({
                'background-color': 'var(--color-dark-lighter)',
                'color': 'var(--color-dark-text)'
            });
        } else {
            $('.easyeditor-wrapper .easyeditor, .header-bg').css({
                'background-color': 'transparent',
                'color': 'var(--color-light-text)'
            });
        }
    });

    // save settings fixed label
    $('.fixed-label').removeClass('d-none').addClass('animated');

    checkFixedlabel();

    $('.fixed-label').on('click', function(){
        $('#settings-form').submit();
    });

    //
    // toggle allow/reject extensions
    //
    switchExtensions();

    updateSlider($('.set-slider'));

    //
    // slider
    //
    $('.set-slider').on("change", function() {
        updateSlider($(this));
    });

    $('.get-slider').on("input", function() {
        updateSliderRuler($(this));
    });

    // change header padding preview
    var header_padding = $('input[name=header_padding]');

    $('.place-main-header').css({
        'padding-top': header_padding.val()+'px',
        'padding-bottom': header_padding.val()+'px'
    });

    header_padding.on("change", function(slideEvt) {
        $('.place-main-header').css({
            'padding-top': $(this).val()+'px',
            'padding-bottom': $(this).val()+'px'
        });
    });

    // change logo margin preview
    var logo_margin = $('input[name=logo_margin]');

    $('.logo-preview').css({
        'margin-bottom': logo_margin.val()+'px'
    });
    logo_margin.on("change", function(slideEvt) {
        $('.logo-preview').css({
            'margin-bottom': $(this).val()+'px'
        });
    });

    //
    // preview image
    //
    $('.logo-selector').on('change', function(){
        var file = $(this).prop("files")[0];
        var previewclass = $(this).data('target');
        var preview = $(previewclass);
        var reader  = new FileReader();
        reader.onloadend = function () {
            preview.closest('.placeheader').find('.deletelogo').removeClass('d-none');
            preview.closest('.nav-brand-group').find('#navbar-brand-text').addClass('d-none').removeClass('d-flex');
            preview.attr('src', reader.result);
            preview.removeClass('d-none');
        };
        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.closest('.placeheader').find('.deletelogo').addClass('d-none');
            preview.closest('.nav-brand-group').find('#navbar-brand-text').removeClass('d-none').addClass('d-flex');
            preview.attr('src', 'admin-panel/images/placeholder.png');
        }
    });

    //
    // toggle users panel
    //
    $('.toggle').each(function(){
        if (!$(this).find('input[type=checkbox]').prop('checked')){
            $(this).closest('.toggle').next().slideToggle();
        }
    });
    $('.toggle').find('input[type=checkbox]').change(function(){
        if($(this).closest('.toggle').next().length) {
            $(this).closest('.toggle').next().slideToggle();
        } else {
            $(this).closest('.toggle').parent('.toggle').next().slideToggle();
        }
    });

    $('.toggle-reverse').each(function(){
        if ($(this).find('input[type=checkbox]').prop('checked')){
            $(this).closest('.toggle-reverse').prev().slideToggle();
        }
    });
    $('.toggle-reverse').find('input[type=checkbox]').change(function(){
        $(this).closest('.toggle-reverse').prev().slideToggle();
    });

    $('.toggle-reverse-next').each(function(){
        if ($(this).find('input[type=checkbox]').prop('checked')){
            $(this).closest('.toggle-reverse-next').next().slideToggle();
        }
    });
    $('.toggle-reverse-next').find('input[type=checkbox]').change(function(){
        $(this).closest('.toggle-reverse-next').next().slideToggle();
    });

    //
    // activate tooltips
    //
    $('.tooltipper').tooltip();

    //
    // info (?) popover 
    //
    $('.pop').popover();

    //
    // logo uploader
    //
    $('.pop').popover();
    $('.btn-file :file').on('fileselect', function (event, numFiles, label) {
        var input = $(this).parents('.input-group').find(':text');  
        input.val(label);
    });

});

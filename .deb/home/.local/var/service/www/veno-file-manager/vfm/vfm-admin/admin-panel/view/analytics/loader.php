<?php
$logspath = '_content/log/';
$loglist = glob($logspath.'*.json');
// set most recenton top
$loglist = array_reverse($loglist);
$available_days = array();

foreach ($loglist as $day) {
    $path_parts = pathinfo($day);

    $filenamearr = explode("-", $path_parts['filename']);
    $cleanname = array();
    foreach ($filenamearr as $filenamepart) {
        $cleanname[] = ltrim($filenamepart, '0');
    }
    $available_days[] = $path_parts['filename'];
}
$load_datepicker_lang = false;
$regional_picker = 'en';

if ($lang !== 'en') {
    $basepath = 'admin-panel/plugins/datepicker/i18n/datepicker-';
    if (file_exists($basepath.$lang.'.js')) {
        $regional_picker = $lang;
        $load_datepicker_lang = $basepath.$lang.'.js';
    } else {
        $shortlang = substr($lang, 0, 2); // first 2 chars
        if (file_exists($basepath.$shortlang.'.js')) {
            $regional_picker = $shortlang;
            $load_datepicker_lang = $basepath.$shortlang.'.js';
        }
    }
}
if ($load_datepicker_lang) {
    ?>
    <script src="<?php echo $load_datepicker_lang; ?>"></script>
    <?php
} ?>
<script type="text/javascript">

// activate only available days
function available(date) {
    var availableDates = <?php echo json_encode($available_days); ?>;
    dmy = date.getFullYear() + "-" + ("0" +(date.getMonth()+1)).slice(-2) + "-" + ("0" + date.getDate()).slice(-2);

    if ($.inArray(dmy, availableDates) != -1) {
        return [true, "", "Available"];
    } else {
        return [false, "", "unAvailable"];
    }
}

$(document).ready(function(){
    var availableDates = <?php echo json_encode($available_days); ?>;
    var datamin = availableDates[availableDates.length-1];
    var datamax = availableDates[0];
    // SetUp since datepicker.
    $(".vfm-datepicker").datepicker({
        beforeShowDay: available,
        dateFormat : 'yy-mm-dd',
        defaultDate: datamax,
        minDate : datamin,
        maxDate : datamax
    });

    // SetUp Until datepicker.
    var untilpicker = $( "#loguntil" ).datepicker({ 
        beforeShowDay: available,
        dateFormat : 'yy-mm-dd',
        defaultDate: datamax,
        minDate : datamin,
        maxDate : datamax
    });

    // SetUp since datepicker.
    $("#logsince").datepicker({
        beforeShowDay: available,
        dateFormat : 'yy-mm-dd',
        defaultDate: datamax,
        minDate : datamin,
        maxDate : datamax
    });

    $("#logsince").on('change', function(selectedDate) {
        if ($(this).val()) {
            var selectedDate = $(this).val();
            untilpicker.datepicker("option", "minDate", selectedDate);
            if (untilpicker.val()) {
                $('#getcsv').removeClass('disabled');
            }
        } else {
            $('#getcsv').addClass('disabled');
        }
    });

    $("#loguntil").on('change', function(selectedDate) {
        if ($(this).val() && $("#logsince").val()) {
            $('#getcsv').removeClass('disabled');
        } else {
            $('#getcsv').addClass('disabled');
        }
    });

    $.datepicker.setDefaults( $.datepicker.regional[ "<?php echo $regional_picker; ?>" ] );

    // Set default Until date if Sinceisalready set.
    if ( $('#logsince').val() ) {
        var selectedDate = $('#logsince').val();
        untilpicker.datepicker("option", "minDate", selectedDate);
        // untilpicker.datepicker("option", "defaultDate", selectedDate);
    }

    $('#getcsv').on('click', function(e){
        e.preventDefault();
        $('#csvform').submit();
        $('#csvform').find('input').val('');
        $('#getcsv').addClass('disabled');
    });
});
</script>

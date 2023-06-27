<?php
$getday = false;
$day = false;
$range = false;
if (isset($_GET['range'])) {
    $range = $_GET['range'];
} elseif (isset($_GET['day']) && strlen($_GET['day'] > 0)) {
    $day = $_GET['day'];
    $logs = array($_GET['day'].".json");
    $getday = true;
} else {
    $range = 1;
}
$loglist = glob('_content/log/*.json');
$loglist = $loglist ? $loglist : array();
$loglist = array_reverse(array_values(preg_grep('/^([^.])/', $loglist)));

if ($getday == false) {
    $logs = array_slice($loglist, 0, $range);
}
$result = array();
$formatdate = substr($setUp->getConfig('time_format'), 0, 5);
?>
<div class="row">
    <div class="col-md-6 mb-3">
        <form method="get">
            <input type="hidden" name="section" value="logs">
            <div class="card">
                <div class="card-header">
                    <?php echo $setUp->getString("last_days"); ?>
                </div>
                <div class="card-body">
                    <div class="input-group input-group-lg mb-3">
                        <div class="input-group-text" id="inputGroup-sizing-lg"><i class="bi bi-calendar-range"></i></div>
                        <input type="number" min="1" max="30" name="range" value="<?php echo $range; ?>" class="form-control">
                        <button type="submit" class="btn btn-primary btn-lg"><i class="bi bi-chevron-right"></i></button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-6 mb-3">
        <form class="form-inline selectdate adminblock" method="get">
            <input type="hidden" name="section" value="logs">
            <div class="card">
                <div class="card-header"><?php echo $setUp->getString("select_date"); ?></div>
                <div class="card-body">
                    <div class="input-group input-group-lg mb-3">
                        <div class="input-group-text" id="inputGroup-sizing-lg"><i class="bi bi-calendar-event"></i></div>
                        <input readonly name="day" value="<?php echo $day; ?>" type="text" class="form-control input-lg vfm-datepicker" onchange="this.form.submit()">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

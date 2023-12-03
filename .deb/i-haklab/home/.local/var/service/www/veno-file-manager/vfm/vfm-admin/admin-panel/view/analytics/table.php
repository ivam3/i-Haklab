<div class="row">
    <div class="col-md-12">
        <div class="card mb-3">
            <div class="card-header">
                <strong><?php echo $setUp->getString("actions"); ?></strong>
            </div>
            <div class="card-body">
                <div class="table-responsive small">
                    <table class="table statistics table-condensed" id="sortanalytics" width="100%">
                      <thead>
                          <tr>
                              <th><span class="sorta"><?php echo $setUp->getString("day"); ?></span></th>
                              <th><span>hh:mm:ss</span></th>
                              <th><span class="sorta"><?php echo $setUp->getString("user"); ?></span></th>
                              <th><span class="sorta"><?php echo $setUp->getString("action"); ?></span></th>
                              <th><span class="sorta"><?php echo $setUp->getString("type"); ?></span></th>
                              <th><span class="sorta"><?php echo $setUp->getString("item"); ?></span></th>
                          </tr>
                        </thead>
                        <tbody>
    <?php
    foreach ($logs as $log) {
        $logfile = '_content/log/'.basename($log);
        if (file_exists($logfile)) {
            $resultnew = json_decode(file_get_contents($logfile), true);
            $result = $resultnew ? array_merge($result, $resultnew) : array();
        }
    }
    $numup = 0;
    $numdel = 0;
    $numplay = 0;
    $numdown = 0;

    $polarplay = array();
    $polardown = array();
    $polarup = array();

    $polardowncount = 0;
    $polarplaycount = 0;
    $polarupcount = 0;

    $labelsarray = array();
    $updataset = array();
    $removedataset = array();
    $playdataset = array();
    $downloaddataset = array();

    foreach ($result as $key => $value) {
        $listtime = strtotime($key);
        $showtime = date($formatdate, $listtime);
        $labelsarray[] = $showtime;

        $uploads = 0;
        $removes = 0;
        $plays = 0;
        $downloads = 0;

        foreach ($value as $kiave => $day) {
            $contextual = "";

            $item = $day['item'];

            if ($day['action'] == 'ADD') {
                $uploads++;
                $numup++;
                $polarupcount++;
                if (isset($polarup[$item])) {
                    $polarup[$item] = $polarup[$item] +1;
                } else {
                    $polarup[$item] = 1;
                }
                $contextual = "bg-success bg-opacity-25";
            }
            if ($day['action'] == 'REMOVE') {
                $removes++;
                $numdel++;
                $contextual = "bg-danger bg-opacity-25";
            }
            if ($day['action'] == 'PLAY') {
                $plays++;
                $numplay++;
                $polarplaycount++;
                if (isset($polarplay[$item])) {
                    $polarplay[$item] = $polarplay[$item] +1;
                } else {
                    $polarplay[$item] = 1;
                }
                $contextual = "bg-warning bg-opacity-25";
            }
            if ($day['action'] == 'DOWNLOAD') {
                $downloads++;
                $numdown++;
                $polardowncount++;
                if (isset($polardown[$item])) {
                    $polardown[$item] = $polardown[$item] +1;
                } else {
                    $polardown[$item] = 1;
                }
                $contextual = "bg-info bg-opacity-25";
            } ?>
            <tr class="<?php echo $contextual; ?>">
            <td data-order="<?php echo $listtime; ?>"><?php echo $showtime; ?></td>
            <td><?php echo $day['time']; ?></td>
            <td><?php echo $day['user']; ?></td>
            <td><?php echo $setUp->getString(strtolower($day['action'])); ?></td>
            <td><?php echo $day['type']; ?></td>
            <td class="text-nowrap"><?php echo $day['item']; ?></td>
            <?php
        }
        array_push($updataset, $uploads);
        array_push($removedataset, $removes);
        array_push($playdataset, $plays);
        array_push($downloaddataset, $downloads);
    }
    $updataset = array_reverse($updataset);
    $removedataset = array_reverse($removedataset);
    $playdataset = array_reverse($playdataset);
    $downloaddataset = array_reverse($downloaddataset);
    $labelsarray = array_reverse($labelsarray);
    ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td><?php echo $setUp->getString("day"); ?></td>
                                <td>hh:mm:ss</span></td>
                                <td><?php echo $setUp->getString("user"); ?></td>
                                <td><?php echo $setUp->getString("action"); ?></td>
                                <td><?php echo $setUp->getString("type"); ?></td>
                                <td><?php echo $setUp->getString("item"); ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
function buildChartData($source, $color)
{
    arsort($source);
    $highest = (!empty($source) ? max($source) : 1);
    $datasets_data = array();
    $datasets_bgcolor = array();
    $datasets_bgcolor_hover = array();
    $datasets_labels = array();

    foreach ($source as $key => $value) {
        $datasets_data[] = $value;
        $opacity = $value/$highest/1.4;
        $datasets_bgcolor[] = 'rgba('.$color.', '.$opacity.')';
        $datasets_bgcolor_hover[] = 'rgba('.$color.', 0.6)';
        $datasets_labels[] = basename($key);
    }

    $result = array(
        'datasets' => array(
            array(
                'data' => $datasets_data,
                'backgroundColor' => $datasets_bgcolor,
                'hoverBackgroundColor' => $datasets_bgcolor_hover,
                'borderColor' => 'rgba(0,0,0,.125)',
            ),
        ),
        'labels' => $datasets_labels,
    );
    return $result;
}

$colorplay = '240, 153, 39'; // #f09927
$colordown = '22, 181, 222'; // #16b5de
$colorup = '92, 184, 92';

$polarDataPlay = buildChartData($polarplay, $colorplay);
$polarDataDown = buildChartData($polardown, $colordown);
$polarDataUp = buildChartData($polarup, $colorup);

$legendlabels = array(
    'add' => $setUp->getString('add'),
    'download' => $setUp->getString('download'),
    'remove' => $setUp->getString('remove'),
    'play' => $setUp->getString('play'),
);

$LOGvars = array(
    'uploads' => $updataset,
    'removes' => $removedataset,
    'plays' => $playdataset,
    'downloads' => $downloaddataset,
    'datalabels' => $labelsarray,
    'legendlabels' => $legendlabels,
    'numup' => $numup,
    'numdel' => $numdel,
    'numplay' => $numplay,
    'numdown' => $numdown,
    'polarplay' => $polarplay,
    'polarplaycount' => $polarplaycount,
    'polardataplay' => $polarDataPlay,

    'polardown' => $polardown,
    'polardowncount' => $polardowncount,
    'polardatadown' => $polarDataDown,
    'polarup' => $polarup,
    'polarupcount' => $polarupcount,
    'polardataup' => $polarDataUp,
); 
?>
<script type='text/javascript'>
/* <![CDATA[ */
var LOGvars = '<?php echo json_encode($LOGvars); ?>';
/* ]]> */
</script>
<div class="d-grid gap-2">
    <button type="button" class="btn btn-primary btn-lg mb-2" data-bs-toggle="modal" data-bs-target="#csv-modal"><i class="bi bi-filetype-csv"></i> <?php echo $setUp->getString("export"); ?> .csv</button>
</div>
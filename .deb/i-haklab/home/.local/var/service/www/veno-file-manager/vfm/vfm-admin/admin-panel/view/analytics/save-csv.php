<?php
$start = filter_input(INPUT_POST, 'logsince', FILTER_SANITIZE_STRING);
$end = filter_input(INPUT_POST, 'loguntil', FILTER_SANITIZE_STRING);
if (!$start || !$end) {
    header('Location: ../../../index.php?log=go');
}
$logspath = '../../../_content/log/';
$loglist = glob($logspath.'*.json');

$result = array();

$getlogs = false;

foreach ($loglist as $log) {
    if ($log == $logspath.$start.'.json') {
        $getlogs = true;
    }
    if ($getlogs === true) {
        $resultnew = json_decode(file_get_contents($log), true);
        $result = array_merge($result, $resultnew);
    }

    if ($log == $logspath.$end.'.json') {
        $getlogs = false;
    }
} 

// Set most recenton on top.
$result = array_reverse($result);
// // output headers so that the file is downloaded rather than displayed
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=log-'.$start.'--'.$end.'.csv');

// create a file pointer connected to the output stream
$output = fopen('php://output', 'w');

// output the column headings
fputcsv($output, array('Date', 'Time', 'User', 'Action', 'Type', 'File'));

foreach ($result as $day => $actions) {

    foreach ($actions as $action) {
        $actionrow = array();
        $actionrow[] = $day;
        $actionrow[] = $action['time'];
        $actionrow[] = $action['user'];
        $actionrow[] = $action['action'];
        $actionrow[] = $action['type'];
        $actionrow[] = $action['item'];
        // Write the action row
        fputcsv($output, $actionrow);
    }
}
exit;

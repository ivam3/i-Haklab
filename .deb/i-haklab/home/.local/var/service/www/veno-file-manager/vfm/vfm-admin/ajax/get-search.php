<?php
/**
 * VFM - veno file manager: ajax/get-search.php
 * Deep search inside sub directories
 *
 * PHP version >= 5.3
 *
 * @category  PHP
 * @package   VenoFileManager
 * @author    Nicola Franchini <support@veno.it>
 * @copyright 2013 Nicola Franchini
 * @license   Exclusively sold on CodeCanyon
 * @link      http://filemanager.veno.it/
 */
if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) 
    || (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest')
) {
    exit;
}

require_once dirname(dirname(__FILE__)).'/config.php';
require_once dirname(dirname(__FILE__)).'/_content/users/users.php';

require_once dirname(dirname(__FILE__)).'/class/class.utils.php';
require_once dirname(dirname(__FILE__)).'/class/class.setup.php';
require_once dirname(dirname(__FILE__)).'/class/class.gatekeeper.php';
require_once dirname(dirname(__FILE__)).'/class/class.search.php';

$setUp = new SetUp();

require_once dirname(dirname(__FILE__)).'/translations/'.$setUp->lang.'.php';

$gateKeeper = new GateKeeper();

$searchkey = filter_input(INPUT_GET, 's', FILTER_UNSAFE_RAW);

$final = array();

if (!empty($searchkey) > 1 && $gateKeeper->isAccessAllowed() && $setUp->getConfig('global_search') && $gateKeeper->isAllowed('viewdirs_enable')) { 

    $search = new Search();

    $startingdir = $setUp->getConfig('starting_dir');
    $basepath = '../.'.$startingdir;
    $userpatharray = array(0 => '');
    $count_total = 0;
    $count_filtered = 0;

    // check if any folder is assigned to the current user
    if (GateKeeper::getUserInfo('dir') !== null) {
        $userpatharray = json_decode(GateKeeper::getUserInfo('dir'), true);
    }
    $dirlist = array();
    $filelist = array();

    foreach ($userpatharray as $scandir) {

        $result = $search->deepSearch($basepath.$scandir, $searchkey);
        
        if (isset($result['dirs'])) {
            $dirlist = array_merge($dirlist, $result['dirs']);
        }
        if (isset($result['files'])) {

            $filelist = array_merge($filelist, $result['files']);
        }
        $count_total += $result['count_total'];
        $count_filtered += $result['count_filtered'];

    }
    $final['dirlist'] = $dirlist;
    $final['filelist'] = $filelist; 
    $final['count_total'] = $count_total;
    $final['count_filtered'] = $count_filtered;
    $final['no_items'] = $setUp->getString('nothing_found');
}
echo json_encode($final);
exit;

<?php
/**
 * VFM - veno file manager: ajax/get-files.php
 * Send files to datatables
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
if ($_CONFIG['debug_mode'] === true) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}
@set_time_limit(0);
require_once dirname(dirname(__FILE__)).'/_content/users/users.php';

require_once dirname(dirname(__FILE__)).'/class/class.utils.php';
require_once dirname(dirname(__FILE__)).'/class/class.setup.php';
require_once dirname(dirname(__FILE__)).'/class/class.gatekeeper.php';
require_once dirname(dirname(__FILE__)).'/class/class.location.php';

$setUp = new SetUp();

require_once dirname(dirname(__FILE__)).'/translations/'.$setUp->lang.'.php';

$gateKeeper = new GateKeeper();

$response = array();
$totaldata = array();
$response['recordsTotal'] = 0;
$response['recordsFiltered'] = 0;

$request = $_GET;

$getdir = filter_var($request['dir'], FILTER_UNSAFE_RAW);

$location = new Location('../../'.$getdir);

if ($gateKeeper->isAccessAllowed() && $location->editAllowed('../../') && $gateKeeper->isAllowed('view_enable')) {
    $fullpath = $location->getFullPath();
    $searchvalue = filter_var($request['search']['value'], FILTER_UNSAFE_RAW);

    include_once '../class/class.imageserver.php';
    include_once '../icons/vfm-icons.php';
    include_once '../class/class.file.php';
    include_once '../class/class.files.php';

    $imageServer = new ImageServer();
    $thefiles = new Files($location, $fullpath, '../../');
    $getfiles = $thefiles->files;

    $response["draw"] = isset($request['draw']) ? intval($request['draw']) : 0;

    $length = isset($request['length']) ? intval($request['length']) : 10;
    $start = isset($request['start']) ? intval($request['start']) : 0;
    $sortby = isset($request['order'][0]['column']) ? intval($request['order'][0]['column']) : 4;
    $orderdir = isset($request['order'][0]['dir']) ? $request['order'][0]['dir'] : 'desc';
    $search = !empty($searchvalue) > 1 ? $searchvalue : false;

    $response['recordsTotal'] = count($getfiles);

    if (count($getfiles) > 0) {
        if ($search) {
            $search = Utils::unaccent($search);
            foreach ($getfiles as $key => $getfile) {
                $unaccent = Utils::unaccent(Utils::normalizeName($getfile->getNameHtml()));
                if (stripos($unaccent, $search) === false) {
                    unset($getfiles[$key]);
                }
            }
        }
        // Sort by date
        if ($sortby == 4) {
            usort(
                $getfiles,
                function ($a, $b) {
                    return $a->getModTime() - $b->getModTime();
                }
            );
        }
        // Sort by size
        if ($sortby == 3) {
            usort(
                $getfiles,
                function ($a, $b) {
                    return $a->getSize() - $b->getSize();
                }
            );
        }
        // Sort by name
        if ($sortby == 2) {
            usort(
                $getfiles,
                function ($a, $b) {
                    return strnatcasecmp($a->getNameHtml(), $b->getNameHtml());
                }
            );
        }

        // Reverse sorting
        if ($orderdir == 'desc') {
            $getfiles = array_reverse($getfiles);
        }

        // Display the files
        $alt = $setUp->getConfig('salt');
        $altone = $setUp->getConfig('session_name');
        $directlinks = $setUp->getConfig('direct_links');

        $response['recordsFiltered'] = count($getfiles);
        $counter = 0;
        $totcounter = 0;

        foreach ($getfiles as $key => $file) {
            $totcounter++;

            // Start output at start paging
            if ($totcounter > $start) {
                $counter++;
                // Exit if reach length
                if ($length !== -1 && $counter > $length) {
                    break;
                }
                $data = array();
                $data['DT_RowId'] = 'vfmRow-'.$totcounter;
                $thisdir = urldecode($location->getDir(false, true, false, 0));
                $thisfile = $file->getName();
                $thisname = $file->getNameHtml();
                $fullsize = $file->getSize();
                $thislink = base64_encode($location->getDir(false, true, false, 0).$file->getNameEncoded());
                $formatsize = $setUp->formatSize($fullsize);
                $formattime = $setUp->formatModTime($file->getModTime());
                $dash = md5($alt.$thislink.$altone.$alt);
                $ext = pathinfo($thisfile, PATHINFO_EXTENSION);
                $withoutExt = preg_replace('/.'.$ext.'$/', '', $thisfile);
                $del = $location->getDir(false, true, false, 0).$file->getNameEncoded();
                $cash = md5($thislink.$alt.$altone);
                $thisdel = $location->makeLink(false, $del, $location->getDir(false, true, false, 0));
                $imgdata = 'data-ext="'.$ext.'"';
                $normalized = Utils::normalizeName($thisname);
                $normalizedName = Utils::normalizeName($withoutExt);
                $linktarget = (strtolower($ext) == 'pdf' || $directlinks) ? 'target="_blank"' : '';
                $itemclass = 'class="item file full-lenght';

                if ($file->isValidForVideo()) {
                    $itemclass .= ' vid vfm-gall';
                }
                if ($file->isValidForThumb() && $setUp->getConfig('thumbnails')) {
                    $itemclass .= ' thumb vfm-gall';
                }
                $itemclass .= '"';

                if ($setUp->getConfig('enable_prettylinks') == true) {
                    $downlink = 'download/'.$thislink.'/h/'.$dash;
                    $imgdata .= ' data-name="'.$thisname.'" data-link="'.$thislink
                    .'" data-linkencoded="'.$thislink.'/h/'.$dash.'"';
                } else {
                    $downlink = 'vfm-admin/vfm-downloader.php?q='.$thislink.'&h='.$dash;
                    $imgdata .= ' data-name="'.$thisname.'" data-link="'.$thislink.'" data-linkencoded="'.$thislink.'&h='.$dash.'"';
                }

                // Set direct link skipping vfm-downloader.php
                // if ($directlinks) {
                //     $downlink = $location->getDir(false, true, false, 0).$file->getNameEncoded();
                // }

                if (!$gateKeeper->isAllowed('download_enable')) {
                    $downlink = '#';
                }
                $gallclass = "";
                $gallid = "";

                $iconkey = strtolower($file->getType());

                $thisicon = array_key_exists($iconkey, $_IMAGES) ? $_IMAGES[$iconkey] : 'file-earmark';

                if ($file->isValidForVideo()) {
                    $hasvideo = true;
                    $thisicon = "play-btn";
                    $imgdata .= ' data-type="video"';
                }

                if ($file->isValidForThumb()) {
                    $hasimage = true;
                    $imgdata .= ' data-type="image"';
                }

                $data['check'] = '<div class="checkbox checkbox-primary checkbox-circle"><label class="round-btn"><input type="checkbox" name="selecta" class="selecta" value="'.$thislink.'"></label></div>';

                $data['icon'] = '';

                // MP3 inline player link
                if ($file->isValidForAudio()) {
                    $hasaudio = true;
                                   
                    if ($setUp->getConfig('enable_prettylinks') == true) {
                        $linkaudio = "download/".$thislink."/h/".$dash;
                    } else {
                        $linkaudio = "vfm-admin/vfm-downloader.php?q=".$thislink."&h=".$dash;
                    }
                    if ($gateKeeper->isAllowed('download_enable')) {
                        $data['icon'] .= '<a type="audio/mp3" id="vfm-audio-'.$key.'" class="item sm2_button" href="'.$linkaudio.'&audio=play">';
                        $data['icon'] .= '<div class="icon-placeholder"><div class="cta">';
                        $data['icon'] .= '<i class="trackload bi bi-arrow-clockwise vfm-spin"></i>';
                        $data['icon'] .= '<i class="trackpause bi bi-pause-circle"></i>';
                        $data['icon'] .= '<i class="trackplay bi bi-disc vfm-spin"></i>';
                        $data['icon'] .= '<i class="trackstop bi bi-play-circle"></i>';
                        $data['icon'] .= '</div></div>';
                    } else {
                        $data['icon'] .= '<div class="icon-placeholder"><div class="cta"><i class="bi bi-file-earmark-music"></i></div></div>';
                    }
                } else {
                    if ($gateKeeper->isAllowed('download_enable')) {
                        $data['icon'] .= '<a href="'.$downlink.'" '.$imgdata.' '.$linktarget.' '.$itemclass.'>';
                    }
                    if ($setUp->getConfig('inline_thumbs') == true && $file->isValidForThumb()) {
                        $data['icon'] .= '<div class="icon-placeholder"><img src="'.$imageServer->showThumbnail(base64_decode($thislink), true).'"></div>';
                    } else {
                        $data['icon'] .= '<div class="icon-placeholder"><div class="cta"><i class="bi bi-'.$thisicon.'"></i></div></div>';
                    }
                }

                $data['icon'] .= '<div class="hover end-0"><div><div class="round-btn">';

                if ($file->isValidForThumb()) {
                    $data['icon'] .= '<i class="bi bi-zoom-in"></i>';
                } elseif ($file->isValidForVideo()) {
                    $data['icon'] .= '<i class="bi bi-play"></i>';
                } elseif (strtolower($ext) == 'pdf') {
                    $data['icon'] .= '<i class="bi bi-chevron-right"></i>';
                } elseif ($file->isValidForAudio()) {
                    $data['icon'] .= '<i class="bi bi-play-circle"></i>';
                } else {
                    $data['icon'] .= '<i class="bi bi-file-earmark-arrow-down"></i>';
                }
                $data['icon'] .= '</div><br>';
                $data['icon'] .= '<span class="badge rounded-pill bg-light">'.$formatsize.'</span>';
                $data['icon'] .= '</div></div>';
        
                if ($gateKeeper->isAllowed('download_enable')) {
                    $data['icon'] .= '</a>';

                    $data['icon'] .= '<div class="infopanel">';

                    if ($file->isValidForAudio()
                        || $file->isValidForThumb()
                        || $file->isValidForVideo()
                    ) {
                        $data['icon'] .= '<div class="minibtn"><a class="round-btn" href="'.$downlink.'"';
                        // $data['icon'] .= '<div class="minibtn" data-bs-toggle="tooltip" title="HERE YOUR MESSAGE"><a class="round-btn" href="'.$downlink.'"';
                        if ($directlinks) {
                            $data['icon'] .= ' target="_blank"';
                        }
                        $data['icon'] .= '>';
                        $data['icon'] .= '<i class="bi bi-download"></i></a></div>';
                    }
                }
                if ($gateKeeper->isAllowed('rename_enable')) {
                    $data['icon'] .= '<div class="icon text-center minibtn">
                        <button class="round-btn rename" data-thisdir="'.$thisdir.'" data-thisext="'.$ext.'" data-thisname="'.$normalizedName.'">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                    </div>';
                }
                if ($gateKeeper->isAllowed('delete_enable')) {
                    $data['icon'] .= '<div class="minibtn">
                        <button class="round-btn del" data-name="'.$thisfile.'" data-link="'.$thisdel.'&h='.$cash.'">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>';
                }
                $data['icon'] .= '</div>';
            
                $data['file_name'] = '<div class="relative">';

                if ($gateKeeper->isAllowed('download_enable')) {
                    $data['file_name'] .= '<a href="'.$downlink.'" '.$imgdata.' '.$linktarget.' '.$itemclass.'>';

                    $data['file_name'] .= $normalized;
                    $data['file_name'] .= '</a>';
                } else {
                    $data['file_name'] .= '<span '.$itemclass.'>';

                    $data['file_name'] .= $normalized;
                    $data['file_name'] .= '</span>';
                }

                $data['file_name'] .= '<div class="grid-item-title"><span>'.$normalized.'</span></div>';

                if ($gateKeeper->isAllowed('download_enable')) {
                    $data['file_name'] .= '<span class="hover end-0">';
                    if ($file->isValidForThumb()) {
                        $data['file_name'] .= '<i class="bi bi-zoom-in"></i>';
                    } elseif (strtolower($ext) == 'pdf') {
                        $data['file_name'] .= '<i class="bi bi-chevron-right"></i>';
                    } elseif ($file->isValidForVideo()) {
                        $data['file_name'] .= '<i class="bi bi-play"></i>';
                    } else {
                        $data['file_name'] .= '<i class="bi bi-file-earmark-arrow-down"></i>';
                    }
                    $data['file_name'] .= '</span>';
                }

                $data['file_name'] .= '</div>';

                $data['size'] = '<span class="text-center">'.$formatsize.'</span>';

                $data['last_change'] = '<span class="text-center">'.$formattime.'</span>';

                if ($gateKeeper->isAllowed('rename_enable')) {
                    $data['edit'] = '<button class="round-btn btn-mini rename" data-thisdir="'.$thisdir.'" data-thisext="'.$ext.'" data-thisname="'.$normalizedName.'"><i class="bi bi-pencil-square"></i></button>';
                }
                
                $data['delete'] = '';

                if ($gateKeeper->isAllowed('delete_enable')) {
                    $data['delete'] .= '<div class="d-none d-md-block"><button class="round-btn btn-mini del" data-name="'.$thisfile.'" data-link="'.$thisdel.'&h='.$cash.'"><i class="bi bi-x-lg"></i></button></div>';
                }

                $data['delete'] .= '<div class="dropdown d-md-none text-end"><a class="round-btn btn-mini dropdown-toggle" data-bs-toggle="dropdown" href="javascript:void(0)">
                    <i class="bi bi-gear-wide-connected"></i></a><ul class="dropdown-menu dropdown-menu-right"><li><a class="dropdown-item" href="'.$downlink.'" ';

                if (strtolower($ext) == 'pdf' || $directlinks) {
                    $data['delete'] .= ' target="_blank"';
                }
                $data['delete'] .= '>';
                $data['delete'] .= '<i class="bi bi-cloud-arrow-down"></i> '.$setUp->getString("download").'</a></li>';

                if ($gateKeeper->isAllowed('rename_enable')) {
                    $data['delete'] .= '<li>
                    <a class="rename dropdown-item" data-thisdir="'.$thisdir.'" data-thisext="'.$ext.'" data-thisname="'.$normalizedName.'" href="javascript:void(0)">
                    <i class="bi bi-pencil-square"></i> '.$setUp->getString("rename").'</a></li>';
                }
                if ($gateKeeper->isAllowed('delete_enable')) {
                    $data['delete'] .= '<li>
                    <a class="del dropdown-item" href="javascript:void(0)" data-link="'.$thisdel.'&h='.$cash.'" data-name="'.$thisfile.'"><i class="bi bi-trash"></i> '.$setUp->getString("delete").'</a></li>';
                }
                $data['delete'] .= '</ul></div></div>';

                array_push($totaldata, $data);

            } // end if counter start
        } // end foreach.
    } // end if items > 0.
} // end location allowed

$response['data'] = $totaldata;

echo json_encode($response);
exit;

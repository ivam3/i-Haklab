<?php
/**
 * VFM - veno file manager: include/breadcrumbs.php
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
if (!defined('VFM_APP')) {
    return;
}
/**
* BreadCrumbs
*/
if ($gateKeeper->isAccessAllowed()
) { ?>
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb small px-3">
    <?php
    if ($setUp->getConfig("show_path") !== true) {
        $cleandir = "?dir=".substr($setUp->getConfig('starting_dir').$gateKeeper->getUserInfo('dir'), 2);
        $stolink = $location->makeLink(false, null, $location->getDir(false, true, false, 1));
        $stodeeplink = $location->makeLink(false, null, $location->getDir(false, true, false, 0));

        if (strlen($stolink) > strlen($cleandir)) {
            $parentlink = $location->makeLink(false, null, $location->getDir(false, true, false, 1));
        } else {
            $parentlink = "?dir=";
        }
        if (strlen($stodeeplink) > strlen($cleandir)
        ) { ?>
        <li class="breadcrumb-item">
            <a href="<?php echo $parentlink; ?>">
                <i class="bi bi-chevron-left"></i> <i class="bi bi-folder-fill"></i>
            </a>
        </li>
            <?php
        }
    }

    if ($setUp->getConfig("show_foldertree") == true && $gateKeeper->isAllowed('viewdirs_enable')) { ?>
        <li class="breadcrumb-item">
            <a href="#" data-bs-toggle="modal" data-bs-target="#archive-map" data-action="breadcrumbs">
                <i class="bi bi-diagram-3-fill"></i> 
            </a>
        </li>
        <?php
    }
    
    if ($setUp->getConfig("show_path") == true) {
        if (strlen($setUp->getConfig('starting_dir')) < 3) {
            ?>
        <li class="breadcrumb-item">
            <a href="?dir=">
                <i class="bi bi-folder-fill"></i> <?php echo $setUp->getString("root"); ?>
            </a>
        </li>
            <?php
        }
        $totdirs = count($location->path);
        foreach ($location->path as $key => $dir) {
                $stolink = $location->makeLink(false, null, $location->getDir(false, true, false, $totdirs -1 - $key)); ?>
                <li class="breadcrumb-item"><a href="<?php echo $stolink; ?>">
                    <i class="bi bi-folder2-open"></i> 
                    <?php echo urldecode($location->getPathLink($key, false)); ?>
                </a></li>
            <?php
        }
    } ?>
    </ol>
    </nav>
    <?php
}

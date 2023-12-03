<?php
/**
 * VFM - veno file manager index
 *
 * PHP version >= 5.3
 *
 * @category  PHP
 * @package   VenoFileManager
 * @author    Nicola Franchini <info@veno.it>
 * @copyright 2013 - 2022 Nicola Franchini
 * @license   Exclusively sold on CodeCanyon: https://codecanyon.net/item/veno-file-manager-host-and-share-files/6114247
 * @link      https://filemanager.veno.it/
 */
define('VFM_APP', true);
require_once dirname(__FILE__).'/vfm-admin/include/head.php';
require_once dirname(__FILE__).'/vfm-admin/include/activate.php';
?>
<!doctype html>
<html lang="<?php echo $setUp->lang; ?>"<?php echo $rtl_att; ?>>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $setUp->getConfig("appname"); ?></title>
    <?php echo $setUp->printIcon("vfm-admin/_content/uploads/"); ?>

    <meta name="description" content="File Manager">

    <?php require 'vfm-admin/include/load-css.php'; ?>
    <script type="text/javascript" src="vfm-admin/assets/jquery/jquery-3.3.1.min.js"></script>

</head>
    <body id="uparea" class="<?php echo $bodyclass; ?>"<?php echo $bodydata; ?>>
        <div id="error"><?php echo $setUp->printAlert(); ?></div>
        <div class="overdrag"></div>
            <?php
            /**
             * ******************** HEADER ********************
             */
            if ($setUp->getConfig('header_position') == 'above') {
                include dirname(__FILE__).'/vfm-admin'.$template->include('header');
                include dirname(__FILE__).'/vfm-admin'.$template->include('navbar');
            } else {
                include dirname(__FILE__).'/vfm-admin'.$template->include('navbar');
                include dirname(__FILE__).'/vfm-admin'.$template->include('header');
            }
            ?>
        <div class="container mb-auto pt-3">
            <div class="main-content row">
            <?php
            if ($getdownloadlist) :
                /**
                 * ********* SARED FILES DOWNLOADER *********
                 */
                include dirname(__FILE__).'/vfm-admin'.$template->include('downloader');
            elseif ($getrp) :
                /**
                 * **************** PASSWORD RESET ****************
                 */
                include dirname(__FILE__).'/vfm-admin'.$template->include('reset');
            else :
                /**
                 * **************** FILEMANAGER **************
                 */
                if (!$getreg || $setUp->getConfig('registration_enable') == false) {
                    include dirname(__FILE__).'/vfm-admin/include/user-redirect.php';
                    include dirname(__FILE__).'/vfm-admin'.$template->include('remote-uploader');
                    include dirname(__FILE__).'/vfm-admin'.$template->include('notify-users');
                    include dirname(__FILE__).'/vfm-admin'.$template->include('uploadarea');
                    include dirname(__FILE__).'/vfm-admin'.$template->include('breadcrumbs');
                    include dirname(__FILE__).'/vfm-admin'.$template->include('list-folders');
                    include dirname(__FILE__).'/vfm-admin'.$template->include('list-files');
                    include dirname(__FILE__).'/vfm-admin'.$template->include('disk-space');
                }
                if ($getreg && $setUp->getConfig('registration_enable') == true) {
                    include dirname(__FILE__).'/vfm-admin'.$template->include('register');
                } else {
                    include dirname(__FILE__).'/vfm-admin'.$template->include('login');
                }
            endif; ?>
            </div> <!-- .main-content -->
        </div> <!-- .container -->
        <?php
        /**
         * ******************** FOOTER ********************
         */
        require dirname(__FILE__).'/vfm-admin'.$template->include('footer');
        require dirname(__FILE__).'/vfm-admin'.$template->include('modals');
        require dirname(__FILE__).'/vfm-admin/include/load-js.php';
        ?>
    </body>
</html>
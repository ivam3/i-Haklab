<?php
/**
 * VFM - veno file manager: include/list-folders.php
 * list folders inside curret directory
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
* List Folders
*/
if ($gateKeeper->isAccessAllowed() && $gateKeeper->isAllowed('viewdirs_enable')) { ?>
        <div class="vfmblock col-12">
        <section class="vfmblock tableblock ghost ghost-hidden bg-light-lighter p-3 shadow-sm">
            <table class="table w-100" id="foldertable">
                <thead>
                    <tr class="rowa two">
                        <td></td>
                        <td class="small"><span class="sorta nowrap"><i class="bi bi-sort-alpha-down"></i></span></td>
                        <td class="small d-none d-md-table-cell"><span class="sorta nowrap"><i class="bi bi-calendar-event"></i></i></span></td>
                        <?php
                        if ($location->editAllowed()) {
                            // mobile menu
                            if (($setUp->getConfig("download_dir_enable") === true && $gateKeeper->isAllowed('download_enable'))
                                || $gateKeeper->isAllowed('rename_dir_enable')
                                || $gateKeeper->isAllowed('delete_dir_enable')
                            ) { ?>
                            <td class="small text-end d-sm-none">
                            </td>
                                <?php
                            } ?>
                            <?php
                            // download column
                            if ($setUp->getConfig("download_dir_enable") === true && $gateKeeper->isAllowed('download_enable')) { ?>
                            <td class="small text-center d-none d-md-table-cell">
                                <i class="bi bi-download"></i>
                            </td>
                                <?php
                            } ?>
                            <?php
                            // edit column
                            if ($gateKeeper->isAllowed('rename_dir_enable')) { ?>
                            <td class="small text-center d-none d-md-table-cell">
                                <i class="bi bi-pencil"></i>
                            </td>
                                <?php
                            } ?>
                            <?php
                            // delete column
                            if ($gateKeeper->isAllowed('delete_dir_enable')) { ?>
                                <td class="small text-center d-none d-md-table-cell">
                                    <i class="bi bi-trash"></i>
                                </td>
                                <?php
                            }
                        } ?>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </section>
        </div>
        <?php
} // END isAccessAllowed();

<?php
/**
 * VFM - veno file manager: include/uploadarea.php
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
 * UPLOAD AREA
 */
if ($location->editAllowed() && ($gateKeeper->isAllowed('upload_enable') || $gateKeeper->isAllowed('newdir_enable'))) { ?>
    <section class="vfmblock uploadarea py-2 col-12">
        <div class="row">
		<?php
		if(!isset($_SERVER['QUERY_STRING'])){
			$_SERVER['QUERY_STRING'] = basename($_SERVER['PHP_SELF']);
		}

		$post_url = Utils::removeQS($_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'], array('response'));

    /**
     * Upload files
     */
    if ($gateKeeper->isAllowed('upload_enable')) {
        $upload_class = "col-12";
        if ($gateKeeper->isAllowed('newdir_enable')) {
            $upload_class = "col-sm-6";
        } ?>
        <form enctype="multipart/form-data" method="post" id="upForm" action="<?php echo htmlspecialchars($post_url);?>" class="mb-2 <?php echo $upload_class; ?>">
            <input type="hidden" name="location" value="<?php echo $location->getDir(true, false, false, 0); ?>">       
            <div id="upload_container" class="input-group">
                <span class="input-group-text ie_hidden">
                    <i class="bi bi-file-earmark-plus"></i>
                </span>
                <div id="upload_file" class="d-none">
                    <span class="upfile btn btn-primary btn-file">
                        <i class="bi bi-files"></i>
                        <input name="userfile[]" type="file" class="upload_file" multiple />
                    </span>
                </div>
                <input class="form-control" type="text" readonly name="fileToUpload" id="fileToUpload" placeholder="<?php echo $setUp->getString("browse"); ?>">
                    <button class="upload_sumbit btn btn-primary d-none" type="submit" id="upformsubmit" disabled>
                        <i class="bi bi-upload"></i>
                    </button>
                    <button type="button" class="btn btn-primary px-4" id="upchunk">
                        <i class="bi bi-upload"></i>
                    </button>
            </div>
        </form>
        <?php
    }

    /**
     * Create directory
     */
    if ($gateKeeper->isAllowed('newdir_enable')) {
        $newdir_class = "col-12";
        if ($gateKeeper->isAllowed('upload_enable')) {
            $newdir_class = "col-sm-6";
        } ?>
        <form enctype="multipart/form-data" method="post" action="<?php echo htmlspecialchars($post_url);?>" class="mb-2 <?php echo $newdir_class; ?>">
            <div id="newdir_container" class="input-group">
                <span class="input-group-text"><i class="bi bi-folder-plus"></i></span>
                <input name="userdir" type="text" class="upload_dirname form-control" 
                placeholder="<?php echo $setUp->getString("make_directory"); ?>" />
                <div class="upfolder-over"></div>
                <button class="btn btn-primary upfolder px-4" type="submit">
                    <i class="bi bi-plus-lg"></i>
                </button>
            </div>
        </form>
        <?php
    }

    if ($gateKeeper->isAllowed('upload_enable')
        && strlen($setUp->getConfig('preloader')) > 0
    ) {
        // upload progress bar
        $percentage_class = $setUp->getConfig('show_percentage') ? ' fullp' : ''; ?>

        <div class="<?php echo $percentage_class;?>">
            <div class="progress active" id="progress-up">
                <div class="upbar progress-bar progress-bar-striped progress-bar-animated <?php echo $setUp->getConfig('progress_color'); ?>" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                    <span class="propercent"></span>
                </div>
            </div>
        <?php
        // second progress bar for individual files
        if ($setUp->getConfig('single_progress')) { ?>
            <div class="progress progress-single" id="progress-up-single">
                <div class="upbarfile progress-bar <?php echo $setUp->getConfig('progress_color'); ?>" 
                    role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                    <span class="propercent"></span>
                </div>
            </div>
            <?php
        } ?>
        </div>
        <?php
    } ?>
    </div>
    </section>
    <?php
}

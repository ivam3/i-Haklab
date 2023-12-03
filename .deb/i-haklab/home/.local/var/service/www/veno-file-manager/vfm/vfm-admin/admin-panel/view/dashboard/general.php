<?php
/**
 * GENERAL SETTINGS
 */

/**
 * Timezones list with GMT offset
 *
 * @return array
 */
function tzList()
{
    $zones_array = array();
    $timestamp = time();
    foreach (timezone_identifiers_list() as $key => $zone) {
        date_default_timezone_set($zone);
        $zones_array[$key]['zone'] = $zone;
        $zones_array[$key]['diff_from_GMT'] = 'UTC/GMT ' . date('P', $timestamp);
    }
    return $zones_array;
} ?>
<div class="row mb-3">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-center align-items-center">
                <h4 class="m-0" id="view-general"><i class="bi bi-gear-wide-connected"></i> <?php print $setUp->getString("general_settings"); ?></h4>
                <button type="button" class="btn ms-auto" data-bs-toggle="collapse" data-bs-target="#card-general" aria-expanded="false">
                    <i class="bi bi-dash-lg"></i>
                </button>
            </div>
            <div class="collapse show" id="card-general">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group mb-2">
                                <label class="form-label"><?php print $setUp->getString("app_name"); ?></label>
                                <input type="text" class="form-control" value="<?php print $setUp->getConfig('appname'); ?>" name="appname">
                            </div>
                            <div class="row mb-2">
                                <div class="col-12">
<?php $formchecked = $setUp->getConfig('show_usermenu') ? ' checked' : ''; ?>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" role="switch" type="checkbox" name="show_usermenu" id="show_usermenu"<?php echo $formchecked; ?>>
                                        <label class="form-check-label" for="show_usermenu"><i class="bi bi-person-circle"></i> <?php print $setUp->getString("show_usermenu"); ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2 toggle">
                                <div class="col-12">
<?php $formchecked = $setUp->getConfig('show_langmenu') ? ' checked' : ''; ?>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" role="switch" type="checkbox" name="show_langmenu" id="show_langmenu"<?php echo $formchecked; ?>>
                                        <label class="form-check-label" for="show_langmenu"><i class="bi bi-flag"></i> <?php print $setUp->getString("show_langmenu"); ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="toggled">
                                <div class="row mb-2 toggled">
                                    <div class="col-12">
<?php $formchecked = $setUp->getConfig('show_langname') ? ' checked' : ''; ?>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" role="switch" type="checkbox" name="show_langname" id="show_langname"<?php echo $formchecked; ?>>
                                            <label class="form-check-label" for="show_langname"><i class="bi bi-chat-left-quote"></i> <?php print $setUp->getString("show_current_language"); ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12">
<?php $formchecked = $setUp->getConfig('browser_lang') ? ' checked' : ''; ?>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" role="switch" type="checkbox" name="browser_lang" id="browser_lang"<?php echo $formchecked; ?>>
                                        <label class="form-check-label" for="browser_lang"><i class="bi bi-translate"></i> <?php print $setUp->getString("detect_browser_language"); ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12">
<?php $formchecked = $setUp->getConfig('global_search') ? ' checked' : ''; ?>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" role="switch" type="checkbox" name="global_search" id="global_search"<?php echo $formchecked; ?>>
                                        <label class="form-check-label" for="global_search"><i class="bi bi-search"></i> <?php print $setUp->getString("global_search"); ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12">
<?php $formchecked = $setUp->getConfig('show_foldertree') ? ' checked' : ''; ?>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" role="switch" type="checkbox" name="show_foldertree" id="show_foldertree"<?php echo $formchecked; ?>>
                                        <label class="form-check-label" for="show_foldertree"><i class="bi bi-diagram-3"></i> <?php print $setUp->getString("archive_map"); ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12">
<?php $formchecked = $setUp->getConfig('show_path') ? ' checked' : ''; ?>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" role="switch" type="checkbox" name="show_path" id="show_path"<?php echo $formchecked; ?>>
                                        <label class="form-check-label" for="show_path"><i class="bi bi-three-dots"></i> <?php print $setUp->getString("display_breadcrumbs"); ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12">
<?php $formchecked = $setUp->getConfig('upload_notification_enable') ? ' checked' : ''; ?>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" role="switch" type="checkbox" name="upload_notification_enable" id="upload_notification_enable"<?php echo $formchecked; ?>>
                                        <label class="form-check-label" for="upload_notification_enable"><i class="bi bi-envelope"></i> <?php print $setUp->getString("can_notify_uploads"); ?></label>
                                    </div>
                                </div>
                            </div>

<?php
/*
                            <div class="row mb-2">
                                <div class="col-12">
                                    <h6><i class="bi bi-file-zip" aria-hidden="true"></i> <?php print $setUp->getString("zip_multiple_files"); ?></h6>
                                </div>
                                <div class="col-6 col-sm-12 col-lg-6">
                                    <label class="form-label"><?php print $setUp->getString("max_files"); ?></label>
                                    <input type="number" class="form-control" name="max_zip_files" value="<?php echo $setUp->getConfig('max_zip_files'); ?>">
                                </div>
                                <div class="col-6 col-sm-12 col-lg-6 form-group">
                                    <label class="form-label"><?php print $setUp->getString("max_filesize"); ?></label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="max_zip_filesize" value="<?php echo $setUp->getConfig('max_zip_filesize'); ?>">
                                        <span class="input-group-text">MB</span>
                                    </div> 
                                </div>
                            </div>
*/ ?>
                        </div> <!-- col 6 -->

                        <div class="col-sm-6">
                            <div class="row form-group">
                                <div class="col-12 mb-2">
                                    <div class="form-group">
                                        <label class="form-label"><?php print $setUp->getString("application_url"); ?></label>
                                        <input type="url" class="form-control" placeholder="http://.../" value="<?php print $setUp->getConfig('script_url'); ?>" name="script_url">
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <label class="form-label"><?php echo $setUp->getString("default_lang"); ?></label>
                                    <select class="form-select" name="lang">
<?php
foreach ($translations as $key => $lingua) {
    $langselected = $key == $setUp->getConfig('lang') ? ' selected' : '';
    ?>
                                        <option value="<?php echo $key; ?>"<?php echo $langselected; ?>><?php echo $lingua; ?></option>
    <?php
} ?>
                                    </select>
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <label class="form-label"><?php print $setUp->getString("direction"); ?></label>
                                    <select class="form-select" name="txt_direction">
<?php $optionselected = $setUp->getConfig('txt_direction') == "LTR" ? ' selected' : ''; ?>
                                        <option value="LTR"<?php echo $optionselected; ?>>Left to Right</option>
<?php $optionselected = $setUp->getConfig('txt_direction') == "RTL" ? ' selected' : ''; ?>
                                        <option value="RTL"<?php echo $optionselected; ?>>Right to Left</option>
                                    </select>
                                </div>
                                <div class="col-12 mb-2">
                                    <label class="form-label"><?php print $setUp->getString("time_format"); ?></label>
                                    <select class="form-select" name="time_format">
<?php $optionselected = $setUp->getConfig('time_format') == "d/m/Y - H:i" ? ' selected' : ''; ?>
                                        <option value="d/m/Y"<?php echo $optionselected; ?>>d/m/Y</option>
<?php $optionselected = $setUp->getConfig('time_format') == "m/d/Y - H:i" ? ' selected' : ''; ?>
                                        <option value="m/d/Y"<?php echo $optionselected; ?>>m/d/Y</option>
<?php $optionselected = $setUp->getConfig('time_format') == "Y/m/d - H:i" ? ' selected' : ''; ?>
                                        <option value="Y/m/d"<?php echo $optionselected; ?>>Y/m/d</option>
                                    </select>
                                </div>
                            </div><!-- row -->

                            <div class="row form-group">
                                <div class="col-12 mb-2">
<?php
if (strlen($setUp->getConfig('default_timezone')) < 3) {
    $thistime = "UTC";
} else {
    $thistime = $setUp->getConfig('default_timezone');
} ?>
                                    <label class="form-label"><?php echo $setUp->getString("default_timezone"); ?></label>
                                    <select class="form-select" name="default_timezone">
<?php
foreach (tzList() as $tim) {
    $optionselected = $tim['zone'] == $thistime ? ' selected' : ''; ?>
                                        <option value="<?php echo $tim['zone']; ?>"<?php echo $optionselected; ?>><?php echo $tim['diff_from_GMT'] . ' - ' . $tim['zone']; ?></option>
    <?php
} ?>
                                    </select>
                                </div>

                                <div class="col-12 mb-2">
                                    <?php $formchecked = $setUp->getConfig('enable_prettylinks') ? ' checked' : ''; ?>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" role="switch" type="checkbox" name="enable_prettylinks" id="disable-prettylinks" <?php echo $formchecked; ?>>
                                        <label class="form-check-label" for="disable-prettylinks"><?php print $setUp->getString("prettylinks"); ?></label>
                                    </div>
                                    <div class="form-text">
                                        <?php echo $setUp->getString("prettylink_old"); ?>:<br>
                                        <code class="bg-danger bg-opacity-10">/vfm-admin/vfm-downloader.php?q=xxx</code><br>
                                        <?php echo $setUp->getString("prettylink"); ?>:<br>
                                        <code class="bg-danger bg-opacity-10">/download/xxx</code>
                                    </div>
                                    <?php $formchecked = $setUp->getConfig('direct_links') ? ' checked' : ''; ?>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" role="switch" type="checkbox" name="direct_links" id="direct_links" <?php echo $formchecked; ?>>
                                        <label class="form-check-label" for="direct_links"><i class="bi bi-eye-fill"></i><i class="bi bi-arrow-right"></i><i class="bi bi-files"></i> <?php print $setUp->getString("direct_links"); ?></label>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- col-sm-6 -->
                    </div> <!-- row -->
                </div> <!-- card-body -->
            </div> <!-- collapse -->
        </div> <!-- card -->
    </div> <!-- col-12 -->
</div> <!-- row -->

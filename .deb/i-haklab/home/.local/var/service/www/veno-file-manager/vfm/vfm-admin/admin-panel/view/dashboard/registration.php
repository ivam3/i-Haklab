<?php
/**
 * VFM - veno file manager: admin-panel/view/dashboard/registration.php
 * administration registration block
 *
 * @package VenoFileManager
 */

/**
* ROLE PERMISSIONS
**/
$regdirs = $setUp->getConfig('registration_user_folders');
$regdirsarray = $regdirs ? json_decode($regdirs, true) : array();
?>
<div class="row mb-3">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-center align-items-center">
                <h4 class="m-0" id="view-registration"><i class="bi bi-person-plus"></i> <?php print $setUp->getString('registration'); ?></h4>
                <button type="button" class="btn ms-auto" data-bs-toggle="collapse" data-bs-target="#card-registration" aria-expanded="false">
                    <i class="bi bi-dash-lg"></i>
                </button>
            </div>
            <div class="collapse show" id="card-registration">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="checkbox">
                            <?php $formchecked = $setUp->getConfig('registration_enable') ? ' checked' : ''; ?>
                            <div class="form-check form-switch">
                                <input class="form-check-input" role="switch" type="checkbox" name="registration_enable" id="registration_enable" <?php echo $formchecked; ?>>
                                <label class="form-check-label" for="registration_enable"><?php print $setUp->getString("enabled"); ?></label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label"><?php print $setUp->getString("role"); ?></label>
                        <div class="input-group mb-3">
                            <select class="form-select" name="registration_role">
                            <?php
                            foreach ($allroles_nosuperadmin as $key => $rolename) {
                                $rolekey = $key == 'admin' ? '' : '_'.$key;
                                $formselected = $setUp->getConfig('registration_role') === $key ? ' selected' : '';
                                ?>
                                <option value="<?php echo $key; ?>"<?php echo $formselected; ?>><?php echo $rolename; ?></option>
                                <?php
                            } ?>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label"><?php print $setUp->getString("keep_links"); ?></label>
                            <select class="form-select" name="registration_lifetime">
                            <?php
                            $default_registration_lifetime = $setUp->getConfig('registration_lifetime', '-1 day');
                            foreach ($registration_lifetime as $key => $value) {
                                $formselected = $default_registration_lifetime === $key ? ' selected' : '';
                                ?>
                                <option value="<?php echo $key; ?>"<?php echo $formselected; ?>><?php echo $value; ?></option>
                                <?php
                            } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 togglequota">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label class="form-label"><?php print $setUp->getString("user_folder"); ?></label>
                                    <select name="reguserfolders[]" id="r-reguserfolders" class="assignfolder selectpicker" multiple="multiple" data-width="100%" data-live-search="1" data-live-search-normalize="1" data-selected-text-format="count" data-syle="" data-style-base="form-select">
                                    <?php $formselected = in_array('vfm_reg_new_folder', $regdirsarray) ? ' selected' : ''; ?>
                                    <option value="vfm_reg_new_folder"<?php echo $formselected; ?>><?php echo $setUp->getString("new_username_folder"); ?></option>
                                    <?php
                                    foreach ($admin->getFolders() as $folder) {
                                        $formselected = in_array($folder, $regdirsarray) ? ' selected' : '';
                                        echo '<option value="'.$folder.'"'.$formselected.'>'.$folder.'</option>';
                                    } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group userquota mb-3">
                                    <label class="form-label"><?php print $setUp->getString("available_space"); ?></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-segmented-nav"></i></span>
                                        <select class="form-select" name="regquota">
                                            <option value=""><?php print $setUp->getString("unlimited"); ?></option>
                                            <?php
                                            foreach ($_QUOTA as $value) {
                                                $formatsize = $setUp->formatSize(($value*1024*1024));
                                                echo '<option value="'.$value.'"';
                                                if ($setUp->getConfig('registration_user_quota') == $value) {
                                                    echo ' selected';
                                                }
                                                echo '>'.$formatsize.'</option>';
                                            } ?>
                                        </select>
                                    </div> <!-- input-group -->
                                </div> <!-- userquota -->
                            </div> <!-- col-sm-12 -->
                        </div> <!-- row -->
                    </div> <!-- col-md-4 -->
                </div> <!-- row -->
            </div> <!-- box-body -->
            </div>
        </div> <!-- box -->
    </div>
</div>
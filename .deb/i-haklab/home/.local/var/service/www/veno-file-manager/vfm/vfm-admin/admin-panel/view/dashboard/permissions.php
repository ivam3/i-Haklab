<?php
/**
 * ROLE PERMISSIONS
 */

$rolename = $setUp->getString("role_guest");
$rolekey = '_guest';
?>
<div class="row mb-3">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-center align-items-center">
                <h4 class="m-0" id="view-permissions"><i class="bi bi-stoplights"></i> <?php echo $setUp->getString('permissions'); ?></h4>
                <button type="button" class="btn ms-auto" data-bs-toggle="collapse" data-bs-target="#card-permissions" aria-expanded="false">
                    <i class="bi bi-dash-lg"></i>
                </button>
            </div>
            <div class="collapse show" id="card-permissions">
            <div class="card-body">
                <h5><?php echo $rolename; ?></h5>
                <div class="row toggle-reverse-next mb-2">
                    <div class="col-sm-6 bg-danger bg-opacity-10 py-2">
                        <div class="form-group">
                            <?php $formchecked = $setUp->getConfig('require_login') ? ' checked' : ''; ?>
                            <div class="form-check form-switch m-0">
                                <input class="form-check-input" role="switch" type="checkbox" name="require_login" id="require_login" <?php echo $formchecked; ?>>
                                <label class="form-check-label" for="require_login"><i class="bi bi-lock-fill"></i> <?php print $setUp->getString("require_login"); ?></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="reverse-toggle-target">
                    <div class="row">
                        <div class="col-sm-6">
                            <h6><i class="bi bi-file-earmark-fill"></i> <?php print $setUp->getString("files"); ?></h6>
                            <div class="toggle">
                                <?php $formchecked = $setUp->getConfig('view_enable'.$rolekey) ? ' checked' : ''; ?>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" role="switch" type="checkbox" name="view_enable<?php echo $rolekey; ?>" id="view_enable<?php echo $rolekey; ?>" <?php echo $formchecked; ?>>
                                    <label class="form-check-label" for="view_enable<?php echo $rolekey; ?>">
                                        <i class="bi bi-eye"></i> <?php print $setUp->getString("view_files"); ?></label>
                                </div>
                            </div>
                            <div class="toggleme">
                                <div class="toggle">
                                    <?php $formchecked = $setUp->getConfig('download_enable'.$rolekey) ? ' checked' : ''; ?>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" role="switch" type="checkbox" name="download_enable<?php echo $rolekey; ?>" id="download_enable<?php echo $rolekey; ?>" <?php echo $formchecked; ?>>
                                        <label class="form-check-label" for="download_enable<?php echo $rolekey; ?>">
                                            <i class="bi bi-cloud-arrow-down"></i> <?php print $setUp->getString("download_files"); ?></label>
                                    </div>
                                </div>
                                <div class="checkbox">
                                    <?php $formchecked = $setUp->getConfig('sendfiles_enable'.$rolekey) ? ' checked' : ''; ?>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" role="switch" type="checkbox" name="sendfiles_enable<?php echo $rolekey; ?>" id="sendfiles_enable<?php echo $rolekey; ?>" <?php echo $formchecked; ?>>
                                        <label class="form-check-label" for="sendfiles_enable<?php echo $rolekey; ?>">
                                            <i class="bi bi-send"></i> <?php print $setUp->getString("share_files"); ?></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <h6><i class="bi bi-folder-fill"></i> <?php print $setUp->getString("folders"); ?></h6>
                            <?php $formchecked = $setUp->getConfig('viewdirs_enable'.$rolekey) ? ' checked' : ''; ?>
                            <div class="form-check form-switch">
                                <input class="form-check-input" role="switch" type="checkbox" name="viewdirs_enable<?php echo $rolekey; ?>" id="viewdirs_enable<?php echo $rolekey; ?>" <?php echo $formchecked; ?>>
                                <label class="form-check-label" for="viewdirs_enable<?php echo $rolekey; ?>">
                                    <i class="bi bi-eye"></i> <?php print $setUp->getString("view_folders"); ?></label>
                            </div>
                        </div>
                    </div>
                </div>
            <hr>
            <?php
            foreach ($allroles_nosuperadmin as $key => $rolename) {
                $rolekey = $key == 'admin' ? '' : '_'.$key;
                ?>
                <h5><?php echo $rolename; ?></h5>
                <div class="row">
                    <div class="col-sm-6">
                        <h6><i class="bi bi-file-earmark-fill"></i> <?php print $setUp->getString("files"); ?></h6>
                <?php
                if ($key == 'user') {
                    ?>
                        <div class="toggle">
                            <?php $formchecked = $setUp->getConfig('view_enable'.$rolekey) ? ' checked' : ''; ?>
                            <div class="form-check form-switch">
                                <input class="form-check-input" role="switch" type="checkbox" name="view_enable<?php echo $rolekey; ?>" id="view_enable<?php echo $rolekey; ?>" <?php echo $formchecked; ?>>
                                <label class="form-check-label" for="view_enable<?php echo $rolekey; ?>">
                                    <i class="bi bi-eye"></i> <?php print $setUp->getString("view_files"); ?></label>
                            </div>
                        </div>
                        <div class="toggleme">
                            <div class="toggle">
                                <?php $formchecked = $setUp->getConfig('download_enable'.$rolekey) ? ' checked' : ''; ?>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" role="switch" type="checkbox" name="download_enable<?php echo $rolekey; ?>" id="download_enable<?php echo $rolekey; ?>" <?php echo $formchecked; ?>>
                                    <label class="form-check-label" for="download_enable<?php echo $rolekey; ?>">
                                        <i class="bi bi-cloud-arrow-down"></i> <?php print $setUp->getString("download_files"); ?></label>
                                </div>
                            </div>
                            <div class="checkbox">
                                <?php $formchecked = $setUp->getConfig('sendfiles_enable'.$rolekey) ? ' checked' : ''; ?>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" role="switch" type="checkbox" name="sendfiles_enable<?php echo $rolekey; ?>" id="sendfiles_enable<?php echo $rolekey; ?>" <?php echo $formchecked; ?>>
                                    <label class="form-check-label" for="sendfiles_enable<?php echo $rolekey; ?>">
                                        <i class="bi bi-send"></i> <?php print $setUp->getString("share_files"); ?></label>
                                </div>
                            </div>
                        </div>
                    <?php
                } // End user perms
                ?>
                <?php
                if ($key !== 'user') {
                    ?>
                        <div class="checkbox">
                            <?php $formchecked = $setUp->getConfig('sendfiles_enable'.$rolekey) ? ' checked' : ''; ?>
                            <div class="form-check form-switch">
                                <input class="form-check-input" role="switch" type="checkbox" name="sendfiles_enable<?php echo $rolekey; ?>" id="sendfiles_enable<?php echo $rolekey; ?>" <?php echo $formchecked; ?>>
                                <label class="form-check-label" for="sendfiles_enable<?php echo $rolekey; ?>">
                                    <i class="bi bi-send"></i> <?php print $setUp->getString("share_files"); ?></label>
                            </div>
                        </div>
                    <?php
                } // End user perms
                ?>
                        <div class="checkbox">
                            <?php $formchecked = $setUp->getConfig('upload_enable'.$rolekey) ? ' checked' : ''; ?>
                            <div class="form-check form-switch">
                                <input class="form-check-input" role="switch" type="checkbox" name="upload_enable<?php echo $rolekey; ?>" id="upload_enable<?php echo $rolekey; ?>" <?php echo $formchecked; ?>>
                                <label class="form-check-label" for="upload_enable<?php echo $rolekey; ?>">
                                    <i class="bi bi-cloud-arrow-up"></i> <?php print $setUp->getString("upload_files"); ?></label>
                            </div>
                        </div>
                <?php
                if ($key !== 'user') {
                    ?>
                        <div class="checkbox">
                            <?php $formchecked = $setUp->getConfig('delete_enable'.$rolekey) ? ' checked' : ''; ?>
                            <div class="form-check form-switch">
                                <input class="form-check-input" role="switch" type="checkbox" name="delete_enable<?php echo $rolekey; ?>" id="delete_enable<?php echo $rolekey; ?>" <?php echo $formchecked; ?>>
                                <label class="form-check-label" for="delete_enable<?php echo $rolekey; ?>">
                                    <i class="bi bi-trash3"></i> <?php print $setUp->getString("delete_files"); ?></label>
                            </div>
                        </div>
                        <div class="checkbox">
                            <?php $formchecked = $setUp->getConfig('rename_enable'.$rolekey) ? ' checked' : ''; ?>
                            <div class="form-check form-switch">
                                <input class="form-check-input" role="switch" type="checkbox" name="rename_enable<?php echo $rolekey; ?>" id="rename_enable<?php echo $rolekey; ?>" <?php echo $formchecked; ?>>
                                <label class="form-check-label" for="rename_enable<?php echo $rolekey; ?>">
                                    <i class="bi bi-pencil-square"></i> <?php print $setUp->getString("rename_files"); ?></label>
                            </div>
                        </div>
                        <div class="checkbox">
                            <?php $formchecked = $setUp->getConfig('move_enable'.$rolekey) ? ' checked' : ''; ?>
                            <div class="form-check form-switch">
                                <input class="form-check-input" role="switch" type="checkbox" name="move_enable<?php echo $rolekey; ?>" id="move_enable<?php echo $rolekey; ?>" <?php echo $formchecked; ?>>
                                <label class="form-check-label" for="move_enable<?php echo $rolekey; ?>">
                                    <i class="bi bi-arrow-right"></i> <?php print $setUp->getString("move_files"); ?></label>
                            </div>
                        </div>
                        <div class="checkbox">
                            <?php $formchecked = $setUp->getConfig('copy_enable'.$rolekey) ? ' checked' : ''; ?>
                            <div class="form-check form-switch">
                                <input class="form-check-input" role="switch" type="checkbox" name="copy_enable<?php echo $rolekey; ?>" id="copy_enable<?php echo $rolekey; ?>" <?php echo $formchecked; ?>>
                                <label class="form-check-label" for="copy_enable<?php echo $rolekey; ?>">
                                    <i class="bi bi-files"></i> <?php print $setUp->getString("copy_files"); ?></label>
                            </div>
                        </div>
                    <?php
                } ?>
                    </div>

                    <div class="col-sm-6">
                        <h6><i class="bi bi-folder-fill"></i> <?php print $setUp->getString("folders"); ?></h6>
                <?php
                if ($key == 'user') {
                    ?>
                        <div class="checkbox">
                            <?php $formchecked = $setUp->getConfig('viewdirs_enable'.$rolekey) ? ' checked' : ''; ?>
                            <div class="form-check form-switch">
                                <input class="form-check-input" role="switch" type="checkbox" name="viewdirs_enable<?php echo $rolekey; ?>" id="viewdirs_enable<?php echo $rolekey; ?>" <?php echo $formchecked; ?>>
                                <label class="form-check-label" for="viewdirs_enable<?php echo $rolekey; ?>">
                                    <i class="bi bi-eye"></i> <?php print $setUp->getString("view_folders"); ?></label>
                            </div>
                        </div>

                    <?php
                } ?>
                        <div class="checkbox">
                            <?php $formchecked = $setUp->getConfig('newdir_enable'.$rolekey) ? ' checked' : ''; ?>
                            <div class="form-check form-switch">
                                <input class="form-check-input" role="switch" type="checkbox" name="newdir_enable<?php echo $rolekey; ?>" id="newdir_enable<?php echo $rolekey; ?>" <?php echo $formchecked; ?>>
                                <label class="form-check-label" for="newdir_enable<?php echo $rolekey; ?>">
                                    <i class="bi bi-plus-circle"></i> <?php print $setUp->getString("create_new_folders"); ?></label>
                            </div>
                        </div>

                <?php
                if ($key !== 'user') {
                    ?>
                        <div class="checkbox">
                            <?php $formchecked = $setUp->getConfig('delete_dir_enable'.$rolekey) ? ' checked' : ''; ?>
                            <div class="form-check form-switch">
                                <input class="form-check-input" role="switch" type="checkbox" name="delete_dir_enable<?php echo $rolekey; ?>" id="delete_dir_enable<?php echo $rolekey; ?>" <?php echo $formchecked; ?>>
                                <label class="form-check-label" for="delete_dir_enable<?php echo $rolekey; ?>">
                                    <i class="bi bi-trash3"></i> <?php print $setUp->getString("delete_folders"); ?></label>
                            </div>
                        </div>
                        <div class="checkbox">
                            <?php $formchecked = $setUp->getConfig('rename_dir_enable'.$rolekey) ? ' checked' : ''; ?>
                            <div class="form-check form-switch">
                                <input class="form-check-input" role="switch" type="checkbox" name="rename_dir_enable<?php echo $rolekey; ?>" id="rename_dir_enable<?php echo $rolekey; ?>" <?php echo $formchecked; ?>>
                                <label class="form-check-label" for="rename_dir_enable<?php echo $rolekey; ?>">
                                    <i class="bi bi-pencil-square"></i> <?php print $setUp->getString("rename_folders"); ?></label>
                            </div>
                        </div>
                    <?php
                } ?>
                    </div>
                </div>
                <hr>
                <?php
            }

            if (GateKeeper::isMasterAdmin()) {
                $superadminPerms = array(
                    'preferences' => array(
                        'icon' => '<i class="bi bi-sliders"></i>',
                    ),
                    'users' => array(
                        'icon' => '<i class="bi bi-people"></i>',
                    ),
                    'appearance' => array(
                        'icon' => '<i class="bi bi-brush"></i>',
                    ),
                    'translations' => array(
                        'icon' => '<i class="bi bi-translate"></i>',
                    ),
                    'statistics' => array(
                        'icon' => '<i class="bi bi-graph-up-arrow"></i>',
                    ),
                );
                ?>
                <h5><?php echo $setUp->getString("role_superadmin"); ?></h5>

                <div class="row">
                    <div class="col-sm-6">
                    <?php
                    foreach ($superadminPerms as $key => $perm) {
                        $formchecked = $setUp->getConfig('superadmin_can_'.$key) ? ' checked' : '';
                        ?>
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" role="switch" type="checkbox" name="superadmin_can_<?php echo $key; ?>" id="superadmin_can_<?php echo $key; ?>" <?php echo $formchecked; ?>>
                            <label class="form-check-label" for="superadmin_can_<?php echo $key; ?>">
                                <?php echo $perm['icon'].' '.$setUp->getString($key); ?></label>
                        </div>
                        <?php
                    } ?>
                    </div>
                </div>
            <?php } ?>
            </div> <!-- box-body -->
            </div>
        </div> <!-- box -->
    </div>
</div>

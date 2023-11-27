<?php
/**
 * MODAL USER PANEL
 */
?>          
<div class="modal fade" id="modaluser" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="bi bi-person"></i> <span class="modalusername"></span></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form role="form" method="post" autocomplete="off" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>?section=users&action=update" enctype="multipart/form-data" class="removegroup">
                    <div class="row">
                        <div class="col-md-6 form-group mb-3">
                            <label class="form-label"><?php echo $setUp->getString("username"); ?></label>
                            <div class="input-group">
                                <div class="input-group-text"><i class="bi bi-person"></i></div>
                                <input type="hidden" class="form-control getuser getuser-name" name="usernameold" id="r-usernameold" value="">
                                <input type="text" class="form-control deleteme getuser getuser-name" name="username" id="r-username" value="">
                            </div>
                        </div>
                        <?php
                        // $allroles = array(
                        //     'user' => $setUp->getString("role_user"),
                        // );
                        // require dirname(__FILE__).'/roles.php';

                        // if (is_array($getroles)) {
                        //     foreach ($getroles as $role) {
                        //         $allroles[$role] = $setUp->getString("role_".$role);
                        //     }
                        // }
                        // $allroles['admin'] = $setUp->getString("role_admin");
                        // $allroles['superadmin'] = $setUp->getString("role_superadmin");
                        ?>
                        <div class="col-md-6 form-group mb-3">
                            <label class="form-label">
                                <?php echo $setUp->getString("role"); ?>
                            </label>
                            <div class="input-group btn-group cooldrop">
                                <div class="input-group-text"><i class="bi bi-check"></i></div>
                                <select class="form-select getuser getuser-role" name="role" id="r-role">
                                    <?php
                                    foreach ($allroles as $key => $role) {
                                        echo '<option value="'.$key.'">'.$role.'</option>';
                                    } ?>
                                </select>
                            </div>
                        </div>
                    </div> <!-- row -->

                    <div class="row">
                        <div class="col-md-6 form-group mb-3">
                            <label class="form-label"><?php echo $setUp->getString("password"); ?></label>
                            <div class="input-group">
                                <div class="input-group-text"><i class="bi bi-lock"></i></div>
                                <input type="password" class="form-control" name="userpassnew" id="r-userpassnew" placeholder="<?php echo $setUp->getString("new_password"); ?>">
                            </div>
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label class="form-label"><?php echo $setUp->getString("email"); ?></label>
                            <input type="hidden" class="form-control getuser getuser-email" name="usermailold" id="r-usermailold" value="">
                            <div class="input-group">
                                <div class="input-group-text"><i class="bi bi-envelope"></i></div>
                                <input type="email" class="form-control getuser getuser-email" name="usermail" id="r-usermail" value="" placeholder="<?php echo $setUp->getString("email"); ?>">
                            </div>
                        </div>
                    </div> <!-- row -->
                    <div class="togglequota">
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="form-label"><?php echo $setUp->getString("user_folder"); ?></label>
                                <?php
                                if (empty($availableFolders)) {
                                    echo "<fieldset disabled>";
                                } ?>
                                    <select name="userfolders[]" id="r-userfolders" class="assignfolder selectpicker" multiple="multiple" data-width="100%" data-live-search="1" data-live-search-normalize="1" data-selected-text-format="count" data-syle="" data-style-base="form-select">
                                    <?php
                                    foreach ($admin->getFolders() as $folder) {
                                        echo '<option value="'.$folder.'">'.$folder.'</option>';
                                    } ?>
                                    </select>
                                <?php
                                if (empty($availableFolders)) {
                                    echo "</fieldset>";
                                } ?>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label"><?php echo $setUp->getString("make_directory"); ?></label>
                                <div class="input-group">
                                    <div class="input-group-text">
                                        <i class="bi bi-folder"></i>
                                    </div>
                                    <input type="text" class="form-control getfolder assignnew" name="userfolder" placeholder="<?php echo $setUp->getString("add_new"); ?>">
                                </div>
                            </div> <!-- col-md-6 -->
                        </div> <!-- row -->

                        <div class="row">
                            <div class="col-md-6 userquota form-group mb-3">
                                <label class="form-label"><?php echo $setUp->getString("available_space"); ?></label>
                                <div class="input-group btn-group cooldrop">
                                    <div class="input-group-text">
                                        <i class="bi bi-speedometer"></i>
                                    </div>

                                    <select class="form-select getuser-quota" name="quota" id="r-quota">
                                        <option value=""><?php echo $setUp->getString("unlimited"); ?></option>
                                        <?php
                                        foreach ($_QUOTA as $value) {
                                            $formatsize = $setUp->formatSize(($value*1024*1024));
                                            echo '<option value="'.$value.'">'.$formatsize.'</option>';
                                        } ?>
                                    </select>
                                </div> <!-- input-group -->
                            </div> <!-- col-md-6 userquota -->
                        </div> <!-- row -->
                    </div>
                    <div class="row">
                        <div class="col-sm-12 mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input getuser-disabled" type="checkbox" name="disabled" role="switch" id="usr_edit_disabled_check">
                                <label class="form-check-label" for="usr_edit_disabled_check"><?php echo $setUp->getString("disabled"); ?></label>
                            </div>
                        </div>
                    </div>
                   
                    <?php
                    /**
                     * Set additional custom fields
                     */
                    if (is_array($customfields)) { ?>
                        <div class="row">
                        <?php
                        foreach ($customfields as $customkey => $customfield) {
                            if (isset($customfield['type'])) {
                                $customkey_name = $customkey;
                                ?>
                            <div class="col-md-6 form-group mb-3">
                                <label class="form-label"><?php echo $customfield['name']; ?></label>
                                <?php
                                if ($customfield['type'] === 'textarea') { ?>
                                    <textarea name="<?php echo $customkey_name; ?>" class="form-control getuser getuser-<?php echo $customkey; ?>" rows="2"></textarea>
                                    <?php
                                }
                                if ($customfield['type'] === 'select' && is_array($customfield['options'])) {
                                    $multiselect = '';
                                    if (isset($customfield['multiple']) && $customfield['multiple'] == true) {
                                        $multiselect = ($customfield['multiple'] == true ? 'multiple="multiple"' : '');
                                        $customkey_name = $customkey.'[]';
                                    } ?>
                                    <select name="<?php echo $customkey_name; ?>" class="form-select getuser getuser-<?php echo $customkey; ?>" <?php echo $multiselect; ?>>
                                    <?php
                                    foreach ($customfield['options'] as $optionval => $optiontitle) {
                                        ?>
                                        <option value="<?php echo $optionval; ?>"><?php echo $optiontitle; ?></option>
                                        <?php
                                    } ?>
                                    </select>
                                    <?php
                                }
                                if ($customfield['type'] === 'text' || $customfield['type'] === 'email') { ?>
                                     <input type="<?php echo $customfield['type']; ?>" name="<?php echo $customkey_name; ?>" class="form-control getuser getuser-<?php echo $customkey; ?>">
                                    <?php
                                } ?>
                            </div>
                                <?php
                            }
                        } ?>
                        </div> <!-- row -->
                        <?php
                    } ?>
                    <div class="row">
                        <div class="col-md-12 form-group mb-3">
                            <div class="btn-group pull-right">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-arrow-repeat"></i> <?php echo $setUp->getString("update_profile"); ?>
                                </button>
                                <button type="submit" class="btn btn-danger remove"><i class="bi bi-trash"></i> <?php echo $setUp->getString("delete"); ?></small>
                                    <input type="hidden" name="delme" class="delme" value="">
                                </button>
                            </div><!-- btn-group -->
                        </div><!-- col-md-12 form-group -->
                    </div><!-- row -->
                </form>
            </div> <!-- modal-body -->

        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->
<script type="text/javascript">
$('#modaluser form').submit(function(e){
    if ($('#r-username').val().length < 1) {
        $('#r-username').focus();
        e.preventDefault();
        return false;
    }
});
</script>

<?php
/**
 * Get available folders for users
 */
$availableFolders = array_filter($admin->getFolders());
$utenti = $_USERS;
// get MasterAdmin ($king)
// and remove it from list ($utenti)
$king = array_shift($utenti);
$kingmail = isset($king['email']) ? $king['email'] : "";
/**
* ADD NEW USER
*/
?>
<div class="col-sm-6">
    <div class="d-grid gap-2">
    <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#newuserpanel">
        <i class="bi bi-person-plus"></i> <?php print $setUp->getString("add_user"); ?>
    </button>
    </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="newuserpanel">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <form role="form" method="post" autocomplete="off" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>?section=users&action=new" class="clear intero" enctype="multipart/form-data" id="newUsrForm">
            <div class="modal-header">
                <h4 class="modal-title">
                    <i class="bi bi-person-plus"></i> <?php print $setUp->getString("new_user"); ?>
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6 form-group mb-3">
                            <label class="form-label">
                                <?php echo $setUp->getString("username"); ?>
                            </label>
                            <div class="input-group">
                                <div class="input-group-text"><i class="bi bi-person"></i></div>
                                <input type="text" class="form-control addme" name="newusername" id="newusername" placeholder="*<?php print $setUp->getString("username"); ?>">
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
                            <label class="form-label"><?php echo $setUp->getString("role"); ?></label>
                            <div class="input-group btn-group cooldrop">
                                <div class="input-group-text"><i class="bi bi-check"></i></div>
                                <select name="newrole" class="form-select">
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
                            <label class="form-label">
                                <?php echo $setUp->getString("password"); ?>
                            </label>
                            <div class="input-group">
                                <div class="input-group-text"><i class="bi bi-lock"></i></div>
                                <input type="password" name="newuserpass" class="form-control addme" id="newuserpass" placeholder="*<?php echo $setUp->getString('password'); ?>">
                            </div>
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label class="form-label"><?php echo $setUp->getString("email"); ?></label>
                            <div class="input-group">
                                <div class="input-group-text"><i class="bi bi-envelope"></i></div>
                                <input type="email" name="newusermail" class="form-control newusermail addme" placeholder="<?php echo $setUp->getString('email'); ?>">
                            </div>
                        </div>
                    </div> <!-- row -->
                    <div class="togglequota">
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="form-label"><?php print $setUp->getString("user_folder"); ?></label>
                                <?php
                                if (empty($availableFolders)) {
                                    print "<fieldset disabled>";
                                } ?>
                                <select name="newuserfolders[]" id="r-reguserfolders" class="assignfolder selectpicker" multiple="multiple" data-width="100%" data-live-search="1" data-live-search-normalize="1" data-selected-text-format="count">
                                    <?php
                                    foreach ($admin->getFolders() as $folder) {
                                        echo '<option value="'.$folder.'">'.$folder.'</option>';
                                    } ?>
                                    </select>
                                <?php
                                if (empty($availableFolders)) {
                                    print "</fieldset>";
                                } ?>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="form-label"><?php print $setUp->getString("make_directory"); ?></label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="bi bi-folder"></i></div>
                                    <input type="text" name="newuserfolder" class="form-control addme usrfolder getfolder assignnew" placeholder="<?php echo $setUp->getString('add_new'); ?>">
                                </div>
                            </div>
                        </div> <!-- row -->
                        <div class="row">
                            <div class="col-md-6 form-group userquota mb-3">
                                <label class="form-label"><?php print $setUp->getString("available_space"); ?></label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="bi bi-speedometer"></i></div>
                                    <select class="form-select" name="quota">
                                        <option value=""><?php print $setUp->getString("unlimited"); ?></option>
                                        <?php
                                        foreach ($_QUOTA as $value) {
                                            $formatsize = $setUp->formatSize(($value*1024*1024));
                                            echo '<option value="'.$value.'">'.$formatsize.'</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </div> <!-- row -->
                    </div>

                    <div class="row">
                        <div class="col-xs-6 form-group mb-3">
                        <?php
                        if (strlen($setUp->getConfig('email_from')) > 4) { ?>
                            <div class="form-check usernotif">
                                <input type="checkbox" name="usernotif" id="usernotif" class="form-check-input">
                                <label class="form-check-label" for="usernotif">
                                    <i class="bi bi-envelope"></i> <?php echo $setUp->getString("notify_user"); ?>
                                </label>
                            </div>
                            <?php
                        } ?>
                        </div>
                    </div> <!-- row -->

                    <div class="row">
                        <div class="col-sm-12 mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="disabled" role="switch" id="usr_disabled_check">
                                <label class="form-check-label" for="usr_disabled_check"><?php echo $setUp->getString("disabled"); ?></label>
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
                                <textarea name="<?php echo $customkey_name; ?>" class="form-control" rows="2"></textarea>
                                    <?php
                                }
                                if ($customfield['type'] === 'select' && is_array($customfield['options'])) {
                                    $multiselect = '';
                                    if (isset($customfield['multiple']) && $customfield['multiple'] == true) {
                                        $multiselect = ($customfield['multiple'] == true ? 'multiple="multiple"' : '');
                                        $customkey_name = $customkey.'[]';
                                    } ?>
                                    <select name="<?php echo $customkey_name; ?>" class="form-select" <?php echo $multiselect; ?>>
                                    <?php
                                    foreach ($customfield['options'] as $optionval => $optiontitle) { ?>
                                    <option value="<?php echo $optionval; ?>"><?php echo $optiontitle; ?></option>
                                        <?php
                                    } ?>
                                </select>
                                    <?php
                                }
                                if ($customfield['type'] === 'text' || $customfield['type'] === 'email') { ?>
                                <input type="<?php echo $customfield['type']; ?>" name="<?php echo $customkey_name; ?>" class="form-control">
                                    <?php
                                } ?>
                            </div>
                                <?php
                            }
                        } ?>
                        </div> <!-- row -->
                        <?php
                    } ?>
                </div>
            </div><!-- /.modal-body -->
            <div class="modal-footer">
                <button class="btn btn-primary btn-lg"><i class="bi bi-plus-lg"></i> <?php print $setUp->getString("new_user"); ?></button>
            </div>
        </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
$('#newUsrForm').submit(function(e){
    if ($('#newusername').val().length < 1) {
        $('#newusername').focus();
        e.preventDefault();
        return false;
    }
    if ($('#newuserpass').val().length < 1) {
        $('#newuserpass').focus();
        e.preventDefault();
        return false;
    }
});
</script>

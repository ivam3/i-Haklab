<?php
/**
 * DISPLAY MASTER-ADMIN
 */
?>
<div class="col-sm-6">
    <div class="d-grid gap-2">
        <button class="btn btn-outline-primary btn-lg" data-bs-toggle="modal" data-bs-target="#masteradminpanel"><i class="bi bi-gem"></i> Master Admin</button>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="masteradminpanel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form role="form" method="post" autocomplete="off" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>?section=users&action=updatemaster" enctype="multipart/form-data">
                <div class="modal-header">          
                    <h4 class="modal-title"><i class="bi bi-gem"></i> Master Admin</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 form-group mb-3">
                            <label class="form-label"><?php echo $setUp->getString("username"); ?></label>
                            <div class="input-group">
                                <div class="input-group-text"><i class="bi bi-person"></i></div>
                                <input type="hidden" class="form-control" name="masterusernameold" value="<?php echo $king['name']; ?>">
                                <input type="text" class="form-control" name="masterusername" value="<?php echo $king['name']; ?>">
                            </div>
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label class="form-label"><?php echo $setUp->getString("role"); ?></label>
                            <div class="input-group">
                                <div class="input-group-text"><i class="bi bi-check"></i></div>
                                <input type="text" class="form-control" readonly value="<?php echo $setUp->getString('role_'.$king['role']); ?>">
                            </div>
                        </div>   
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group mb-3">
                            <label class="form-label"><?php echo $setUp->getString("password"); ?></label>
                            <div class="input-group">
                                <div class="input-group-text"><i class="bi bi-lock"></i></div>
                                <input type="password" class="form-control" name="masteruserpassnew" placeholder="<?php print $setUp->getString("new_password"); ?>">
                            </div>
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label class="form-label"><?php echo $setUp->getString("email"); ?></label>
                            <input type="hidden" class="form-control" name="masterusermailold" value="<?php echo $kingmail; ?>">
                            <div class="input-group">
                                <div class="input-group-text"><i class="bi bi-envelope"></i></div>
                                <input type="email" class="form-control" name="masterusermail" value="<?php echo $kingmail; ?>" placeholder="<?php print $setUp->getString("email"); ?>">
                            </div>
                        </div>
                    </div> <!-- row -->
                </div><!-- /.modal-body -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-arrow-repeat"></i> 
                        <?php echo $setUp->getString("update_profile"); ?>
                    </button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php
/**
 * ACTIVITIES
 **/
?>
<div id="view-activities" class="anchor"></div>
<div class="row mb-3">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-center align-items-center">
                <h4 class="m-0"><i class="bi bi-bar-chart-line"></i> <?php echo $setUp->getString("activity_register"); ?></h4>
                <button type="button" class="btn ms-auto" data-bs-toggle="collapse" data-bs-target="#card-activities" aria-expanded="false">
                    <i class="bi bi-dash-lg"></i>
                </button>
            </div>
            <div class="collapse show" id="card-activities">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <?php $formchecked = $setUp->getConfig('log_file') ? ' checked' : ''; ?>
                        <div class="form-check form-switch">
                            <input class="form-check-input" role="switch" type="checkbox" name="log_file" id="log_file" <?php echo $formchecked; ?>>
                            <label class="form-check-label" for="log_file"><?php print $setUp->getString("statistics"); ?></label>
                        </div>
                    </div> <!-- col 4 -->

                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-sm-6 mb-2">
                                <label class="form-label"><i class="bi bi-envelope"></i> <?php echo $setUp->getString("email_notifications"); ?></label>
                                <input type="email" placeholder="admin1@mail.ext, admin2@ma..." class="form-control" name="upload_email" value="<?php echo $setUp->getConfig('upload_email'); ?>" multiple>
                            </div>

                            <div class="col-sm-6">
                                <label class="form-label"><?php echo $setUp->getString("activities"); ?></label>
                                <div class="form-group">
                                    <?php $formchecked = $setUp->getConfig('notify_login') ? ' checked' : ''; ?>
                                    <div class="d-inline-block me-1 mb-2">
                                        <input class="btn-check" type="checkbox" name="notify_login" id="notify_login" autocomplete="off"<?php echo $formchecked; ?>>
                                        <label class="btn btn-outline-primary tooltipper" for="notify_login" data-bs-placement="top" data-bs-toggle="tooltip" title="<?php echo $setUp->getString("notify_login"); ?>"><i class="bi bi-box-arrow-in-right"></i></label>
                                    </div>
                                    <?php $formchecked = $setUp->getConfig('notify_upload') ? ' checked' : ''; ?>
                                    <div class="d-inline-block me-1 mb-2">
                                        <input class="btn-check" type="checkbox" name="notify_upload" id="notify_upload" autocomplete="off"<?php echo $formchecked; ?>>
                                        <label class="btn btn-outline-primary tooltipper" for="notify_upload" data-bs-placement="top" data-bs-toggle="tooltip" title="<?php echo $setUp->getString("notify_upload"); ?>"><i class="bi bi-cloud-arrow-up"></i></label>
                                    </div>
                                    <?php $formchecked = $setUp->getConfig('notify_download') ? ' checked' : ''; ?>
                                    <div class="d-inline-block me-1 mb-2">
                                        <input class="btn-check" type="checkbox" name="notify_download" id="notify_download" autocomplete="off"<?php echo $formchecked; ?>>
                                        <label class="btn btn-outline-primary tooltipper" for="notify_download" data-bs-placement="top" data-bs-toggle="tooltip" title="<?php echo $setUp->getString("notify_download"); ?>"><i class="bi bi-download"></i></label>
                                    </div>
                                    <?php $formchecked = $setUp->getConfig('notify_newfolder') ? ' checked' : ''; ?>
                                    <div class="d-inline-block me-1 mb-2">
                                        <input class="btn-check" type="checkbox" name="notify_newfolder" id="notify_newfolder" autocomplete="off"<?php echo $formchecked; ?>>
                                        <label class="btn btn-outline-primary tooltipper" for="notify_newfolder" data-bs-placement="top" data-bs-toggle="tooltip" title="<?php echo $setUp->getString("notify_newfolder"); ?>"><i class="bi bi-folder"></i></label>
                                    </div>
                                    <?php $formchecked = $setUp->getConfig('notify_registration') ? ' checked' : ''; ?>
                                    <div class="d-inline-block me-1 mb-2">
                                        <input class="btn-check" type="checkbox" name="notify_registration" id="notify_registration" autocomplete="off"<?php echo $formchecked; ?>>
                                        <label class="btn btn-outline-primary tooltipper" for="notify_registration" data-bs-placement="top" data-bs-toggle="tooltip" title="<?php echo $setUp->getString("notify_registration"); ?>"><i class="bi bi-person-plus"></i></label>
                                    </div>
                                </div>
                            </div> <!-- col sm 6 -->
                        </div> <!-- row -->
                        <span class="form-text">
                            <?php echo $setUp->getString("set_email_to_receive_notifications"); ?>
                        </span>
                    </div><!-- col md 8 -->
                </div><!-- row -->
            </div><!-- box-body -->
            </div>
        </div><!-- box -->
    </div><!-- col 12 -->
</div><!-- row -->

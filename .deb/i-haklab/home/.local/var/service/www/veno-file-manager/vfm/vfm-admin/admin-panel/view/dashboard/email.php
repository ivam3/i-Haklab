<?php
/**
* EMAIL SETTINGS
**/
?>
<div class="row mb-3">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-center align-items-center">
                <h4 class="m-0" id="view-email"><i class="bi bi-envelope"></i> <?php print $setUp->getString("email"); ?></h4>
                <button type="button" class="btn ms-auto" data-bs-toggle="collapse" data-bs-target="#card-email" aria-expanded="false">
                    <i class="fa bi-dash-lg"></i>
                </button>
            </div>
            <div class="collapse show" id="card-email">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="form-label"><i class="fa bi-envelope"></i> <?php print $setUp->getString("email_from"); ?></label>
                            <input type="email" class="form-control input-lg" name="email_from" value="<?php print $setUp->getConfig('email_from'); ?>" placeholder="noreply@example.com">
                        </div>
                    </div>
                    <?php
                    $email_logo = $setUp->getConfig('email_logo', false) ? '_content/uploads/'.$setUp->getConfig('email_logo') : 'admin-panel/images/placeholder.png';
                    $deleterclass = $setUp->getConfig('email_logo', false) ? '' : ' d-none';
                    ?>
                    <div class="col-sm-6">
                        <label class="form-label"><i class="bi bi-patch-check"></i> <?php print $setUp->getString("logo"); ?></label>
                        <div class="placeheader form-group text-center mb-2 bg-checkerboard">
                            <img class="email_logo-preview" src="<?php echo $email_logo; ?>?t=<?php echo time(); ?>">
                            <button class="btn btn-danger btn-sm rounded-0 deletelogo<?php echo $deleterclass; ?>" data-setting="email_logo">&times;</button>
                        </div>
                        <input type="hidden" name="remove_email_logo" value="0">
                        <div class="form-group">
                            <input type="file" name="email_logo" value="select" id="email_logo" class="logo-selector d-none" data-target=".email_logo-preview">
                            <div class="d-grid gap-2">
                                <button class="btn btn-primary rounded-0 fake-uploader" type="button" data-up-target="#email_logo"><i class="bi bi-upload"></i></button>
                            </div>
                        </div>


                    </div>
                </div>

                <?php $formchecked = $setUp->getConfig('smtp_enable') ? ' checked' : ''; ?>
                <div class="form-check form-switch toggle mb-2">
                    <input class="form-check-input" role="switch" type="checkbox" name="smtp_enable" id="smtp_enable"<?php echo $formchecked; ?>>
                    <label class="form-check-label" for="smtp_enable">SMTP mail</label>
                </div>

                <div class="toggled">
                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <div class="form-group">
                                <label class="form-label"><?php print $setUp->getString("smtp_server"); ?></label>
                                <input type="text" class="form-control" name="smtp_server" value="<?php print $setUp->getConfig('smtp_server'); ?>" placeholder="mail.example.com">
                            </div>
                        </div>

                        <div class="col-sm-6 mb-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label"><?php print $setUp->getString("port"); ?></label>
                                    <input type="number" class="form-control" name="port" value="<?php print $setUp->getConfig('port'); ?>" placeholder="25">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><?php print $setUp->getString("secure_connection"); ?></label>
                                    <select class="form-select" name="secure_conn">
                                    <?php $formselected = $setUp->getConfig('secure_conn') == 'none' ? ' selected' : ''; ?>
                                    <option value="none"<?php echo $formselected; ?>>None</option>
                                    <?php $formselected = $setUp->getConfig('secure_conn') == 'ssl' ? ' selected' : ''; ?>
                                    <option value="ssl"<?php echo $formselected; ?>>SSL</option>
                                    <?php $formselected = $setUp->getConfig('secure_conn') == 'tls' ? ' selected' : ''; ?>
                                    <option value="tls"<?php echo $formselected; ?>>TLS</option>
                                    </select>
                                </div> <!-- col 6 -->
                            </div> <!-- row -->
                        </div> <!-- col 6 -->
                    </div> <!-- row -->
        
                    <div class="row">
                        <div class="col-sm-12">

                            <?php $formchecked = $setUp->getConfig('smtp_auth') ? ' checked' : ''; ?>
                            <div class="form-check form-switch toggle mb-2">
                                <input class="form-check-input" role="switch" type="checkbox" name="smtp_auth" id="smtp_auth" <?php echo $formchecked; ?>>
                                <label class="form-check-label" for="smtp_auth"><?php echo $setUp->getString("smtp_auth"); ?></label>
                            </div>
                    
                            <div class="row toggled">
                                <div class="col-sm-6 mb-3">
                                    <div class="form-group">
                                        <label class="form-label"><?php print $setUp->getString("username"); ?></label>
                                        <input type="text" class="form-control" name="email_login" value="<?php print $setUp->getConfig('email_login'); ?>" placeholder="login@example.com">
                                    </div>
                                </div>

                                <div class="col-sm-6 mb-3">
                                    <div class="form-group">
                                        <label class="form-label"><?php print $setUp->getString("password"); ?></label>
                                        <input type="password" class="form-control" name="email_pass" value="" placeholder="<?php print $setUp->getString("password"); ?>">
                                    </div>
                                </div> <!-- col 6 -->
                            </div> <!-- row toggled -->

                            <div class="form-group mb-3">
                                <?php $formchecked = $setUp->getConfig('debug_smtp') ? ' checked' : ''; ?>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" role="switch" type="checkbox" name="debug_smtp" id="debug_smtp" <?php echo $formchecked; ?>>
                                    <label class="form-check-label" for="debug_smtp">DEBUG SMTP <a title="display SMTP connection responses inside e-mail forms" class="tooltipper" data-bs-placement="right" data-bs-toggle="tooltip" href="javascript:void(0)"><i class="bi bi-question-circle"></i></a></label>
                                </div>
                            </div>
                        </div> <!-- col 12 -->
                    </div> <!-- row -->
                </div> <!-- toggled -->
            </div> <!-- box-body -->
            </div>
        </div> <!-- box -->
    </div>  <!-- col 12 -->
</div> <!-- row -->
<?php
/**
 * VFM - veno file manager: admin-panel/view/dashboard/security.php
 * administration registration block
 *
 * @package VenoFileManager
 */
?>
<div class="row mb-3">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-center align-items-center">
                <h4 class="m-0" id="view-security"><i class="bi bi-shield-check"></i> <?php echo $setUp->getString("security"); ?></h4>
                <button type="button" class="btn ms-auto" data-bs-toggle="collapse" data-bs-target="#card-security" aria-expanded="false">
                    <i class="bi bi-dash-lg"></i>
                </button>
            </div>
            <div class="collapse show" id="card-security">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <h4><?php echo $setUp->getString("CAPTCHA"); ?></h4>
                        </div>
                        <div class="col-sm-6">
                            <?php $formchecked = $setUp->getConfig('show_captcha') ? ' checked' : ''; ?>
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" role="switch" type="checkbox" name="show_captcha" id="show_captcha" <?php echo $formchecked; ?>>
                                <label class="form-check-label" for="show_captcha"><i class="bi bi-box-arrow-in-right"></i> <?php print $setUp->getString("log_in"); ?></label>
                            </div>
                            <?php $formchecked = $setUp->getConfig('show_captcha_reset') ? ' checked' : ''; ?>
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" role="switch" type="checkbox" name="show_captcha_reset" id="show_captcha_reset" <?php echo $formchecked; ?>>
                                <label class="form-check-label" for="show_captcha_reset"><i class="bi bi-key"></i> <?php print $setUp->getString("reset_password"); ?></label>
                            </div>
                            <?php $formchecked = $setUp->getConfig('show_captcha_download') ? ' checked' : ''; ?>
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" role="switch" type="checkbox" name="show_captcha_download" id="show_captcha_download" <?php echo $formchecked; ?>>
                                <label class="form-check-label" for="show_captcha_download"><i class="bi bi-send"></i> <?php print $setUp->getString("share_files"); ?></label>
                            </div>
                            <?php $formchecked = $setUp->getConfig('show_captcha_register') ? ' checked' : ''; ?>
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" role="switch" type="checkbox" name="show_captcha_register" id="show_captcha_register" <?php echo $formchecked; ?>>
                                <label class="form-check-label" for="show_captcha_register"><i class="bi bi-person-plus"></i> <?php print $setUp->getString("registration"); ?></label>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <?php $formchecked = $setUp->getConfig('recaptcha') ? ' checked' : ''; ?>
                            <div class="form-check form-switch toggle mb-2">
                                <input class="form-check-input" role="switch" type="checkbox" name="recaptcha" id="recaptcha" <?php echo $formchecked; ?>>
                                <label class="form-check-label" for="recaptcha"><i class="bi bi-google"></i> ReCAPTCHA 
                                    <a class="tooltipper" title="sign up for an API key" data-bs-toggle="tooltip" data-bs-placement="right" target="_blank" href="https://www.google.com/recaptcha/admin">
                                        <i class="bi bi-info-circle"></i>
                                    </a></label>
                            </div>

                            <div class="row toggled">
                                <div class="col-md-6 mb-2">
                                    <label class="form-label"><?php echo $setUp->getString("site_key"); ?></label>
                                    <input type="text" class="form-control" name="recaptcha_site" value="<?php echo $setUp->getConfig('recaptcha_site'); ?>">
                                </div>

                                <div class="col-md-6 mb-2">
                                    <label class="form-label"><?php echo $setUp->getString("secret_key"); ?></label>
                                    <input type="text" class="form-control" name="recaptcha_secret" value="<?php echo $setUp->getConfig('recaptcha_secret'); ?>">
                                </div>

                                <div class="col-md-12 mb-2">
                                    <?php $formchecked = $setUp->getConfig('recaptcha_invisible') ? ' checked' : ''; ?>
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" role="switch" type="checkbox" name="recaptcha_invisible" id="recaptcha_invisible" <?php echo $formchecked; ?>>
                                        <label class="form-check-label" for="recaptcha_invisible"><i class="bi bi-recycle"></i> <?php print $setUp->getString("invisible_recaptcha"); ?></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <h4><?php echo $setUp->getString("ip_block"); ?></h4>
                        </div>
                        <div class="col-12 text-end">
                            <?php echo $setUp->getString("your_ip"); ?>: <span class="badge rounded-pill bg-info"><?php echo $_SERVER['REMOTE_ADDR']; ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="toggle-wrap mb-3">
                                <?php $formchecked = $setUp->getConfig('ip_list') == "reject" ? ' checked' : ''; ?>
                                <div class="form-check">
                                    <input class="form-check-input togglext" value="reject" type="radio" name="ip_list" id="ip_list_reject" <?php echo $formchecked; ?>>
                                    <label class="form-check-label" for="ip_list_reject"><?php print $setUp->getString("blacklist"); ?></label>
                                </div>
                                <div class="form-group tagin-danger toggle-collapse">
                                    <?php
                                    $ip_blacklist = $setUp->getConfig('ip_blacklist');
                                    $rejectlist = $ip_blacklist ? implode(",", $ip_blacklist) : false; ?>
                                    <input type="text" class="form-control tagin" name="ip_blacklist" data-tag="danger" value="<?php echo $rejectlist; ?>" data-tagin-placeholder="xxx.xxx.x.." placeholder="xxx.xxx.x..">
                                </div>
                            </div>
                            <div class="toggle-wrap mb-3">
                                <?php $formchecked = $setUp->getConfig('ip_list') == "allow" ? ' checked' : ''; ?>
                                <div class="form-check">
                                    <input class="form-check-input togglext" value="allow" type="radio" name="ip_list" id="ip_list_allow" <?php echo $formchecked; ?>>
                                    <label class="form-check-label" for="ip_list_allow"><?php print $setUp->getString("whitelist"); ?></label>
                                </div>
                                <div class="form-group tagin-success toggle-collapse">
                                    <?php
                                    $ip_whitelist = $setUp->getConfig('ip_whitelist');
                                    $allowlist = $ip_whitelist ? implode(",", $ip_whitelist) : false; ?>
                                    <input type="text" class="form-control tagin" name="ip_whitelist" data-tag="success" value="<?php echo $allowlist; ?>" data-tagin-placeholder="xxx.xxx.x.." placeholder="xxx.xxx.x..">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label class="form-label"><?php echo $setUp->getString("url_redirect"); ?></label>
                                <input type="url" class="form-control" name="ip_redirect" placeholder="http://google.com" value="<?php echo $setUp->getConfig('ip_redirect'); ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
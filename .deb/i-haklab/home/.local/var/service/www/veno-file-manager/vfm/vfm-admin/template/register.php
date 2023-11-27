<?php
/**
 * VFM - veno file manager: include/register.php
 * front-end registration panel
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
* Get additional custom fields
*/
if (!$gateKeeper->isUserLoggedIn()) {
    $customfields = false;
    if (file_exists('vfm-admin/_content/users/customfields.php')) {
        include 'vfm-admin/_content/users/customfields.php';
    }
    /**
    * Registration Mask
    */
    if ($setUp->getConfig("registration_enable") == true) { ?>
        <section class="col-12 my-5">
            <div class="login">
                <div id="regresponse"></div>
                <div class="card mb-3 shadow">
                    <div class="card-header">
                        <h5 class="m-0 text-center"><?php print $setUp->getString('registration'); ?></h5>
                    </div>
                    <div class="card-body">
                        <form class="needs-validation" id="regform" action="<?php print $location->makeLink(false, null, ""); ?>" novalidate>
                            <input type="hidden" id="trans_fill_all" value="<?php echo $setUp->getString("fill_all_fields"); ?>">
                            <input type="hidden" id="trans_pwd_match" value="<?php echo $setUp->getString("passwords_dont_match"); ?>">
                            <input type="hidden" id="trans_accept_terms" value="<?php echo $setUp->getString("accept_terms_and_conditions"); ?>">
                            <div id="login_bar" class="form-group">
                                <div class="form-group mb-3">
                                    <div class="has-feedback">
                                        <label class="form-label" for="user_name">* 
                                            <?php echo $setUp->getString("username"); ?>
                                        </label>  
                                        <div class="input-group">
                                            <span class="input-group-text">
                                            <i class="bi bi-person"></i>
                                            </span>
                                            <input type="text" name="user_name" value="" id="user_name" class="form-control" />
                                        </div>
                                        <div class="glyphicon glyphicon-minus form-control-feedback"></div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label" for="user_pass">* 
                                        <?php echo $setUp->getString("password"); ?>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                        <input type="password" name="user_pass" id="user_pass" class="form-control" data-bs-toggle="popover" title="<?php echo $setUp->getString("password_strength"); ?>" data-bs-content="<?php echo $setUp->getString("minimum_length").': '.$setUp->getConfig("password_length", 4); ?>" data-length="<?php echo $setUp->getConfig("password_length", 4); ?>"/>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label" for="user_pass">* 
                                        <?php echo $setUp->getString("password")." (".$setUp->getString("confirm").")"; ?>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                        <input type="password" name="user_pass_confirm" id="user_pass_check" class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label" for="user_email">* 
                                        <?php echo $setUp->getString("email"); ?>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                        <input type="email" name="user_email" class="form-control" />
                                    </div>
                                </div>
                                <?php
                                /**
                                 * Additional user custom fields
                                 */
                                if (is_array($customfields)) { ?>
                                    <?php
                                    foreach ($customfields as $customkey => $customfield) { ?>
                                        <div class="form-group mb-3">
                                            <label class="form-label"><?php echo $customfield['name']; ?></label>
                                        <?php
                                        if ($customfield['type'] === 'textarea') { ?>
                                            <textarea name="<?php echo $customkey; ?>" class="form-control" rows="2"></textarea>
                                            <?php
                                        }
                                        if ($customfield['type'] === 'select' && is_array($customfield['options'])) { ?>
                                            <select name="<?php echo $customkey; ?>" class="form-select coolselect">
                                            <?php
                                            foreach ($customfield['options'] as $optionval => $optiontitle) { ?>
                                                <option value="<?php echo $optionval; ?>"><?php echo $optiontitle; ?></option>
                                                <?php
                                            } ?>
                                            </select>
                                            <?php
                                        }
                                        if ($customfield['type'] === 'text' || $customfield['type'] === 'email') { ?>
                                             <input type="<?php echo $customfield['type']; ?>" name="<?php echo $customkey; ?>" class="form-control">
                                            <?php
                                        } ?>
                                        </div>
                                        <?php
                                    }
                                } ?>

                                <?php
                                $disclaimerfile = 'vfm-admin/_content/registration-disclaimer.html';
                                if (file_exists($disclaimerfile)) {
                                    $disclaimer = file_get_contents($disclaimerfile);
                                    echo $disclaimer; ?>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="agree" name="agree" required>
                                        <label class="form-check-label" for="agree">
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#disclaimer">
                                                <u><?php echo $setUp->getString("terms_and_conditions"); ?></u>
                                            </a>
                                        </label>
                                    </div>
                                    <?php
                                } ?>
                                <div class="form-group mb-3">
                                <?php
                                /* ************************ CAPTCHA ************************* */
                                if ($setUp->getConfig("show_captcha_register") == true) {
                                    $capath = "vfm-admin/";
                                    include "vfm-admin/include/captcha.php";
                                }   ?>
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-primary btn-block" />
                                            <i class="bi bi-check-lg"></i> <?php echo $setUp->getString("register"); ?>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="mailpreload">
                        <div class="position-absolute w-100 h-100 start-0 top-0 d-flex align-items-center justify-content-center">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
                <a class="btn btn-link" href="?dir="><i class="bi bi-box-arrow-in-right"></i> <?php echo $setUp->getString("log_in"); ?></a>
            </div>
        </section>
        <?php
        if ($setUp->getConfig('debug_mode')) {
            ?>
        <script type="text/javascript" src="vfm-admin/_dev/js/registration.js"></script>
            <?php
        } else { ?>
        <script type="text/javascript" src="vfm-admin/js/registration.min.js"></script>
            <?php
        }
    }
}

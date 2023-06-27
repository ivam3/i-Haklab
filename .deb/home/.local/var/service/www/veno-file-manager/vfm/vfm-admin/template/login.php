<?php
/**
 * VFM - veno file manager: include/login.php
 * front-end login card
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
* Login Area
*/
$disclaimerfile = 'vfm-admin/_content/login-disclaimer.html';

if (!$gateKeeper->isAccessAllowed()) { ?>
    <section class="col-12 my-5">
        <div class="login">
            <div class="card mb-3 shadow">
                <div class="card-header">
                    <h5 class="m-0 text-center"><?php echo $setUp->getString("log_in"); ?></h5>
                </div>
                <div class="card-body">
                    <form enctype="multipart/form-data" method="post" role="form" action="<?php echo $location->makeLink(false, null, ""); ?>" class="loginform">
                        <div id="login_bar" class="form-group">
                            <div class="form-group my-3">
                                <label class="visually-hidden" for="user_name">
                                    <?php echo $setUp->getString("username"); ?>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" name="user_name" value="" id="user_name" class="form-control" placeholder="<?php echo $setUp->getString("username"); ?>" />
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label class="visually-hidden" for="user_pass">
                                    <?php echo $setUp->getString("password"); ?>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                    <input type="password" name="user_pass" id="user_pass" class="form-control" placeholder="<?php echo $setUp->getString("password"); ?>" />
                                </div>
                            </div>
                            <?php
                            if (file_exists($disclaimerfile)) {
                                $disclaimer = file_get_contents($disclaimerfile);
                                echo $disclaimer; ?>
                                <input type="hidden" id="trans_accept_terms" value="<?php echo $setUp->getString("accept_terms_and_conditions"); ?>">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="agree" name="agree" required> <?php echo $setUp->getString("accept"); ?> 
                                    <label for="agree">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#login-disclaimer">
                                            <u><?php echo $setUp->getString("terms_and_conditions"); ?></u>
                                        </a>
                                    </label>
                                </div>
                                <?php
                            } ?>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="vfm_remember" name="vfm_remember" value="yes">
                                <label for="vfm_remember">
                                    <?php echo $setUp->getString("remember_me"); ?>
                                </label>
                            </div>
                            <?php
                            /* ************************ CAPTCHA ************************* */
                            if ($setUp->getConfig("show_captcha") == true) {
                                $capath = "vfm-admin/";
                                include "vfm-admin/include/captcha.php";
                            }   ?>
                            <div class="d-grid gap-2 mb-3">
                            <button type="submit" class="btn btn-primary" />
                                <i class="bi bi-box-arrow-in-right"></i> 
                                <?php echo $setUp->getString("log_in"); ?>
                            </button>
                            </div>
                        </div>
                    </form>
                    <p class="lostpwd"><a href="?rp=req"><?php echo $setUp->getString("lost_password"); ?></a></p>
                </div>
            </div>

    <?php
    if ($setUp->getConfig("registration_enable") == true) { ?>
            <div class="d-grid gap-2">
                <a class="btn btn-outline-primary" href="?reg=1">
                    <i class="bi bi-person-plus"></i> <?php echo $setUp->getString("registration"); ?>
                </a>
            </div>
        <?php
    } ?>

        </div>
    </section>
    <?php
}

if ($gateKeeper->isAccessAllowed()
    && $gateKeeper->showLoginBox()
) { ?>
<section class="vfmblock">
    <form enctype="multipart/form-data" method="post" action="<?php echo $location->makeLink(false, null, ""); ?>" class="row row-cols-md-auto mt-3 align-items-center loginform" role="form">
        <div class="col-12 mb-3">
            <label class="visually-hidden" for="user_name">
                <?php echo $setUp->getString("username"); ?>:
            </label>
            <input type="text" name="user_name" value="" id="user_name" class="form-control"  placeholder="<?php echo $setUp->getString("username"); ?>" />
        </div>
        <div class="col-12 mb-3">
            <label class="visually-hidden" for="user_pass">
                <?php echo $setUp->getString("password"); ?>: 
            </label>
            <input type="password" name="user_pass" id="user_pass" class="form-control"  placeholder="<?php echo $setUp->getString("password"); ?>" />
        </div>
        <?php
        /* ************************ CAPTCHA ************************* */
        if ($setUp->getConfig("show_captcha") == true) { ?>
            <div class="col-12 mb-3">
            <?php
            $capath = "vfm-admin/";
            include "vfm-admin/include/captcha.php";
            ?>
            </div>
            <?php
        }   ?>
        <div class="col-12 mb-3">
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-box-arrow-in-right"></i>  <?php echo $setUp->getString("log_in"); ?>
                </button>
            </div>
        </div>
        <?php
        if (file_exists($disclaimerfile)) { ?>
        <div class="col-12 mb-3">
            <?php
            $disclaimer = file_get_contents($disclaimerfile);
            echo $disclaimer; ?>
            <input type="hidden" id="trans_accept_terms" value="<?php echo $setUp->getString("accept_terms_and_conditions"); ?>">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="agree" name="agree" required> <?php echo $setUp->getString("accept"); ?>
                <label>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#login-disclaimer">
                        <u><?php echo $setUp->getString("terms_and_conditions"); ?></u>
                    </a>
                </label>
            </div>
        </div>
            <?php
        }
        if ($setUp->getConfig("registration_enable") == true) { ?>
        <div class="col-12 mb-3">
            <div class="d-grid gap-2">
                <a class="btn btn-outline-primary" href="?reg=1">
                    <i class="bi bi-person-plus"></i> <?php echo $setUp->getString("registration"); ?>
                </a>
            </div>
        </div>
            <?php
        }   ?>
    </form>
    <a class="small lostpwd" href="?rp=req"><?php echo $setUp->getString("lost_password"); ?></a>
</section>
    <?php
}

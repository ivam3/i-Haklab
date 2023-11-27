<?php
/**
 * VFM - veno file manager: include/reset.php
 * password reset form
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

?>
<section class="col-12 my-5">
    <div class="login">
        <div class="card mb-3 shadow">
            <div class="card-header">
                <h5 class="m-0 text-center"><i class="bi bi-unlock"></i> <?php echo $setUp->getString("reset_password"); ?></h5>
            </div>

            <div class="card-body">

<?php
$getusr = filter_input(INPUT_GET, "usr", FILTER_SANITIZE_STRING);
/**
 * Reset password
 */
if ($getusr && $resetter->checkTok($getrp, $getusr) == true) : ?>

        <form role="form" method="post" id="rpForm" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">

            <div class="sendresponse"></div>

            <div class="d-flex flex-column mb-3">
                <div class="p-3">
                    <div class="form-group mb-3">
                        <input type="hidden" name="getrp" value="<?php echo $getrp; ?>">
                        <input type="hidden" name="userh" value="<?php echo $getusr; ?>">

                        <label for="reset_pwd">
                            <?php echo $setUp->getString("new_password"); ?>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-key"></i></span>
                            <input name="reset_pwd" id="rep" type="password" class="form-control" value="">
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="confirm_pwd">
                            <?php echo $setUp->getString("new_password")." (".$setUp->getString("confirm").")"; ?>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-key"></i></span>
                            <input name="reset_conf" id="repconf" type="password" class="form-control" value="">
                        </div>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-primary sendreset">
                            <i class="bi bi-arrow-repeat"></i> <?php echo $setUp->getString("reset_password"); ?>
                        </button>
                    </div>
                </div>
                <div class="mailpreload">
                    <div class="position-absolute w-100 h-100 start-0 top-0 d-flex align-items-center justify-content-center">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </form>
<script type="text/javascript">
    $(".sendreset").on( "click", function() {
        $(".mailpreload").fadeIn(function(){
            var rep = $('#rep').val();
            var repconf = $('#repconf').val();
            var empty = $('#rpForm input').filter(function() {
                return this.value === "";
            });
            if(empty.length) {
                $(".mailpreload").fadeOut();
                $('.sendresponse').html('<div class="alert alert-warning"><?php echo $setUp->getString("fill_all_fields"); ?></div>').fadeIn();
            } else if (rep  !== repconf) {
                $(".mailpreload").fadeOut();
                $('.sendresponse').html('<div class="alert alert-warning"><?php echo $setUp->getString("password_does_not_match"); ?></div>').fadeIn();
            } else {
                $("#rpForm").submit();
            }
        });
    });
</script>
    <?php
endif;

/**
 * Send link
 */
if (!$getusr || $resetter->checkTok($getrp, $getusr) !== true) :
    if ($getusr && $resetter->checkTok($getrp, $getusr) !== true) { ?>
        <div class="alert alert-danger">
            <?php echo $setUp->getString("key_not_valid"); ?>
        </div>
        <?php
    }
    $pulito = $setUp->getConfig("script_url");
    ?>
            <form role="form" method="post" id="sendpwd" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                <div class="sendresponse"></div>
                <input name="cleanurl" type="hidden" value="<?php echo $pulito; ?>">
                <input name="thislang" type="hidden" value="<?php echo $setUp->lang; ?>">

                <div class="d-flex flex-column mb-3">
                    <div class="p-3">
                        <label class="visually-hidden" for="user_email"><?php echo $setUp->getString("email"); ?></label>
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input name="user_email" id="reqmail" type="email" placeholder="<?php echo $setUp->getString("email"); ?>" class="form-control" value="">
                            </div>
                        </div>
                        <?php
                        /* ************************ CAPTCHA ************************* */
                        if ($setUp->getConfig("show_captcha_reset") == true) {
                            $capath = "vfm-admin/";
                            include "vfm-admin/include/captcha.php";
                        } ?>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary"><i class="fa bi-arrow-circle-right"></i> <?php echo $setUp->getString("send"); ?></button>
                        </div>
                    </div>
                    <div class="p-3">
                        <?php echo $setUp->getString("enter_email_receive_link"); ?>
                    </div>
                    <div class="mailpreload">
                        <div class="position-absolute w-100 h-100 start-0 top-0 d-flex align-items-center justify-content-center">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
    <?php
endif; ?>
                <a class="btn btn-link" href="?dir=">
                    <i class="bi bi-box-arrow-in-right"></i> <?php echo $setUp->getString("log_in"); ?>
                </a>
            </div>
        </div>
    </div> <!-- .login -->
</section>
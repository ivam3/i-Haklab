<?php
/**
 * VFM - veno file manager: include/captcha.php
 * CAPTCHA code
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
if (SetUp::getConfig('recaptcha') && SetUp::getConfig('recaptcha_site')) : 

    $sitekey = SetUp::getConfig('recaptcha_site');

    if (SetUp::getConfig('recaptcha_invisible')) { ?>

    <div id="grecaptcha-invi" class="g-recaptcha"></div>
    <script type="text/javascript">
        var onloadCallback = function() {
            grecaptcha.render('grecaptcha-invi', {
                'sitekey' : '<?php echo $sitekey; ?>',
                'size' : 'invisible',
               // 'badge': 'inline'
            });
            grecaptcha.execute();
        };
    </script>
        <?php
    } else { ?>
    <div class="form-group">
        <div id="grecaptcha" class="g-recaptcha"></div>
    </div>
    <script type="text/javascript">
        var onloadCallback = function() {
            grecaptcha.render('grecaptcha', {
                'sitekey' : '<?php echo $sitekey; ?>',
                // 'size' : 'compact'
                // 'theme': 'dark'
            });
        };
    </script>
        <?php
    } ?>
    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit&hl=<?php echo $setUp->lang; ?>" async defer></script>
    <?php
else : ?>
    <div class="form-group captcha-group">
        <div class="input-group mb-3">
            <span class="input-group-text captchadd">
                <img src="<?php echo $capath; ?>captcha/img.php" id="captcha" />
            </span>

            <input class="form-control input" id="inputc" type="text" name="captcha" placeholder="<?php echo $setUp->getString('enter_captcha'); ?>" />
            <span class="input-group-btn">
                <button class="btn btn-link" type="button" id="capreload">
                    <i class="bi bi-arrow-repeat"></i>
                </button>
            </span>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#capreload').on('click', function(){  
                $('#captcha').attr('src', '<?php echo $capath; ?>captcha/img.php?' + (new Date()).getTime());
                $('#inputc').val('');
            });
        });
    </script>
    <?php
endif;

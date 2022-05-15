<?php
/**
 * VFM - veno file manager: include/footer.php
 * script footer
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
$privacy_file = 'vfm-admin/_content/privacy-info.html';
$privacy = file_exists($privacy_file) ? file_get_contents($privacy_file) : false;
?>
 <footer class="footer small bg-dark-lighter py-4">
    <div class="container">
        <div class="row">
        <div class="col-sm-6">
            <a href="<?php echo $setUp->getConfig('script_url'); ?>">
                <?php echo $setUp->getConfig("appname"); ?>
            </a> &copy; <?php echo date('Y'); ?>
            <?php
            if ($privacy) {
                ?> | 
                <a href="#" data-bs-toggle="modal" data-bs-target="#privacy-info">
                    <?php echo $setUp->getString("privacy"); ?>
                </a>
                <?php
            } ?>
        </div>

        <?php
        // Credits
        if ($setUp->getConfig('hide_credits') !== true) {
            $credits = $setUp->getConfig('credits');
            if ($credits) { ?>
                <div class="col-sm-6 text-sm-end">
                <?php
                if ($setUp->getConfig('credits_link')) { ?>
                    <a target="_blank" href="<?php echo $setUp->getConfig('credits_link'); ?>">
                        <?php echo $credits; ?>
                    </a>
                    <?php
                } else {
                    echo $credits;
                } ?>
                </div>
                <?php
            } else { ?>
                <div class="col-sm-6 text-sm-end">
                    <a title="Built with Veno File Manager" target="_blank" href="https://filemanager.veno.it">
                        <svg style="vertical-align: middle;" xmlns="http://www.w3.org/2000/svg" width="2em" height="1em" viewBox="0 0 24 12" fill="currentColor">
                            <path d="M4.2,10.2H3.8L0.1,1.8l0.5,0L4,9.6l3.4-7.8l0.5,0C7.9,1.8,4.2,10.2,4.2,10.2z M8.9,2.2v3.4h4.6V6H8.9v4.2H8.5V1.8h5.8v0.4 C14.3,2.2,8.9,2.2,8.9,2.2z M23.3,10.2V2.5l-3.8,7.7h-0.4l-3.8-7.7v7.7h-0.4V1.8l0.6,0l3.9,7.9l3.9-7.9l0.6,0v8.4H23.3z"/>
                        </svg>
                    </a>
                </div>
                <?php
            }
        } ?>
        </div>
    </div>
</footer>
<div class="to-top"><i class="bi bi-chevron-up"></i></div>
<?php
if ($privacy) {
    echo $privacy;
}

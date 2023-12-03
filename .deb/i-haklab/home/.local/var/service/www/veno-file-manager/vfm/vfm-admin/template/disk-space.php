<?php
/**
 * VFM - veno file manager: include/disk-space.php
 * user's used space bar
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
 * Show user used space
 */
if ($gateKeeper->getUserInfo('dir') !== null
    && $gateKeeper->getUserInfo('quota') !== null
    && isset($_SESSION['vfm_user_used'])
) {
    $_USED = $_SESSION['vfm_user_used'];
    $maxsize = $gateKeeper->getUserInfo('quota');
    $maxsize = $maxsize*1048576;

    $division = $_USED / $maxsize;
    $rest = $maxsize - $_USED;
    
    if ($division > 1) {
        $division = 1;
    }
    if ($rest < 0) {
        $rest = 0;
    }

    $perc = round($division * 100, 2);

    if ($perc < 0) {
        $perc = 0;
    }
    if ($perc <= 60) {
        $progressclass = "bg-info";
    } elseif ($perc > 60 && $perc <= 90) {
        $progressclass = "bg-warning";
    } elseif ($perc > 90) {
        $progressclass = "bg-danger";
    }
    ?>
        <div class="col-12 py-2">
            <div class="d-flex align-items-center justify-content-between small">
                <span class="form-label">
                    <i class="bi bi-circle-fill"></i> <?php echo $setUp->formatSize($_USED); ?>
                </span>
                <span class="d-none d-md-inline-block form-label"><?php echo $setUp->getString("available_space"); ?></span>
                <span class="form-label">
                    <?php echo $setUp->formatSize($rest); ?> <i class="bi bi-circle"></i>
                </span>
            </div>
            <div class="fullp">
                <div class="progress bg-light-darker">
                    <div class="progress-bar <?php echo $progressclass; ?>" role="progressbar" aria-valuenow="<?php echo $perc; ?>" aria-valuemin="0" aria-valuemax="200" style="width: <?php echo $perc; ?>%;">
                        <?php echo $perc; ?>%
                    </div>
                </div>
            </div>
        </div>
    <?php
} ?>
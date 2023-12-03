<?php
/**
 * Footer Credits
 *
 * @package    VenoFileManager
 * @subpackage Administration
 */
?>
<div class="card mb-3">
    <div class="card-header d-flex align-items-center">
        <span><i class="bi bi-badge-tm"></i> <?php echo $setUp->getString('credits'); ?></span>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-6 mb-3">
                <label class="form-label"><?php echo $setUp->getString('text'); ?></label>
                <input type="text" class="form-control" name="credits" value="<?php echo $setUp->getConfig('credits'); ?>" placeholder="VFM">
            </div><!-- col-sm-6 -->

            <div class="col-lg-6 mb-3">
                <label class="form-label"><?php echo $setUp->getString('link'); ?></label>
                <input type="url" class="form-control" name="credits_link" value="<?php echo $setUp->getConfig('credits_link'); ?>" placeholder="http://">
            </div>
        </div><!-- row -->

        <?php $hidechecked = $setUp->getConfig('hide_credits') ? ' checked' : ''; ?>
        <div class="row toggle-reverse">
            <div class="col-12">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="hide_credits" name="hide_credits"<?php echo $hidechecked; ?>><i class="bi bi-eye-slash"></i> 
                    <label class="form-check-label" for="hide_credits"><?php echo $setUp->getString("remove"); ?></label>
                </div>
            </div>
        </div>
    </div><!-- box-body -->
</div><!-- box -->

<?php
/**
 * Appearance
 *
 * @package    VenoFileManager
 * @subpackage Administration
 */
?>
<div id="view-appearance" class="anchor"></div>
<div class="row mb-3">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-palette2"></i> <?php echo $setUp->getString("colors"); ?>
            </div>
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-4">
                        <input class="form-control admin-colorpicker" data-color-selector="primary" value="<?php echo $setUp->getConfig('--color-primary', 'hsl(216, 98%, 52%)'); ?>" name="--color-primary"/>
                    </div>
                    <div class="col-4">
                        <input class="form-control admin-colorpicker" data-color-selector="dark" value="<?php echo $setUp->getConfig('--color-dark', 'hsl(210, 11%, 15%)'); ?>" name="--color-dark" />
                    </div>
                    <div class="col-4">
                        <input class="form-control admin-colorpicker" data-color-selector="light" value="<?php echo $setUp->getConfig('--color-light', 'hsl(210, 16%, 98%)'); ?>" name="--color-light"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="card mb-3">
            <div class="card-header d-flex align-items-center">
                <i class="bi bi-pin-angle"></i> <?php echo $setUp->getString('site_icon'); ?>
            </div>
            <div class="card-body">
                <label class="form-label"><?php echo $setUp->getString('browser_and_app_icon'); ?></label>
                <div class="d-flex align-items-center mb-3 placeheader">
                    <div class="pe-3">
                        <div class="placeicon">
                            <img class="app_ico-preview rounded" src="<?php echo $admin->printImgPlace('_content/uploads/favicon.ico'); ?>?t=<?php echo time(); ?>" style="height: 16px; width: 16px;">
                        </div>
                    </div>
                    <div class="pe-3">
                        <img class="app_ico-preview shadow-sm rounded" src="<?php echo $admin->printImgPlace('_content/uploads/favicon-152.png'); ?>?t=<?php echo time(); ?>" style="height: 76px; width: 76px;">
                    </div>
                    <div class="pe-3">
                        <input type="file" name="app_ico" value="select" id="app-icon-selector" class="logo-selector d-none" data-target=".app_ico-preview" accept="image/png,image/gif,image/jpg">
                        <button class="btn btn-primary rounded-0 fake-uploader" type="button" data-up-target="#app-icon-selector"><i class="bi bi-upload"></i></button>
                        <?php $deletericoclass = file_exists('_content/uploads/favicon.ico') ? '' : ' d-none'; ?>
                        <button class="btn btn-danger rounded-0 deletelogo pos-relative<?php echo $deletericoclass;?>" data-setting="app_ico">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                    <input type="hidden" name="remove_app_ico" value="0">
                </div>
                
            </div><!-- box-body -->
            <div class="card-footer">
                <small>Min. 152x152 px (gif, jpg, png)</small>
            </div>
        </div><!-- box -->

        <?php
        $navbar_logo = $setUp->getConfig('navbar_logo', false) ? '_content/uploads/'.$setUp->getConfig('navbar_logo') : 'admin-panel/images/placeholder.png';
        $deleterclass = $setUp->getConfig('navbar_logo', false) ? '' : ' d-none';
        $hide_logo_checked = $setUp->getConfig('hide_logo', false) ? ' checked' : '';

        $navbar_brand_class = $setUp->getConfig('hide_logo', false) ? ' d-none' : ' d-flex';

        $navbar_brand_img_class = ' d-none';
        $navbar_brand_text_class = '';

        if ($setUp->getConfig('navbar_logo')) {
            $navbar_brand_img_class = '';
            $navbar_brand_text_class = ' d-none';
        }
        ?>
        <div class="card mb-3">
            <div class="card-header d-flex align-items-center">
                <span><i class="bi bi-patch-check"></i> <?php echo $setUp->getString('navbar_brand'); ?></span>
            </div>
            <div class="card-body">
                <div class="d-flex w-100 align-items-center mb-3">
                    <div class="flex-grow-1">
                        <div class="navbar bg-dark shadow-sm placeheader">
                            <div class="nav-brand-group ps-3 align-items-center<?php echo $navbar_brand_class; ?>">
                                <span id="navbar-brand-text" class="navbar-brand<?php echo $navbar_brand_text_class; ?>"><?php echo $setUp->getConfig("appname"); ?></span>
                                <button class="btn btn-danger btn-sm rounded-0 show-brand-text deletelogo<?php echo $deleterclass;?>" data-setting="navbar_logo">&times;</button>
                                <span class="navbar-brand">
                                    <img id="navbar-brand-image" class="navbar_logo-preview<?php echo $navbar_brand_img_class; ?>" src="<?php echo $navbar_logo; ?>?t=<?php echo time(); ?>">
                                </span>
                            </div>
                            <i class="bi bi-list ms-auto me-3"></i>
                        </div>
                        <input type="hidden" name="remove_navbar_logo" value="0">
                    </div>

                    <div class="ps-3">
                        <input type="file" name="navbar_logo" value="select" id="navbar-logo-selector" class="logo-selector navbar-logo d-none" data-target=".navbar_logo-preview">
                        <button class="btn btn-primary rounded-0 fake-uploader" type="button" data-up-target="#navbar-logo-selector"><i class="bi bi-upload"></i></button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" name="hide_logo" type="checkbox" role="switch" id="toggle-navbar-brand-view"<?php echo $hide_logo_checked; ?>>
                            <label class="form-check-label" for="toggle-navbar-brand-view"><?php echo $setUp->getString("hide_navbar_brand"); ?></label>
                        </div>
                    </div>
                </div>
            </div><!-- box-body -->
        </div><!-- box -->
    </div><!-- col6 -->

    <div class="col-lg-6">
        <div class="card mb-3">
            <div class="card-header d-flex align-items-center">
                <span><i class="bi bi-bell"></i> <?php echo $setUp->getString('notifications'); ?></span>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php $stickypos = $setUp->getConfig('sticky_alerts_pos') ? $setUp->getConfig('sticky_alerts_pos') : 'top-left'; ?>
                    <label class="form-label"><i class="bi bi-pip"></i> <?php echo $setUp->getString("position"); ?></label>
                    <div class="col-6 mb-3">
                        <?php  ?>
                        <div class="form-group">
                            <select class="form-select" name="sticky_alerts_pos_v">
                                <?php $optionselect = ($stickypos == "top-left" || $stickypos == "top-right") ? ' selected' : ''; ?>
                                <option value="top"<?php echo $optionselect; ?>>top</option>
                                <?php $optionselect = ($stickypos == "bottom-left" || $stickypos == "bottom-right") ? ' selected' : ''; ?>
                                <option value="bottom"<?php echo $optionselect; ?>>bottom</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="form-group">
                            <select class="form-select" name="sticky_alerts_pos_h">
                                <?php $optionselect = ($stickypos == "top-left" || $stickypos == "bottom-left") ? ' selected' : ''; ?>
                                <option value="left"<?php echo $optionselect; ?>>left</option>
                                <?php $optionselect = ($stickypos == "top-right" || $stickypos == "bottom-right") ? ' selected' : ''; ?>
                                <option value="right"<?php echo $optionselect; ?>>right</option>
                            </select>
                        </div>
                    </div> <!-- col 6 -->
                </div>

                <div class="row">
                    <div class="col-12">
                        <label class="form-label">
                            <i class="bi bi-volume-up"></i> <?php print $setUp->getString("audio_notification_after_upload"); ?>
                        </label>
                    </div>
                    <div class="col-12">
                        <?php
                        $audiofiles = glob("_content/audio/*.mp3"); ?>
                        <select class="form-select audio-notif" name="audio_notification">
                            <option value="">---</option>
                        <?php
                        foreach ($audiofiles as $audio) {
                            $selectedaudio = ($audio == $setUp->getConfig('audio_notification')) ? ' selected' : ''; ?>
                            <option value="<?php echo $audio; ?>"<?php echo $selectedaudio; ?>>
                                <?php echo basename($audio, '.mp3'); ?>
                            </option>
                            <?php
                        } ?>
                        </select>
                    </div>
                </div>
            </div><!-- box-body -->
        </div><!-- box -->

        <div class="card mb-3">
            <div class="card-header">
                <i class="bi bi-square-half"></i> <?php echo $setUp->getString('upload_progress'); ?>
            </div>
            <div class="card-body">
                <?php
                $colorbarselected = $setUp->getConfig('progress_color', false);
                $percentclass = $setUp->getConfig('show_percentage') ? ' fullp' : '';
                ?>
                <div class="form-group progress-group mb-2<?php echo $percentclass; ?>">
                    <div class="form-check pro d-flex justify-content-center align-items-center">
                        <?php
                        $optioncheck = ! $colorbarselected ? ' checked' : ''; ?>
                        <input type="radio" name="progressColor" value="" id="progress-primary" data-color="" class="mt-0 form-check-input first-progress"<?php echo $optioncheck; ?>>
                        <label for="progress-primary" class="form-check-label ms-auto w-100">
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%"><span class="propercent">45%</span></div>
                            </div>
                        </label>
                    </div>
                    <div class="form-check pro d-flex justify-content-center align-items-center">
                        <?php
                        $this_skin = 'bg-info';
                        $bs3_skin = 'progress-bar-info';
                        $optioncheck = $colorbarselected == $this_skin || $colorbarselected == $bs3_skin ? ' checked' : ''; ?>
                        <input type="radio" name="progressColor" value="<?php echo $this_skin; ?>" id="<?php echo $this_skin; ?>" data-color="<?php echo $this_skin; ?>" class="mt-0 form-check-input"<?php echo $optioncheck; ?>>
                        <label for="<?php echo $this_skin; ?>" class="form-check-label ms-auto w-100">
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated <?php echo $this_skin; ?>" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 65%"><span class="propercent">65%</span></div>
                            </div>
                        </label>
                    </div>
                    <div class="form-check pro d-flex justify-content-center align-items-center">
                        <?php
                        $this_skin = 'bg-success';
                        $bs3_skin = 'progress-bar-success';
                        $optioncheck = $colorbarselected == $this_skin || $colorbarselected == $bs3_skin ? ' checked' : ''; ?>
                        <input type="radio" name="progressColor" value="<?php echo $this_skin; ?>" id="<?php echo $this_skin; ?>" data-color="<?php echo $this_skin; ?>" class="mt-0 form-check-input"<?php echo $optioncheck; ?>>
                        <label for="<?php echo $this_skin; ?>" class="form-check-label ms-auto w-100">
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated <?php echo $this_skin; ?>" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 35%"><span class="propercent">35%</span></div>
                            </div>
                        </label>
                    </div>
                    <div class="form-check pro d-flex justify-content-center align-items-center">
                        <?php
                        $this_skin = 'bg-warning';
                        $bs3_skin = 'progress-bar-warning';
                        $optioncheck = $colorbarselected == $this_skin || $colorbarselected == $bs3_skin ? ' checked' : ''; ?>
                        <input type="radio" name="progressColor" value="<?php echo $this_skin; ?>" id="<?php echo $this_skin; ?>" data-color="<?php echo $this_skin; ?>" class="mt-0 form-check-input"<?php echo $optioncheck; ?>>
                        <label for="<?php echo $this_skin; ?>" class="form-check-label ms-auto w-100">
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated <?php echo $this_skin; ?>" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 85%"><span class="propercent">85%</span></div>
                            </div>
                        </label>
                    </div>
                    <div class="form-check pro d-flex justify-content-center align-items-center">
                        <?php
                        $this_skin = 'bg-danger';
                        $bs3_skin = 'progress-bar-danger';
                        $optioncheck = $colorbarselected == $this_skin || $colorbarselected == $bs3_skin ? ' checked' : ''; ?>
                        <input type="radio" name="progressColor" value="<?php echo $this_skin; ?>" id="<?php echo $this_skin; ?>" data-color="<?php echo $this_skin; ?>" class="mt-0 form-check-input"<?php echo $optioncheck; ?>>
                        <label for="<?php echo $this_skin; ?>" class="form-check-label ms-auto w-100">
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated <?php echo $this_skin; ?>" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 75%"><span class="propercent">75%</span></div>
                            </div>
                        </label>
                    </div>
                    <div class="form-check">
                        <?php $formchecked = $setUp->getConfig('show_percentage') ? ' checked' : ''; ?>
                        <input class="form-check-input" type="checkbox" value="" name="show_percentage" id="percent"<?php echo $formchecked; ?>>
                        <label class="form-check-label" for="percent">
                            <?php echo $setUp->getString("show_percentage"); ?> %
                        </label>
                    </div>
                    <div class="form-check progress-single">
                        <?php $formchecked = $setUp->getConfig('single_progress') ? ' checked' : ''; ?>
                        <input class="form-check-input" type="checkbox" value="" name="single_progress" id="single-progress"<?php echo $formchecked; ?>>
                        <label for="single-progress" class="form-check-label ms-auto w-100">
                            <div class="progress">
                                <div class="progress-bar <?php echo $colorbarselected; ?>" role="progressbar" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100" style="width: 65%"><?php echo $setUp->getString("single_progress"); ?></div>
                            </div>
                        </label>
                    </div>
                </div>
            </div><!-- box-body -->
        </div><!-- box -->


    </div> <!-- col-sm-6 -->
</div> <!-- row -->
<?php
require dirname(__FILE__)."/custom-header.php";
require dirname(__FILE__)."/footer-credits.php";

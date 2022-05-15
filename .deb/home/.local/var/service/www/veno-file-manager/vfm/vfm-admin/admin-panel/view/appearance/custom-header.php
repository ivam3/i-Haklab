<?php
/**
 * Header Customizer
 *
 * @package    VenoFileManager
 * @subpackage Administration
 */
?>
<div class="card mb-3">
    <div class="card-header">
        <i class="bi bi-view-list"></i> <?php echo $setUp->getString('custom_header'); ?>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-6">
                <?php
                switch ($setUp->getConfig("align_logo")) {
                case "left":
                    $placealign = " text-start";
                    break;
                case "center":
                    $placealign = " text-center";
                    break;
                case "right":
                    $placealign = " text-end";
                    break;
                default:
                    $placealign = " text-start";
                }
                $setwide = $setUp->getConfig("banner_width", 'wide');
                $header_img = $setUp->getConfig('logo', false) ? '_content/uploads/'.$setUp->getConfig('logo') : 'admin-panel/images/placeholder.png';
                $deleterclass2 = $setUp->getConfig('logo', false) ? '' : ' d-none';
                ?>
                <div class="row">
                    <div class="col-12">
                       <div class="form-group mb-3">
                            <label class="form-label"><?php echo $setUp->getString("layout"); ?></label>
                            <div class="form-group select-banner-width">
                                <?php $formcheck = $setwide == "wide" ? ' checked' : ''; ?>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="banner_width" id="banner_width-wide" value="wide"<?php echo $formcheck; ?>>
                                  <label class="form-check-label" for="banner_width-wide">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor">
    <path d="M13.6,1C13.6,1,13.6,1,13.6,1H2.4C1.1,1,0,2.1,0,3.4V6v4v2.6C0,13.9,1.1,15,2.4,15c0,0,0,0,0,0h11.2c1.3,0,2.4-1.1,2.4-2.4 V10V6V3.4C16,2.1,14.9,1,13.6,1z M1,3.4C1,2.6,1.6,2,2.4,2h11.2C14.4,2,15,2.6,15,3.4V4H1V3.4z M15,12.6c0,0.7-0.6,1.4-1.4,1.4H2.4 C1.6,14,1,13.4,1,12.6v0V10h14V12.6z M1,6V5h14v1H1z"/>
</svg> <?php echo $setUp->getString("wide"); ?></label>
                                </div>

                                <?php $formcheck = $setwide == "boxed" ? ' checked' : ''; ?>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="banner_width" id="banner_width-boxed" value="boxed"<?php echo $formcheck; ?>>
                                  <label class="form-check-label" for="banner_width-boxed">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16"  fill="currentColor">
    <path d="M2.4,1C1.1,1,0,2.1,0,3.4c0,0,0,0,0,0v9.3C0,13.9,1.1,15,2.4,15c0,0,0,0,0,0h11.2c1.3,0,2.4-1.1,2.4-2.4c0,0,0,0,0,0V3.4 C16,2.1,14.9,1,13.6,1c0,0,0,0,0,0H2.4z M1,3.4C1,2.6,1.6,2,2.4,2h11.2C14.4,2,15,2.6,15,3.4V4H1C1,4,1,3.4,1,3.4z M1,5h14v7.6 c0,0.7-0.6,1.4-1.4,1.4H2.4C1.6,14,1,13.4,1,12.6c0,0,0,0,0,0V5z"/>
    <path d="M13,6H3v4h10V6z"/>
</svg> <?php echo $setUp->getString("boxed"); ?></label>
                                </div>
                            </div>
                        </div> <!-- .form-group-->
                    </div>
                    <?php
                    $setalign_logo = $setUp->getConfig("align_logo", 'center'); ?>
                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label class="form-label"><?php echo $setUp->getString("alignment"); ?></label>
                            <div class="form-group select-logo-alignment">
                                <?php $formcheck = $setalign_logo == "left" ? ' checked' : ''; ?>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="align_logo" id="align_logo-left" value="left"<?php echo $formcheck; ?>>
                                  <label class="form-check-label" for="align_logo-left"><i class="bi bi-text-left"></i></label>
                                </div>
                                <?php $formcheck = $setalign_logo == "center" ? ' checked' : ''; ?>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="align_logo" id="align_logo-center" value="center"<?php echo $formcheck; ?>>
                                  <label class="form-check-label" for="align_logo-center"><i class="bi bi-text-center"></i></label>
                                </div>
                                <?php $formcheck = $setalign_logo == "right" ? ' checked' : ''; ?>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="align_logo" id="align_logo-right" value="right"<?php echo $formcheck; ?>>
                                  <label class="form-check-label" for="align_logo-right"><i class="bi bi-text-right"></i></label>
                                </div>
                            </div>
                        </div> <!-- .form-group-->
                    </div>
                    <?php
                    $setheader_padding = $setUp->getConfig("header_padding", 0); ?>
                    <div class="col-sm-12">
                       <div class="form-group mb-3">
                            <label class="form-label">
                                <i class="bi bi-arrows-expand"></i> <?php echo $setUp->getString("margin"); ?>
                            </label>
                            <div class="row align-items-center">
                                <div class="col-7 d-flex align-items-center">
                                    <input name="header_padding" type="range" min="0" max="200" step="1" value="<?php echo $setheader_padding; ?>" class="form-range set-slider" data-vfm-target="#get_header_padding" id="set_header_padding">
                                </div>
                                <div class="col-5 d-flex align-items-center">
                                    <div class="input-group">
                                        <input type="number" id="get_header_padding" class="form-control get-slider" value="<?php echo $setheader_padding; ?>" min="0" max="200" data-vfm-target="#set_header_padding">
                                        <div class="input-group-text">px</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $setlogo_margin = $setUp->getConfig("logo_margin", 0); ?>
                    <div class="col-sm-12">
                       <div class="form-group mb-3">
                            <label class="form-label"><i class="bi bi-arrow-bar-down"></i> <?php echo $setUp->getString("margin_bottom"); ?></label>
                            <div class="row align-items-center">
                                <div class="col-7 d-flex align-items-center">
                                    <input name="logo_margin" type="range" min="0" max="100" step="1" value="<?php echo $setlogo_margin; ?>" class="form-range set-slider" data-vfm-target="#get_logo_margin" id="set_logo_margin">
                               </div>
                                <div class="col-5 d-flex align-items-center">
                                    <div class="input-group">
                                        <input type="number" id="get_logo_margin" class="form-control get-slider" value="<?php echo $setlogo_margin; ?>" min="0" max="100" data-vfm-target="#set_logo_margin">
                                        <span class="input-group-text">px</span>
                                    </div>
                               </div>
                            </div>
                        </div>
                    </div>
                   <?php $header_pos = $setUp->getConfig("header_position", 'below'); ?>
                    <div class="col-sm-12">
                        <div class="form-group mb-3">
                            <label class="form-label"><?php echo $setUp->getString("position"); ?></label>
                            <div class="form-group">
                                <?php $formcheck = $header_pos == "below" ? ' checked' : ''; ?>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="header_position" id="header_position-below" value="below"<?php echo $formcheck; ?>>
                                  <label class="form-check-label" for="header_position-below"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 12 12" fill="currentColor">
                                        <path d="M0,1.8v8.3h12V1.8H0z M11.5,9.5H0.5V3.7h10.9V9.5z"/>
                                    </svg></label>
                                </div>
                                <?php $formcheck = $header_pos == "above" ? ' checked' : ''; ?>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="header_position" id="header_position-above" value="above"<?php echo $formcheck; ?>>
                                  <label class="form-check-label" for="header_position-above"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 12 12" fill="currentColor">
                                        <path d="M12,10.2V1.8H0v8.3H12z M0.5,2.5h10.9v5.8H0.5V2.5z"/>
                                    </svg></label>
                                </div>
                            </div>
                        </div> <!-- .form-group-->
                    </div>
                </div><!-- row -->
            </div><!-- col-sm-6 -->
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-12 mb-3">
                        <label class="form-label"><?php echo $setUp->getString("header_image"); ?></label>
                        <div class="placeheader header-bg place-main-header form-group<?php echo $placealign; ?>">
                            <div class="wrap-image-header <?php echo $setwide; ?>">
                                <img class="logo-preview" src="<?php echo $header_img; ?>?t=<?php echo time(); ?>">
                            </div>
                            <button class="btn btn-danger btn-sm rounded-0 deletelogo<?php echo $deleterclass2; ?>" data-setting="logo">&times;</button>
                        </div>
                        <input type="hidden" name="remove_logo" value="0">
                    </div>
                    <div class="col-12 mb-3">
                        <input type="file" name="header_image" value="select" id="header-img-selector" class="logo-selector d-none" data-target=".logo-preview">
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary rounded-0 fake-uploader" type="button" data-up-target="#header-img-selector"><i class="bi bi-upload"></i></button>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label"><?php echo $setUp->getString("description"); ?></label>
                        <textarea class="form-control easyeditor" name="description"><?php print $setUp->getConfig('description'); ?></textarea>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="form-check">
                            <?php $formchecked = $setUp->getConfig('dark_header') ? ' checked' : ''; ?>
                            <input class="form-check-input" type="checkbox" value="" name="dark_header" id="dark_header"<?php echo $formchecked; ?>>
                            <label class="form-check-label" for="dark_header">
                                <?php echo $setUp->getString("dark_background"); ?>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- row -->
    </div><!-- box-body -->
</div><!-- box -->

<?php
/**
* FILE SHARING
**/
?>
<div class="row mb-3">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-center align-items-center">
                <h4 class="m-0" id="view-share"><i class="bi bi-send"></i> <?php print $setUp->getString("share_files"); ?></h4>
                <button type="button" class="btn ms-auto" data-bs-toggle="collapse" data-bs-target="#card-share" aria-expanded="false">
                    <i class="bi bi-dash-lg"></i>
                </button>
            </div>
            <div class="collapse show" id="card-share">
            <div class="card-body">
                <div class="form-group toggled">
                    <div class="row">
                        <div class="col-sm-6">
                            <label class="form-label"><?php echo $setUp->getString("keep_links"); ?></label>
                            <select class="form-select" name="lifetime">
                            <?php
                            foreach ($share_lifetime as $key => $value) {
                                $optionselected = $setUp->getConfig('lifetime') == $key ? ' selected' : ''; ?>
                                <option value="<?php echo $key; ?>"<?php echo $optionselected; ?>><?php echo $value; ?></option>
                                <?php
                            } ?>
                            </select>
                        </div>

                        <div class="col-sm-6">
                            <?php $formchecked = $setUp->getConfig('one_time_download') ? ' checked' : ''; ?>
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" role="switch" type="checkbox" name="one_time_download" id="one_time_download" <?php echo $formchecked; ?>>
                                <label class="form-check-label" for="one_time_download"><i class="bi bi-arrow-down-circle"></i> <?php echo $setUp->getString("one_time_download"); ?>
                                <a title="<?php echo $setUp->getString("remove_link_once_downloaded"); ?>" class="tooltipper" data-bs-placement="right" data-bs-toggle="tooltip" href="javascript:void(0)">
                                    <i class="bi bi-question-circle"></i>
                                </a></label>
                            </div>

                            <?php $formchecked = $setUp->getConfig('secure_sharing') ? ' checked' : ''; ?>
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" role="switch" type="checkbox" name="secure_sharing" id="secure_sharing" <?php echo $formchecked; ?>>
                                <label class="form-check-label" for="secure_sharing"><i class="bi bi-key"></i> <?php echo $setUp->getString("password_protection"); ?></label>
                            </div>

                            <?php $formchecked = $setUp->getConfig('clipboard') ? ' checked' : ''; ?>
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" role="switch" type="checkbox" name="clipboard" id="clipboard" <?php echo $formchecked; ?>>
                                <label class="form-check-label" for="clipboard"><i class="bi bi-clipboard-check"></i> <?php echo $setUp->getString("copy_to_clipboard"); ?></label>
                            </div>

                            <?php $formchecked = $setUp->getConfig('share_thumbnails') ? ' checked' : ''; ?>
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" role="switch" type="checkbox" name="share_thumbnails" id="share_thumbnails" <?php echo $formchecked; ?>>
                                <label class="form-check-label" for="share_thumbnails"><i class="bi bi-aspect-ratio"></i> <?php echo $setUp->getString("can_thumb"); ?></label>
                            </div>

                            <?php $formchecked = $setUp->getConfig('share_playmusic') ? ' checked' : ''; ?>
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" role="switch" type="checkbox" name="share_playmusic" id="share_playmusic" <?php echo $formchecked; ?>>
                                <label class="form-check-label" for="share_playmusic"><i class="bi bi-music-note-beamed"></i> <?php echo $setUp->getString("mp3_player"); ?></label>
                            </div>

                            <?php $formchecked = $setUp->getConfig('share_playvideo') ? ' checked' : ''; ?>
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" role="switch" type="checkbox" name="share_playvideo" id="share_playvideo" <?php echo $formchecked; ?>>
                                <label class="form-check-label" for="share_playvideo"><i class="bi bi-film"></i> <?php echo $setUp->getString("video_player"); ?></label>
                            </div>
                        </div>
                    </div>
                </div> <!-- toggled -->
            </div> <!-- box-body -->
            </div>
        </div> <!-- box -->
    </div> <!-- col -->
</div> <!-- row -->
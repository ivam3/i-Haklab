<?php
/**
 * UPLOADS
 */
?>
<div class="row mb-3">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-center align-items-center">
                <h4 class="m-0" id="view-uploads"><i class="bi bi-cloud-arrow-up"></i> <?php print $setUp->getString("upload"); ?></h4>
                <button type="button" class="btn ms-auto" data-bs-toggle="collapse" data-bs-target="#card-uploads" aria-expanded="false">
                    <i class="bi bi-dash-lg"></i>
                </button>
            </div>
            <div class="collapse show" id="card-uploads">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group mb-3">
                            <label class="form-label"><i class="bi bi-folder2-open"></i> <?php print $setUp->getString("uploads_dir"); ?></label>
                            <?php
                            $cleandir = substr($setUp->getConfig('starting_dir'), 2);
                            $cleandir = substr_replace($cleandir, "", -1); ?>
                            <input type="text" class="form-control blockme" name="starting_dir" value="<?php echo $cleandir; ?>">
                        </div>
                        <div class="form-text mb-3">
                            <code class="bg-danger bg-opacity-10 px-2">download</code> <?php print $setUp->getString("is_reserved_for_pretty_links_rewriting"); ?>.
                        </div>

                        <div class="toggle-wrap mb-3">
                            <?php $formchecked = $setUp->getConfig('selectivext') == "reject" ? ' checked' : ''; ?>
                            <div class="form-check">
                                <input class="form-check-input togglext" type="radio" value="reject" name="selectivext" id="selectivext_reject" <?php echo $formchecked; ?>>
                                <label class="form-check-label" for="selectivext_reject"><?php print $setUp->getString("rejected_ext"); ?></label>
                            </div>
                            <div class="form-group tagin-danger toggle-collapse">
                                <?php
                                $upload_reject_extension = $setUp->getConfig('upload_reject_extension');
                                $rejectlist = $upload_reject_extension ? implode(",", $upload_reject_extension) : ''; ?>
                                <input type="text" class="form-control tagin" name="upload_reject_extension" data-tag="danger" value="<?php echo $rejectlist; ?>" placeholder="php,ht.." data-tagin-placeholder="php,htm..">
                            </div>
                        </div>
                        <div class="toggle-wrap mb-3">
                            <?php $formchecked = $setUp->getConfig('selectivext') == "allow" ? ' checked' : ''; ?>
                            <div class="form-check">
                                <input class="form-check-input togglext" type="radio" value="allow" name="selectivext" id="selectivext_allow" <?php echo $formchecked; ?>>
                                <label class="form-check-label" for="selectivext_allow"><?php print $setUp->getString("allowed_ext"); ?></label>
                            </div>
                            <div class="form-group tagin-success toggle-collapse">
                                <?php
                                $upload_allow_type = $setUp->getConfig('upload_allow_type');
                                $allowlist = $upload_allow_type ? implode(",", $upload_allow_type) : ''; ?>
                                <input type="text" class="form-control tagin" name="upload_allow_type" data-tag="success" value="<?php echo $allowlist; ?>" placeholder="jpg,gif,pn.." data-tagin-placeholder="jpg,gif,pn..">
                            </div>
                        </div>

                    </div> <!-- col-sm-6 -->

                    <div class="col-sm-6">
                        <div class="form-group mb-3">
                            <label class="form-label"><?php print $setUp->getString("maximum_upload_filesize"); ?></label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="max_upload_filesize" value="<?php echo $setUp->getConfig('max_upload_filesize'); ?>">
                                <span class="input-group-text">MB</span>
                            </div> 
                        </div>

                        <div class="form-group">
                            <label class="form-label"><?php echo $setUp->getString("overwrite_files"); ?></label>
                        </div>
                        <div class="form-group mb-3">
                            <?php $formchecked = ($setUp->getConfig('overwrite_files') == 'no' || !$setUp->getConfig('overwrite_files')) ? ' checked' : ''; ?>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="overwrite_files" id="overwrite_files_no" value="no" <?php echo $formchecked; ?>>
                                <label class="form-check-label" for="overwrite_files_no"><?php echo $setUp->getString("prevent"); ?></label>
                            </div>
                            <?php $formchecked = $setUp->getConfig('overwrite_files') == 'yes' ? ' checked' : ''; ?>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="overwrite_files" id="overwrite_files_yes" value="yes" <?php echo $formchecked; ?>>
                                <label class="form-check-label" for="overwrite_files_yes"><?php echo $setUp->getString("overwrite"); ?></label>
                            </div>
                            <?php $formchecked = $setUp->getConfig('overwrite_files') == 'date' ? ' checked' : ''; ?>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="overwrite_files" id="overwrite_files_date" value="date" <?php echo $formchecked; ?>>
                                <label class="form-check-label" for="overwrite_files_date"><?php echo $setUp->getString("append_date"); ?></label>
                            </div>
                        </div>

                    <?php
                    if (!function_exists('curl_version')) { ?>
                        <p class="bg-warning">The Remote Uploader needs the <strong>PHP Curl</strong> extension enabled</p>
                        <?php
                    } else {
                        $remotechecked = $setUp->getConfig('remote_uploader') ? 'checked' : ''; ?>
                    <div class="toggle-wrap mb-2">
                        <div class="form-check form-switch toggle-extensions mb-1">
                            <input class="form-check-input togglext" role="switch" type="checkbox" name="remote_uploader" id="remote_uploader" <?php echo $remotechecked; ?>>
                            <label class="form-check-label mb-0" for="remote_uploader"><i class="bi bi-globe2"></i> <?php print $setUp->getString("remote_upload"); ?></label>
                        </div>
                        <div class="form-group toggle-collapse">
                            <label class="form-label"><?php echo $setUp->getString("allowed_ext"); ?></label>
                            <?php
                            $remote_allow_type = $setUp->getConfig('remote_extensions');
                            $remote_allowlist = $remote_allow_type ? implode(",", $remote_allow_type) : false; ?>
                            <input type="text" class="form-control tagin" name="remote_extensions" data-tag="success" value="<?php echo $remote_allowlist; ?>" data-tagin-placeholder="jpg,gif,pn.." placeholder="jpg,gif,pn..">
                        </div>
                    </div>
                        <?php
                    } ?>

                    </div> <!-- col 6 -->


                </div> <!-- row -->
            </div> <!-- box-body -->
        </div> <!-- collpase -->

        </div> <!-- box -->
    </div> <!-- col-12 -->
</div> <!-- row -->

<?php
/**
 * TABLES CONFIGURATION
 */
?>
<div class="row mb-3">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-center align-items-center">
                <h4 class="m-0" id="view-lists"><i class="bi bi-card-list"></i> <?php echo $setUp->getString("lists"); ?></h4>
                <button type="button" class="btn ms-auto" data-bs-toggle="collapse" data-bs-target="#card-lists" aria-expanded="false">
                    <i class="bi bi-dash-lg"></i>
                </button>
            </div>
            <div class="collapse show" id="card-lists">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="row mb-2">
                            <div class="col-12">
                                <label class="form-label"><?php echo $setUp->getString("default_view"); ?></label>
                            </div>
                            <div class="col-12 mb-2">
                                <?php
                                $list_view = $setUp->getConfig('list_view', 'list');
                                $formchecked = $list_view == 'grid' ? ' checked' : ''; ?>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="list_view" id="list_view_grid" value="grid" <?php echo $formchecked; ?>>
                                    <label class="form-check-label" for="list_view_grid"><i class="bi bi-grid"></i> <?php echo $setUp->getString("grid"); ?></label>
                                </div>
                                <?php $formchecked = $list_view == 'list' ? ' checked' : ''; ?>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="list_view" id="list_view_list" value="list" <?php echo $formchecked; ?>>
                                    <label class="form-check-label" for="list_view_list"><i class="bi bi-list"></i> <?php echo $setUp->getString("list"); ?></label>
                                </div>
                            </div>
                        
                            <div class="col-12 mb-2">
                                <?php $formchecked = $setUp->getConfig('inline_thumbs') ? ' checked' : ''; ?>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" role="switch" type="checkbox" name="inline_thumbs" id="inline_thumbs" <?php echo $formchecked; ?>>
                                    <label class="form-check-label" for="inline_thumbs"><i class="bi bi-grid-3x2-gap"></i> <?php print $setUp->getString("inline_thumbs"); ?></label>
                                </div>
                            </div>
                            <div class="col-12 mb-2 toggle">
                                <?php $formchecked = $setUp->getConfig('thumbnails') ? ' checked' : ''; ?>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" role="switch" type="checkbox" name="thumbnails" id="thumbnails" <?php echo $formchecked; ?>>
                                    <label class="form-check-label" for="thumbnails"><i class="bi bi-aspect-ratio"></i> <?php print $setUp->getString("can_thumb"); ?></label>
                                </div>
                            </div>

                            <div class="col-12 toggled mb-2">
                                <div class="row">
                                    <div class="form-group col-xs-6 mb-3">
                                        <label class="form-label"><?php echo $setUp->getString("max_width"); ?></label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" name="thumbnails_width" placeholder="760" value="<?php echo $setUp->getConfig('thumbnails_width'); ?>">
                                            <span class="input-group-text">px</span>
                                        </div>
                                    </div>
                                    <div class="form-group col-xs-6 mb-3">
                                        <label class="form-label"><?php echo $setUp->getString("max_height"); ?></label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" name="thumbnails_height" placeholder="800" value="<?php echo $setUp->getConfig('thumbnails_height'); ?>">
                                            <span class="input-group-text">px</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="btn btn-primary regen-thumb mb-2"><?php echo $setUp->getString("regenerate_thumbnails"); ?> <span class="place-icon"></span></div>
                            </div>

                            <div class="col-12 mb-2">
                                <?php $formchecked = $setUp->getConfig('show_search') ? ' checked' : ''; ?>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" role="switch" type="checkbox" name="show_search" id="show_search" <?php echo $formchecked; ?>>
                                    <label class="form-check-label" for="show_search"><i class="bi bi-search"></i> <?php print $setUp->getString("show_search"); ?></label>
                                </div>
                            </div>

                            <div class="col-12 mb-2">
                                <?php $formchecked = $setUp->getConfig('playmusic') ? ' checked' : ''; ?>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" role="switch" type="checkbox" name="playmusic" id="playmusic" <?php echo $formchecked; ?>>
                                    <label class="form-check-label" for="playmusic"><i class="bi bi-music-note-beamed"></i> <?php print $setUp->getString("mp3_player"); ?></label>
                                </div>
                            </div>

                            <div class="col-12 mb-2">
                                <?php $formchecked = $setUp->getConfig('playvideo') ? ' checked' : ''; ?>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" role="switch" type="checkbox" name="playvideo" id="playvideo" <?php echo $formchecked; ?>>
                                    <label class="form-check-label" for="playvideo"><i class="bi bi-film"></i> <?php print $setUp->getString("video_player"); ?></label>
                                </div>
                            </div>
                        </div>
                    </div> <!-- col-sm-6 LEFT -->

                    <div class="col-sm-6">

                        <div class="row">
                            <div class="col-12 mb-2">
                                <h4><i class="bi bi-files"></i> <?php echo $setUp->getString("files"); ?></h4>
                            </div>
                            <div class="col-12 mb-2">
                                <?php 
                                $filedeforder = $setUp->getConfig('filedeforder', 'date');
                                $formchecked = $filedeforder == 'alpha' ? ' checked' : ''; ?>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="filedeforder" id="filedeforder_alpha" value="alpha" <?php echo $formchecked; ?>>
                                    <label class="form-check-label" for="filedeforder_alpha"><i class="bi bi-sort-alpha-down"></i> <?php echo $setUp->getString("file_name"); ?></label>
                                </div>
                                <?php $formchecked = $filedeforder == 'date' ? ' checked' : ''; ?>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="filedeforder" id="filedeforder_date" value="date" <?php echo $formchecked; ?>>
                                    <label class="form-check-label" for="filedeforder_date"><i class="bi bi-calendar-event"></i> <?php echo $setUp->getString("last_changed"); ?></label>
                                </div>
                                <?php $formchecked = $filedeforder == 'size' ? ' checked' : ''; ?>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="filedeforder" id="filedeforder_size" value="size" <?php echo $formchecked; ?>>
                                    <label class="form-check-label" for="filedeforder_size"><i class="bi bi-speedometer"></i> <?php echo $setUp->getString("size"); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="row toggle">
                            <div class="col-12 mb-2">
                                <?php $formchecked = $setUp->getConfig('show_pagination') ? ' checked' : ''; ?>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" role="switch" type="checkbox" name="show_pagination" id="show_pagination" <?php echo $formchecked; ?>>
                                    <label class="form-check-label" for="show_pagination">
                                        <i class="bi bi-chevron-double-left"></i> 
                                        <i class="bi bi-chevron-left"></i> 
                                        <i class="bi bi-chevron-right"></i> 
                                        <i class="bi bi-chevron-double-right"></i> 
                                        <?php echo $setUp->getString("show_pagination"); ?>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row toggled">
                            <div class="col-12 mb-2">
                                <?php $formchecked = $setUp->getConfig('show_pagination_num') ? ' checked' : ''; ?>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" role="switch" type="checkbox" name="show_pagination_num" id="show_pagination_num" <?php echo $formchecked; ?>>
                                    <label class="form-check-label" for="show_pagination_num"><i class="bi bi-chevron-double-left"></i>..2..<i class="bi bi-chevron-double-right"></i> <?php echo $setUp->getString("show_pagination_num"); ?></label>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <?php
                                $filedefnum = $setUp->getConfig('filedefnum', 25);
                                $formchecked = $filedefnum == 10 ? ' checked' : ''; ?>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="filedefnum" id="filedefnum_10" value="10" <?php echo $formchecked; ?>>
                                    <label class="form-check-label" for="filedefnum_10">10</label>
                                </div>
                                <?php $formchecked = $filedefnum == 25 ? ' checked' : ''; ?>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="filedefnum" id="filedefnum_25" value="25" <?php echo $formchecked; ?>>
                                    <label class="form-check-label" for="filedefnum_25">25</label>
                                </div>
                                <?php $formchecked = $filedefnum == 50 ? ' checked' : ''; ?>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="filedefnum" id="filedefnum_50" value="50" <?php echo $formchecked; ?>>
                                    <label class="form-check-label" for="filedefnum_50">50</label>
                                </div>
                                <?php $formchecked = $filedefnum == 100 ? ' checked' : ''; ?>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="filedefnum" id="filedefnum_100" value="100" <?php echo $formchecked; ?>>
                                    <label class="form-check-label" for="filedefnum_100">100</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-4">
                                <?php $formchecked = $setUp->getConfig('show_hidden_files') ? ' checked' : ''; ?>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" role="switch" type="checkbox" name="show_hidden_files" id="show_hidden_files" <?php echo $formchecked; ?>>
                                    <label class="form-check-label" for="show_hidden_files"><i class="bi bi-file-earmark"></i> .<?php print $setUp->getString("show_hidden_files"); ?></label>
                                </div>
                            </div>

                            <div class="col-12 mb-2">
                                <h4><i class="bi bi-folder"></i> <?php echo $setUp->getString("folders"); ?></h4>
                            </div>

                            <div class="col-12 mb-2">
                                <?php
                                $folderdeforder = $setUp->getConfig('folderdeforder', 'alpha');
                                $formchecked = $folderdeforder == 'alpha' ? ' checked' : ''; ?>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="folderdeforder" id="folderdeforder_alpha" value="alpha" <?php echo $formchecked; ?>>
                                    <label class="form-check-label" for="folderdeforder_alpha"><i class="bi bi-sort-alpha-down"></i> <?php echo $setUp->getString("file_name"); ?></label>
                                </div>
                                <?php $formchecked = $folderdeforder == 'date' ? ' checked' : ''; ?>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="folderdeforder" id="folderdeforder_date" value="date" <?php echo $formchecked; ?>>
                                    <label class="form-check-label" for="folderdeforder_date"><i class="bi bi-calendar-event"></i> <?php echo $setUp->getString("last_changed"); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="row toggle mb-2">
                            <div class="col-sm-12">
                                <?php $formchecked = $setUp->getConfig('show_pagination_folders') ? ' checked' : ''; ?>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" role="switch" type="checkbox" name="show_pagination_folders" id="show_pagination_folders" <?php echo $formchecked; ?>>
                                    <label class="form-check-label" for="show_pagination_folders"><i class="bi bi-search"></i> 
                                        <i class="bi bi-chevron-left"></i> <i class="bi bi-folder"></i> 
                                        <i class="bi bi-chevron-right"></i> <?php print $setUp->getString("show_pagination_folders"); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="row toggled">
                            <div class="col-sm-12 mb-2">
                                <?php $formchecked = $setUp->getConfig('show_pagination_num_folder') ? ' checked' : ''; ?>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" role="switch" type="checkbox" name="show_pagination_num_folder" id="show_pagination_num_folder" <?php echo $formchecked; ?>>
                                    <label class="form-check-label" for="show_pagination_num_folder"><i class="bi bi-chevron-double-left"></i>..2..<i class="bi bi-chevron-double-right"></i> <?php print $setUp->getString("show_pagination_num"); ?></label>
                                </div>
                            </div>
                
                            <div class="col-12 mb-2">
                                <?php
                                $folderdefnum = $setUp->getConfig('folderdefnum', 10);
                                $formchecked = $folderdefnum == 5 ? ' checked' : ''; ?>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="folderdefnum" id="folderdefnum_5" value="5" <?php echo $formchecked; ?>>
                                    <label class="form-check-label" for="folderdefnum25">5</label>
                                </div>
                                <?php $formchecked = $folderdefnum == 10 ? ' checked' : ''; ?>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="folderdefnum" id="folderdefnum_10" value="10" <?php echo $formchecked; ?>>
                                    <label class="form-check-label" for="folderdefnum_10">10</label>
                                </div>
                                <?php $formchecked = $folderdefnum == 25 ? ' checked' : ''; ?>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="folderdefnum" id="folderdefnum_25" value="25" <?php echo $formchecked; ?>>
                                    <label class="form-check-label" for="folderdefnum25">25</label>
                                </div>
                                <?php $formchecked = $folderdefnum == 50 ? ' checked' : ''; ?>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="folderdefnum" id="folderdefnum_50" value="50" <?php echo $formchecked; ?>>
                                    <label class="form-check-label" for="folderdefnum_50">50</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 mb-2">
                                <?php $formchecked = $setUp->getConfig('show_folder_counter') ? ' checked' : ''; ?>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" role="switch" type="checkbox" name="show_folder_counter" id="show_folder_counter" <?php echo $formchecked; ?>>
                                    <label class="form-check-label" for="show_folder_counter"><span class="badge d-none d-sm-inline-block rounded-pill bg-light text-dark">
                                            <i class="bi bi-folder"></i> 0
                                        </span>
                                        <span class="badge d-none d-sm-inline-block rounded-pill bg-light text-dark">
                                            <i class="bi bi-files"></i> 0
                                        </span>
                                        <?php echo $setUp->getString("counter"); ?></label>
                                </div>
                            </div>

                            <div class="col-sm-12 mb-2">
                                <?php $formchecked = $setUp->getConfig('download_dir_enable') ? ' checked' : ''; ?>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" role="switch" type="checkbox" name="download_dir_enable" id="download_dir_enable" <?php echo $formchecked; ?>>
                                    <label class="form-check-label" for="download_dir_enable"><i class="bi bi-folder2-open"></i> <i class="bi bi-chevron-double-right"></i> <i class="bi bi-file-earmark-zip"></i>
                                    <?php echo $setUp->getString("folders_download"); ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- box-body -->
            </div>
        </div> <!-- box -->
    </div> <!-- col -->
</div> <!-- row -->
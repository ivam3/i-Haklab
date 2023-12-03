<hr>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <span><?php echo $setUp->getString("users"); ?></span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="data-users" class="table table-hover table-condense">
                        <thead>
                            <tr>
                                <th><span class="sorta nowrap">ID</span></th>
                                <th><span class="sorta nowrap"><?php echo $setUp->getString("username"); ?></span></th>
                                <th><span class="sorta nowrap"><?php echo $setUp->getString("role"); ?></span></th>
                                <th><span class="sorta nowrap"><?php echo $setUp->getString("email"); ?></span></th>
                                <th><span class="nowrap"><?php echo $setUp->getString("user_folder"); ?></span></th>
                                <th><span class="nowrap"><?php echo $setUp->getString("available_space"); ?></span></th>
                                <th></th>
                                <th></th>
                                <?php
                                if (is_array($customfields)) {
                                    foreach ($customfields as $customkey => $customfield) {
                                        if (isset($customfield['list']) && $customfield['list'] === true) {
                                            ?>
                                            <th><span class="sorta nowrap"><?php echo $customfield['name']; ?></span></th>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            /**
                             * LIST USERS
                             */
                            foreach ($utenti as $key => $user) {
                                $usermail = isset($user['email']) ? $user['email'] : '';
                                $userdirs = isset($user['dir']) ? json_decode($user['dir'], true) : false;
                                $disabled = isset($user['disabled']) ? $user['disabled'] : false;
                                $disabledLabel = $disabled ? '<span class="badge rounded-pill bg-danger">'.$setUp->getString("disabled").'</span>' : '';
                                $userquota = ($userdirs && isset($user['quota'])) ? $user['quota'] : '';
                                $printquota = strlen($userquota) > 0 ? $setUp->formatSize(($userquota*1024*1024)) : '';
                                $listuserdirs = false;
                                $gooduserdirs = false;
                                if ($userdirs) {
                                    $gooduserdirs = array();
                                    foreach ($userdirs as $dir) {
                                        if (in_array($dir, $availableFolders)) {
                                            array_push($gooduserdirs, $dir);
                                        }
                                    }
                                    $countuserdirs = count($gooduserdirs);

                                    $listuserdirs = '('.$countuserdirs.')';

                                    if ($countuserdirs === 1) {
                                        $usrbasedir = str_replace('./', '', $setUp->getConfig('starting_dir'));
                                        $listuserdirs = '<a target="_blank" href="'.$setUp->getConfig('script_url').'?dir='.$usrbasedir.$userdirs[0].'">'.$userdirs[0].'</a>';
                                    }
                                } ?>
                            <tr class="userrow">
                                <td><?php echo $key; ?></td>
                                <td><a class="usrblock" href="#" data-bs-toggle="modal" data-bs-target="#modaluser"><?php echo GateKeeper::getAvatar($user['name'], ''); ?> <?php echo $user['name']; ?></a></td>
                                <td><em><?php echo $setUp->getString("role_".$user['role']); ?></em></td>
                                <td><?php echo $usermail; ?></td>
                                <td><?php echo $listuserdirs; ?></td>
                                <td><?php echo $printquota; ?></td>
                                <td><?php echo $disabledLabel; ?></td>
                                <td>
                                    <button class="btn btn-link btn-sm py-0 usrblock" data-bs-toggle="modal" data-bs-target="#modaluser"><i class="bi bi-pencil-square"></i></button>
                                <?php
                                foreach ($user as $attr => $value) {
                                    if ($attr !== 'dir' && $attr !== 'pass') { ?>
                                    <input type="hidden" data-key="<?php echo $attr; ?>" value='<?php echo $value; ?>' class="send-userdata">
                                        <?php
                                    }
                                }
                                if ($gooduserdirs) {
                                    foreach ($gooduserdirs as $dir) { ?>
                                        <input type="hidden" value="<?php echo $dir; ?>" class="s-userfolders">
                                        <?php
                                    }
                                } ?>
                                </td>
                                <?php
                                if (is_array($customfields)) {
                                    foreach ($customfields as $customkey => $customfield) {
                                        if (isset($customfield['list']) && $customfield['list'] === true) {
                                            if (isset($customfield['multiple'])) {
                                                $customval = isset($user[$customkey]) ? implode(', ', json_decode($user[$customkey])) : '';
                                            } else {
                                                $customval = isset($user[$customkey]) ? $user[$customkey] : '';
                                            }
                                            ?>
                                            <td><?php echo $customval; ?></td>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                            </tr>
                                <?php
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    $('.avadefault').initial({fontWeight:200,seed:13});
    $('#data-users').DataTable({
        dom        : '<"table-controls-top"fl>rt<"table-controls-bottom"ip>',
        lengthMenu : [[25, 50, 100], [25, 50, 100]],
        order      : [[ 0, 'desc' ]],
        language : {
            emptyTable     : '--',
            info           : '_START_-_END_ / _TOTAL_ ',
            infoEmpty      : '',
            infoFiltered   : '',
            infoPostFix    : '',
            lengthMenu     : ' _MENU_',
            loadingRecords : '<div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div>',
            processing     : '<div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div>',
            search         : '<i class="bi bi-search"></i> ',
            zeroRecords    : '--',
            paginate : {
                first    : '<i class="bi bi-chevron-double-left"></i>',
                last     : '<i class="bi bi-chevron-double-right"></i>',
                previous : '<i class="bi bi-chevron-left"></i>',
                next     : '<i class="bi bi-chevron-right"></i>'
            }
        },
        columnDefs : [ 
            { 
                targets : [ 0 ], 
                searchable : false
            },
            { 
                targets : [2, 4, 5, 6, 7], 
                orderable  : false,
                searchable : false
            }
        ],

        initComplete : function() {
            $('#data-users_wrapper div.dataTables_length').addClass('ms-auto');
            $('#data-users_wrapper .table-controls-top').addClass('d-flex w-100 mb-3');
            $('#data-users_wrapper .table-controls-bottom').addClass('d-flex w-100');
            $('#data-users_wrapper .dataTables_paginate').addClass('ms-auto');
        }

    });
});
</script>

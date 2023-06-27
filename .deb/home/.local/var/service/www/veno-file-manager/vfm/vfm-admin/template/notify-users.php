<?php
/**
 * VFM - veno file manager: template/notify-users.php
 *
 * List users with access to current folder
 * and an e-mail addres associated to select and notify uploads
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
if ($location->editAllowed() && $gateKeeper->isAllowed('upload_enable')) {
    $usercount = 0;

    if ($setUp->getConfig('upload_notification_enable') == true && $gateKeeper->getUserInfo('email') !== null) {
        $notificables = array();
        foreach ($_USERS as $user) {
            $showuser = false;
            if (isset($user['email']) && strlen($user['email']) >= 5
                && $user['name'] !== $gateKeeper->getUserInfo('name')
            ) {
                if (isset($user['dir']) && strlen($user['dir']) >= 1) {
                    $userpatharray = array();
                    $userpatharray = json_decode($user['dir']);
                    $startdir = SetUp::getConfig('starting_dir');

                    foreach ($userpatharray as $value) {
                        $userpath = $startdir.$value."/";
                        $pos = strpos($location->getDir(true, false, false, 0), $userpath);
                        if ($pos !== false) {
                            $showuser = true;
                            break;
                        }
                    }
                } else {
                    $showuser = true;
                }
                if ($showuser === true) {
                    $notificable = array();
                    $notificable['email'] = $user['email'];
                    $notificable['name'] = $user['name'];

                    // show email only to SuperAdmins
                    $notificable['showmail'] = ($gateKeeper->isSuperAdmin() ? "<small>(".$notificable['email'].")</small>" : "");
                    
                    array_push($notificables, $notificable);
                    $usercount++;
                }
            }
        }
    }
    if ($usercount > 0) { ?>
            <?php
                // select all by default

                // <script type="text/javascript">
                //     $(document).ready(function (e) {
                //         $('.selectme').prop('checked', true);
                //         checkNotiflist();
                //     });
                // </script>
            ?>
            <div class="col-12">
            <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#userslistmodal">
                <i class="bi bi-circle check-notif"></i> <?php echo $setUp->getString("upload_notifications"); ?> 
            </button>
            </div>
        <?php
    } ?>
            <div class="modal fade" id="userslistmodal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <p class="modal-title"><?php echo $setUp->getString("notify_users"); ?></p>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
        <?php
        if ($usercount > 0) {  ?>
                            <a class="selectallusers" href="#"><i class="bi bi-check-all"></i> <?php echo $setUp->getString("select_all"); ?></a>
                            <form class="form" id="userslist">
                                <input type="hidden" name="thislang" value="<?php echo $setUp->lang; ?>">
                                <input type="hidden" name="path" value="<?php echo urlencode($location->getDir(true, false, false, 0)); ?>">
                                <div class="mb-3">
            <?php
            foreach ($notificables as $key => $notifuser) { ?>
                                <div class="form-check">
                                    <input class="selectme form-check-input" type="checkbox" name="senduser[]" value="<?php echo $notifuser['email']; ?>" id="senduser-<?php echo $key; ?>">
                                    <label class="form-check-label" for="senduser-<?php echo $key; ?>">
                                        <?php echo '<span class="badge rounded-pill bg-primary">'.$notifuser['name'].'</span> '.$notifuser['showmail']; ?>
                                    </label>
                                </div>
                <?php
            } ?>
                                </div>
                                <h5><?php echo $setUp->getString("message"); ?></h5>
                                <textarea class="form-control" name="uploader_message"></textarea>
                            </form>
            <?php
        } ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userslistmodal">
                            <?php echo $setUp->getString("close"); ?> 
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php
}

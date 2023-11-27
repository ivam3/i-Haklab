<?php
/**
 * VFM - veno file manager: include/activate.php
 * Activate new pending user
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
$regactive = filter_input(INPUT_GET, "act", FILTER_UNSAFE_RAW);
if ($regactive && $setUp->getConfig("registration_enable") == true) :

    if (file_exists('vfm-admin/_content/users/users-new.php')) {
        include 'vfm-admin/_content/users/users-new.php';

        global $users;
        global $newusers;
        
        $registration_lifetime = $setUp->getConfig('registration_lifetime', '-1 day');
        $lifetime = date("Y-m-d-H-i-s", strtotime($registration_lifetime));

        $newusers = $updater->removeOldReg($newusers, 'date', $lifetime);
        $newuser = $updater->findUserKey($regactive);

        if ($newuser !== false) {
            $username = $newuser['name'];
            $usermail = $newuser['email'];

            if ($updater->findUser($username) === false && $updater->findUser($usermail, true) === false) {
                array_push($users, $newuser);
                $updater->updateUserFile('new');
            } else {
                Utils::setError('<strong>'.$username.'</strong> '.$setUp->getString('file_exists'));
            }

            // Clean current confirmed user.
            $newusers = $updater->removeUserFromValue($newusers, 'name', $username);
            $newusers = $updater->removeUserFromValue($newusers, 'email', $usermail);

            if ($updater->updateRegistrationFile($newusers, 'vfm-admin/_content/users/')) {
                Utils::setSuccess($setUp->getString("registration_completed"));

                // Send new registration log to administrator.
                if (strlen(SetUp::getConfig('upload_email')) > 5 && SetUp::getConfig('notify_registration')) {
                
                    $time = SetUp::formatModTime(time());
                    $title = $setUp->getString('new_user_has_been_created');
                    $appname = SetUp::getConfig('appname');

                    $message = $time."\n\n";
                    $message .= "IP   : ".Logger::getClientIP()."\n";
                    $message .= $setUp->getString('user')." : ".$username."\n";
                    $message .= $setUp->getString('email')." : ".$usermail."\n";

                    $sendTo = SetUp::getConfig('upload_email');
                    $from = "=?UTF-8?B?".base64_encode($appname)."?=";
                    mail(
                        $sendTo,
                        "=?UTF-8?B?".base64_encode($title)."?=",
                        $message,
                        "Content-type: text/plain; charset=UTF-8\r\n".
                        "From: ".$from." <noreply@{$_SERVER['SERVER_NAME']}>\r\n".
                        "Reply-To: ".$from." <noreply@{$_SERVER['SERVER_NAME']}>"
                    );
                }

            } else {
                Utils::setWarning('failed updating registration file');
            }
        } else {
            Utils::setError($setUp->getString('link_expired'));
        }
    }
endif;

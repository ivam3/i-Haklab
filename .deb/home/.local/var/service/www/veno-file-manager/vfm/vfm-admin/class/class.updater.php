<?php
/**
 * Controls single user update panel
 *
 * @category PHP
 * @package  VenoFileManager
 * @author   Nicola Franchini <info@veno.it>
 * @license  Exclusively sold on CodeCanyon
 * @link     http://filemanager.veno.it/
 */
if (!class_exists('Updater', false)) {
    /**
     * Class Updater
     *
     * @category PHP
     * @package  VenoFileManager
     * @author   Nicola Franchini <info@veno.it>
     * @license  Exclusively sold on CodeCanyon
     * @link     http://filemanager.veno.it/
     */
    class Updater
    {
        /**
         * Call update user functions
         *
         * @return $message
         */
        public function init()
        {
            global $updater;

            $posteditname = filter_input(INPUT_POST, 'user_new_name', FILTER_UNSAFE_RAW);
            $postoldname = filter_input(INPUT_POST, 'user_old_name', FILTER_UNSAFE_RAW);
            $posteditpass = filter_input(INPUT_POST, 'user_new_pass', FILTER_UNSAFE_RAW);
            $posteditpasscheck = filter_input(INPUT_POST, 'user_new_pass_confirm', FILTER_UNSAFE_RAW);
            $postoldpass = filter_input(INPUT_POST, 'user_old_pass', FILTER_UNSAFE_RAW);
            $posteditmail = filter_input(INPUT_POST, 'user_new_email', FILTER_VALIDATE_EMAIL);
            $postoldmail = filter_input(INPUT_POST, 'user_old_email', FILTER_VALIDATE_EMAIL);

            if ($postoldpass && $posteditname) {
                $updater->updateUser(
                    $posteditname,
                    $postoldname,
                    $posteditpass,
                    $posteditpasscheck,
                    $postoldpass,
                    $posteditmail,
                    $postoldmail
                );
            }
        }

        /**
         * Update users file
         *
         * @param string $path relative path to /users/
         *
         * @return file updated
         */
        public function updateUsers($path = '_content/users/')
        {
            global $users;
            $usrs = '$_USERS = ';

            if (false === (file_put_contents($path.'users.php', "<?php\n\n $usrs".var_export($users, true).";\n"))) {
                Utils::setError('Error writing on '.$path.'users.php, check CHMOD');
            }
        }

        /**
         * Update user profile
         *
         * @param string $posteditname      new username
         * @param string $postoldname       current username
         * @param string $posteditpass      new password
         * @param string $posteditpasscheck check password
         * @param string $postoldpass       old password
         * @param string $posteditmail      new email
         * @param string $postoldmail       old email
         *
         * @return global $users updated
         */
        public function updateUser(
            $posteditname,
            $postoldname,
            $posteditpass,
            $posteditpasscheck,
            $postoldpass,
            $posteditmail,
            $postoldmail
        ) {
            global $setUp;
            global $updater;
            global $_USERS;
            global $users;
            $users = $_USERS;
            $passa = true;

            if (GateKeeper::isUser($postoldname, $postoldpass)) {
                // Update Username.
                if ($posteditname != $postoldname) {
                    if ($updater->findUser($posteditname)) {
                            Utils::setError('<span><strong>'.$posteditname.'</strong> '.$setUp->getString('file_exists').'</span>');
                            $passa = false;
                            return;
                    }
                    GateKeeper::removeCookie($postoldname);
                    Updater::updateAvatar($postoldname, $posteditname);
                    $updater->updateUserData($postoldname, 'name', $posteditname);
                }
                // Update e-mail.
                if ($posteditmail != $postoldmail) {
                    if ($updater->findUser($posteditmail, true)) {
                            Utils::setError('<span><strong>'.$posteditmail.'</strong> '.$setUp->getString('file_exists').'</span>');
                            $passa = false;
                            return;
                    }
                    $updater->updateUserData($postoldname, 'email', $posteditmail);
                }
                // Update password.
                if ($posteditpass) {
                    if ($posteditpass === $posteditpasscheck) {
                        $updater->updateUserPwd($postoldname, $posteditpass);
                    } else {
                        Utils::setError($setUp->getString('wrong_pass'));
                        $passa = false;
                        return;
                    }
                }

                // Update custom fields
                $jcustomfields = isset($_POST['user-customfields']) ? $_POST['user-customfields'] : false;
                if ($jcustomfields) {
                    $customfields = json_decode($jcustomfields, true);
                    foreach ($customfields as $customkey => $customfield) {
                        $cleanfield = false;
                        if ($customfield['type'] == 'email') {
                            $cleanfield = filter_input(INPUT_POST, $customkey, FILTER_VALIDATE_EMAIL);
                        } else {
                            $cleanfield = filter_input(INPUT_POST, $customkey, FILTER_UNSAFE_RAW);
                        }
                        if ($cleanfield) {
                            $updater->updateUserData($postoldname, $customkey, $cleanfield);
                        }
                    }
                }

                if ($passa == true) {
                    $updater->updateUserFile('', $posteditname);
                }
            } else {
                Utils::setError($setUp->getString('wrong_pass'));
            }
        }

        /**
         * Update user password
         *
         * @param string $checkname  username
         * @param string $changepass new pass
         *
         * @return global $users updated
         */
        public function updateUserPwd($checkname, $changepass)
        {
            global $_USERS;
            global $users;
            $utenti = $_USERS;

            foreach ($utenti as $key => $value) {
                if (strtolower($value['name']) === strtolower($checkname)) {
                    $salt = SetUp::getConfig('salt');
                    $users[$key]['pass'] = crypt($salt.urlencode($changepass), Utils::randomString());
                    break;
                }
            }
        }

        /**
         * Update user data
         *
         * @param string $checkname username to find
         * @param string $type      info to change
         * @param string $changeval new value
         *
         * @return global $users updated
         */
        public function updateUserData($checkname, $type, $changeval)
        {
            global $_USERS;
            global $users;
            $users = isset($users) ? $users : $_USERS;

            foreach ($_USERS as $key => $value) {
                if (strtolower($value['name']) === strtolower($checkname)) {
                    if ($changeval) {
                        $users[$key][$type] = $changeval;
                    } else {
                        unset($users[$key][$type]);
                    }
                    break;
                }
            }
        }

        /**
         * Update user Avatar if user changes name or delete it
         *
         * @param string $checkname username to find
         * @param string $newname   new username to assign
         * @param string $dir       relative path to /_content/avatars/
         *
         * @return avatar updated
         */
        public static function updateAvatar($checkname = false, $newname = false, $dir = 'vfm-admin/')
        {
            $avatars = glob($dir.'_content/avatars/*.png');
            $filename = md5($checkname);

            foreach ($avatars as $avatar) {

                $fileinfo = Utils::mbPathinfo($avatar);
                $avaname = $fileinfo['filename'];

                if ($avaname === $filename) {
                    
                    if ($newname) {
                        $newname = md5($newname);
                        rename($dir.'_content/avatars/'.$avaname.'.png', $dir.'_content/avatars/'.$newname.'.png');
                    } else {
                        unlink($dir.'_content/avatars/'.$avaname.'.png');
                    }
                    break;
                }
            }
        }

        /**
         * Delete user
         *
         * @param string $checkname username to find
         *
         * @return global $users updated
         */
        public function deleteUser($checkname)
        {
            global $_USERS;
            global $users;
            $utenti = $_USERS;

            foreach ($utenti as $key => $value) {
                if (strtolower($value['name']) === strtolower($checkname)) {
                    unset($users[$key]);
                    GateKeeper::removeCookie($checkname, '');
                    Updater::updateAvatar($checkname, false, '');
                    break;
                }
            }
        }

        /**
         * Look if user exists
         *
         * @param string $userdata username or email to look for
         * @param bool   $email    false or true to search email
         *
         * @return true/false
         */
        public function findUser($userdata, $email = false)
        {
            global $_USERS;

            $attr = $email ? 'email' : 'name';

            if (is_array($_USERS)) {
                foreach ($_USERS as $value) {
                    if (isset($value[$attr])) {
                        if (strtolower($value[$attr]) === strtolower($userdata)) {
                            return true;
                        }
                    }
                }
            }
            return false;
        }

        /**
         * Look if pre-registered user exists
         *
         * @param string $userdata username or email to look for
         * @param bool   $email    false or true to search email
         *
         * @return true/false
         */
        public function findUserPre($userdata, $email = false)
        {
            global $newusers;

            $attr = $email ? 'email' : 'name';

            if (is_array($newusers)) {
                foreach ($newusers as $preuser) {
                    if (isset($preuser[$attr])) {
                        if (strtolower($preuser[$attr]) === strtolower($userdata)) {
                            return $preuser;
                            // return true;
                        }
                    }
                }
            }
            return false;
        }

        /**
         * Get user by activation key from users-new.php
         * prepare it for users.php
         * and create his custom dir if requested
         *
         * @param string $userdata username to look for
         *
         * @return $thisuser array or false
         */
        public function findUserKey($userdata)
        {
            global $newusers;
            $utenti = array();
            $utenti = $newusers;
            $defaultfolders = SetUp::getConfig('registration_user_folders');

            if (!empty($utenti)) {
                foreach ($utenti as $utente) {
                    if ($utente['key'] === $userdata) {
                        $thisuser = array();
                        foreach ($utente as $attrkey => $userattr) {
                            $thisuser[$attrkey] = $userattr;
                        }
                        $thisuser['role'] = SetUp::getConfig('registration_role');

                        if ($defaultfolders) {
                            $arrayfolders = json_decode($defaultfolders, false);

                            if (in_array('vfm_reg_new_folder', $arrayfolders)) {
                                
                                $userfolderpath = $thisuser['name'];

                                $newpath = SetUp::getConfig('starting_dir').$userfolderpath;

                                if (!is_dir($newpath)) {
                                    mkdir($newpath);
                                }

                                $arrayfolders = array_diff($arrayfolders, array('vfm_reg_new_folder'));
                                $arrayfolders[] = $userfolderpath;
                                $userdir = json_encode(array_values($arrayfolders));
                            } else {
                                $userdir = $defaultfolders;
                            }

                            $thisuser['dir'] = $userdir;
                            if (strlen(SetUp::getConfig('registration_user_quota')) > 0) {
                                $thisuser['quota'] = SetUp::getConfig('registration_user_quota');
                            }
                        }
                        unset($thisuser['key']);
                        return $thisuser;
                    }
                }
            }
            return false;
        }

        /**
         * Update users file
         *
         * @param string $option   what has been updated
         * @param string $postname username updated
         *
         * @return response
         */
        public function updateUserFile($option = '', $postname = false)
        {
            global $setUp;
            global $users;
            $usrs = '$_USERS = ';

            if (false === (file_put_contents(
                'vfm-admin/_content/users/users.php',
                "<?php\n\n $usrs".var_export($users, true).";\n"
            ))
            ) {
                Utils::setError('error updating users list');
            } else {
                if ($option == 'password') {
                    Utils::setSuccess($setUp->getString('password_reset'));
                } else {
                    if ($postname) {
                        $edited = '<strong>'.$postname.'</strong> ';
                        Utils::setSuccess($edited.$setUp->getString('updated'));
                    }
                }
                $_SESSION['vfm_user_name'] = null;
                $_SESSION['vfm_logged_in'] = null;
                $_SESSION['vfm_user_space'] = null;
                $_SESSION['vfm_user_used'] = null;
                $_SESSION['vfm_user_name_new'] = null;
                session_destroy();
            }
        }

        /**
         * Prepare registration user
         *
         * @param array $newusers new users list
         * @param array $path     relative path to file
         *
         * @return response
         */
        public function updateRegistrationFile($newusers, $path = '')
        {
            $usrs = '$newusers = ';

            if (false == (file_put_contents(
                $path.'users-new.php',
                "<?php\n\n $usrs".var_export($newusers, true).";\n"
            ))
            ) {
                return false;
            } else {
                return true;
            }
        }

        /**
         * Remove user from value
         *
         * @param array  $array array where to search
         * @param key    $key   key to search
         * @param string $value vluue to search
         *
         * @return null/$new_image
         */
        public function removeUserFromValue($array, $key, $value)
        {
            foreach ($array as $subKey => $subArray) {
                if ($subArray[$key] == $value) {
                    unset($array[$subKey]);
                }
            }
            return $array;
        }

        /**
         * Remove old standby registrations
         *
         * @param array  $newusers array where to search
         * @param key    $key      key to search
         * @param string $lifetime max lifetime
         *
         * @return null/$new_image
         */
        public function removeOldReg($newusers, $key, $lifetime)
        {
            foreach ($newusers as $subKey => $subArray) {
                $data = $subArray[$key];

                if ($data <= $lifetime) {
                    unset($newusers[$subKey]);
                    $this->updateRegistrationFile($newusers, 'vfm-admin/users/');
                }
            }
            return $newusers;
        }

        /**
         * Update .htaccess
         *
         * @param string  $starting_dir selected uploads directory
         * @param boolean $direct_links give or not the access
         *
         * @return void
         */
        public function updateHtaccess($starting_dir, $direct_links = false)
        {
            $htaccess = '.'.$starting_dir.".htaccess";

            $start_marker = "# begin VFM rules";
            $end_marker   = "# end VFM rules";

            // Split out the existing file into the preceeding lines, and those that appear after the marker
            $pre_lines = $post_lines = $existing_lines = array();

            $found_marker = $found_end_marker = false;

            if (file_exists($htaccess)) {
                $hta = file_get_contents($htaccess);  // Read the whole .htaccess file into mem
                $lines = explode(PHP_EOL, $hta); // Use newline to differentiate between records

                foreach ($lines as $line) {
                    if (!$found_marker && false !== strpos($line, $start_marker)) {
                        $found_marker = true;
                        continue;
                    } elseif (!$found_end_marker && false !== strpos($line, $end_marker) ) {
                        $found_end_marker = true;
                        continue;
                    }
                    if (!$found_marker) {
                        $pre_lines[] = $line;
                    } elseif ($found_marker && $found_end_marker) {
                        $post_lines[] = $line;
                    } else {
                        $existing_lines[] = $line;
                    }
                }
            }

            $insertion = array();
            if ($starting_dir !== './') {

                $insertion[] = "<Files \"*.php\">";
                $insertion[] = " SetHandler none";
                $insertion[] = " SetHandler default-handler";
                $insertion[] = " Options -ExecCGI";
                $insertion[] = " RemoveHandler .php";
                $insertion[] = "</Files>";
                $insertion[] = "<IfModule mod_php5.c>";
                $insertion[] = " php_flag engine off";
                $insertion[] = "</IfModule>";

                if (!$direct_links) {
                    $insertion[] = "Order Deny,Allow";
                    $insertion[] = "Deny from all";
                }
            }
            // Check to see if there was a change
            if ($existing_lines === $insertion) {
                return true;
            }
            // Generate the new file data
            $new_file_data = implode(
                "\n", array_merge(
                    $pre_lines,
                    array( $start_marker ),
                    $insertion,
                    array( $end_marker ),
                    $post_lines
                )
            );
            $fpp = fopen($htaccess, "w+");
            if ($fpp === false) {
                return false;
            }
            fwrite($fpp, $new_file_data);
            fclose($fpp);
            return true;
        }

        /**
         * Clear php cache
         *
         * @param string $path file path
         *
         * @return void
         */
        public function clearCache($path)
        {
            if (function_exists('opcache_invalidate') && strlen(ini_get("opcache.restrict_api")) < 1) {
                opcache_invalidate($path, true);
            } elseif (function_exists('apc_compile_file')) {
                apc_compile_file($path);
            }
        }

    }
}

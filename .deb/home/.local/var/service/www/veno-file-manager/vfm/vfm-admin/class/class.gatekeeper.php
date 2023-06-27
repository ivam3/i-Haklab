<?php
/**
 * Control authentication
 *
 * @category PHP
 * @package  VenoFileManager
 * @author   Nicola Franchini <info@veno.it>
 * @license  Exclusively sold on CodeCanyon
 * @link     http://filemanager.veno.it/
 */
if (!class_exists('GateKeeper', false)) {
    /**
     * GateKeeper class
     *
     * @category PHP
     * @package  VenoFileManager
     * @author   Nicola Franchini <info@veno.it>
     * @license  Exclusively sold on CodeCanyon
     * @link     http://filemanager.veno.it/
     */
    class GateKeeper
    {
        /**
         * Check user satus
         *
         * @param string $relative relative path to call
         * @param string $callfrom file from we call (used for admin captcha) '' or '_admin'
         *
         * @return $message
         */
        public static function init($relative = 'vfm-admin/', $callfrom = '')
        {
            global $gateKeeper;
            global $cookies;
            global $updater;
            global $setUp;

            if (isset($_GET['logout'])) {
                $unsetuser = isset($_SESSION['vfm_user_name']) ? $_SESSION['vfm_user_name'] : false;
                $_SESSION['vfm_user_name'] = null;
                $_SESSION['vfm_logged_in'] = null;
                $_SESSION['vfm_user_name_new'] = null;
                $_SESSION['vfm_user_space'] = null;
                $_SESSION['vfm_user_used'] = null;
                $gateKeeper->removeCookie($unsetuser, $relative);
                // session_destroy(); // keep language selection and minor preferences
            } else {
                if (!$gateKeeper->isUserLoggedIn()) {
                    $gateKeeper->checkCookie();
                }
            }

            $postusername = filter_input(INPUT_POST, 'user_name', FILTER_UNSAFE_RAW);
            $postuserpass = filter_input(INPUT_POST, 'user_pass', FILTER_UNSAFE_RAW);
            $rememberme = filter_input(INPUT_POST, 'vfm_remember', FILTER_UNSAFE_RAW);

            if ($postusername && $postuserpass) {

                if (Utils::checkCaptcha('show_captcha'.$callfrom)) {

                    if (GateKeeper::isUser($postusername, $postuserpass)) {
                        if ($rememberme === 'yes') {
                            $gateKeeper->setCookie($postusername);
                        }
                        if (isset($_SESSION['vfm_user_name_new']) && strlen($_SESSION['vfm_user_name_new']) > 0) {
                            $postusername = $_SESSION['vfm_user_name_new'];
                            // unset old sensitive username
                            $updater->updateUserData($postusername, 'sensitive', false);
                            $updater->updateUsers('vfm-admin/_content/users/');
                        }

                        $_SESSION['vfm_user_name'] = $postusername;
                        $_SESSION['vfm_logged_in'] = 1;

                        $usedspace = $gateKeeper->getUserSpace();

                        if ($usedspace !== false) {
                            $userspace = $gateKeeper->getUserInfo('quota')*1024*1024;
                            $_SESSION['vfm_user_used'] = $usedspace;
                            $_SESSION['vfm_user_space'] = $userspace;
                        } else {
                            $_SESSION['vfm_user_used'] = null;
                            $_SESSION['vfm_user_space'] = null;
                        }
                        if (SetUp::getConfig('notify_login') && $callfrom !== '_admin') {
                            Logger::logAccess();
                        }
                    } else {
                        Utils::setError($setUp->getString('wrong_pass'));
                    }
                } else {
                    Utils::setError($setUp->getString('wrong_captcha'));
                }
                header('location:?dir=');
                exit;
            }
        }

        /**
         * Delete multifile
         *
         * @return updates total available space
         */
        public function getUserSpace()
        {
            if ($this->getUserInfo('dir') !== null
                && $this->getUserInfo('quota') !== null
            ) {
                $totalsize = 0;
                $userfolders = json_decode($this->getUserInfo('dir'), true);
                $userfolders = $userfolders ? $userfolders : array();

                foreach ($userfolders as $myfolder) {
                    $checkfolder = urldecode(SetUp::getConfig('starting_dir').$myfolder);
                    if (file_exists($checkfolder)) {
                        $ritorno = Utils::getDirSize($checkfolder);
                        $totalsize += $ritorno['size'];
                    }
                }
                return $totalsize;
            }
            return false;
        }

        /**
         * Login validation
         *
         * @param string $userName user name
         * @param string $userPass password
         *
         * @return true/false
         */
        public static function isUser($userName, $userPass)
        {
            $salt = SetUp::getConfig('salt');
            $passo = $salt.urlencode($userPass);
            $users = SetUp::getUsers();
            
            // foreach ($users as $user) {
            //     if (isset($user['sensitive']) && $user['sensitive'] === $userName) {
            //         if (crypt($passo, $user['pass']) == $user['pass']) {
            //             $_SESSION['vfm_user_name_new'] = $user['name'];
            //             Utils::setWarning('<span>'.$setUp->getString('your_new_username_is').' <strong>'.$user['name'].'</strong></span>');
            //             return true;
            //         }
            //         break;
            //     }
            // }

            foreach ($users as $user) {
                if (strtolower($user['name']) === strtolower($userName)) {
                    if (crypt($passo, $user['pass']) === $user['pass']) {
                        if (isset($user['disabled']) && $user['disabled'] === true) {
                            global $setUp;
                            Utils::setWarning($setUp->getString('account_disabled'));
                            return false;
                        }
                        return true;
                    }
                    break;
                }
            }
            return false;
        }

        /**
         * Check if login is required to view lists
         *
         * @return true/false
         */
        public static function isLoginRequired()
        {
            if (SetUp::getConfig('require_login') == false) {
                return false;
            }
            return true;
        }

        /**
         * Check if user is logged in
         *
         * @return true/false
         */
        public static function isUserLoggedIn()
        {
            if (isset($_SESSION['vfm_user_name'])
                && isset($_SESSION['vfm_logged_in'])
                && $_SESSION['vfm_logged_in'] == 1
            ) {
                return true;
            }
            return false;
        }

        /**
         * Check if target action is allowed
         *
         * @param string $action action to check
         *
         * @return true/false
         */
        public static function isAllowed($action)
        {
            if ($action && GateKeeper::isAccessAllowed()) {
                $role = GateKeeper::getUserInfo('role');
                $role = $role == null ? 'guest' : $role;

                if ($role == 'superadmin') {
                    return true;
                }

                $base_actions = array(
                    'view_enable',
                    'viewdirs_enable',
                    'download_enable',
                );

                // Base actions true for all except Guest and User
                if (in_array($action, $base_actions) && $role !== 'guest' && $role !== 'user') {
                    return true;
                }

                $role_ext = $role == 'admin' ? '' : '_'.$role;

                return SetUp::getConfig($action.$role_ext);
            }
            return false;
        }

        /**
         * Check if user can access
         *
         * @return true/false
         */
        public static function isAccessAllowed()
        {
            if (!GateKeeper::isLoginRequired() || GateKeeper::isUserLoggedIn()) {
                return true;
            }
            return false;
        }

        /**
         * Get user info ('name', 'role', 'dir', 'email')
         *
         * @param int $info index of corresponding user info
         *
         * @return info requested
         */
        public static function getUserInfo($info)
        {
            if (GateKeeper::isUserLoggedIn()
                && isset($_SESSION['vfm_user_name'])
                && strlen($_SESSION['vfm_user_name']) > 0
            ) {
                $username = $_SESSION['vfm_user_name'];
                $curruser = Utils::getCurrentUser($username);

                if (isset($curruser[$info]) && strlen($curruser[$info]) > 0) {
                    return $curruser[$info];
                }
            }
            return null;
        }

        /**
         * Get user's avatar image, or return default
         *
         * @param string $username  user to search
         * @param string $adminarea relative
         * @param string $size      size in pixel
         *
         * @return image path
         */
        public static function getAvatar($username, $adminarea = 'vfm-admin/', $size = '25')
        {
            $avaimg = md5($username).'.png';
            
            if (!file_exists($adminarea.'_content/avatars/'.$avaimg)) {
                $imgtag = '<img data-name="'.$username.'" class="rounded-circle avatar avadefault" width="'.$size.'">';
            } else {
                $imgtag = '<img class="rounded-circle avatar" width="'.$size.'" src="'.SetUp::getConfig('script_url').'vfm-admin/_content/avatars/'.$avaimg.'">';
            }
            return $imgtag;
        }

        /**
         * Check if user is SuperAdmin
         *
         * @return true/false
         */
        public static function isSuperAdmin()
        {
            if (GateKeeper::getUserInfo('role') === 'superadmin') {
                return true;
            }
            return false;
        }

        /**
         * Check if user is MasterAdmin
         *
         * @return true/false
         */
        public static function isMasterAdmin()
        {
            $users = SetUp::getUsers();
            $king = array_shift($users);
            if ($king === Utils::getCurrentUser(GateKeeper::getUserInfo('name'))) {
                return true;
            }
            return false;
        }

        /**
         * Check if SuperAdmin has access to the area
         *
         * @param string $permission relative
         *
         * @return image path
         */
        public static function canSuperAdmin($permission)
        {
            if (GateKeeper::isSuperAdmin()) {
                if (GateKeeper::isMasterAdmin()) {
                    return true;
                }
                return SetUp::getConfig($permission);
            }
            return false;
        }

        /**
         * Show login box
         *
         * @return true/false
         */
        public static function showLoginBox()
        {
            if (!GateKeeper::isUserLoggedIn()
                && count(SetUp::getUsers()) > 0
            ) {
                return true;
            }
            return false;
        }

        /**
         * Set remember me cookie
         *
         * @param string $postusername user name
         *
         * @return cookie and key set
         */
        public function setCookie($postusername = false)
        {
            global $_REMEMBER;

            $rewrite = false;
            $salt = SetUp::getConfig('salt');
            $rmsha = md5($salt.sha1($postusername.$salt));
            $rmshaved = md5($rmsha);
            $expires = time()+ (60*60*24*365);

            if (PHP_VERSION_ID >= 70300) {
                setcookie(
                    'rm', $rmsha,
                    // ['expires' => $expires, 'httponly' => true]
                    ['expires' => $expires, 'httponly' => true, 'samesite' => 'strict']
                );
                setcookie(
                    'vfm_user_name', $postusername,
                    // ['expires' => $expires, 'httponly' => true]
                    ['expires' => $expires, 'httponly' => true, 'samesite' => 'strict']
                );
            } else {
                setcookie('rm', $rmsha, $expires);
                setcookie('vfm_user_name', $postusername, $expires);
            }

            if (array_key_exists($postusername, $_REMEMBER)
                && $_REMEMBER[$postusername] !== $rmshaved
            ) {
                $rewrite = true;
            }

            if (!array_key_exists($postusername, $_REMEMBER)
                || $rewrite == true
            ) {
                $_REMEMBER[$postusername] = $rmshaved;
                $rmb = '$_REMEMBER = ';
                if (false == (file_put_contents('vfm-admin/_content/users/remember.php', "<?php\n\n $rmb".var_export($_REMEMBER, true).";\n"))) {
                    Utils::setError('error setting your remember key');
                    return false;
                }
            }
        }

        /**
         * Remove remember me cookie
         *
         * @param string $postusername user name
         * @param string $path         relative path to users/
         *
         * @return updated remember.php file
         */
        public static function removeCookie($postusername = false, $path = 'vfm-admin/')
        {
            global $_REMEMBER;

            $expires = time()+ (60*60*24*365);

            if (PHP_VERSION_ID >= 70300) {
                setcookie(
                    'rm', '',
                    // ['expires' => $expires, 'httponly' => true]
                    ['expires' => $expires, 'httponly' => true, 'samesite' => 'strict']
                );
            } else {
                setcookie('rm', '', $expires);
            }
            // setcookie('rm', '', time() - (60*60*24*365));

            if ($postusername && $_REMEMBER) {
                if (array_key_exists($postusername, $_REMEMBER)) {
                    unset($_REMEMBER[$postusername]);
                
                    $rmb = '$_REMEMBER = ';
                    if (false == (file_put_contents($path.'_content/users/remember.php', "<?php\n\n $rmb".var_export($_REMEMBER, true).";\n"))
                    ) {
                        Utils::setError('error resetting remember key');
                        return false;
                    }
                }
            }
        }

        /**
         * Check rememberme cookie
         *
         * @return checkKey() | false
         */
        public function checkCookie()
        {
            global $cookies;

            if (isset($_COOKIE['rm']) && isset($_COOKIE['vfm_user_name'])) {
                $name = $_COOKIE['vfm_user_name'];
                $key = $_COOKIE['rm'];
                return $this->checkKey($name, $key);
            }
            return false;
        }

        /**
         * Check remember me key
         *
         * @param string $name user name
         * @param string $key  rememberme key
         *
         * @return login via cookie
         */
        public function checkKey($name, $key)
        {
            global $_REMEMBER;
            global $gateKeeper;

            if (array_key_exists($name, $_REMEMBER)) {
                if ($_REMEMBER[$name] === md5($key)) {
                    $_SESSION['vfm_user_name'] = $name;
                    $_SESSION['vfm_logged_in'] = 1;

                    $usedspace = $gateKeeper->getUserSpace();

                    if ($usedspace !== false) {
                        $userspace = $gateKeeper->getUserInfo('quota')*1024*1024;
                        $_SESSION['vfm_user_used'] = $usedspace;
                        $_SESSION['vfm_user_space'] = $userspace;
                    } else {
                        $_SESSION['vfm_user_used'] = null;
                        $_SESSION['vfm_user_space'] = null;
                    }
                    return true;
                } else {
                    $gateKeeper->removeCookie($name);
                }
            }
            return false;
        }
    }
}

<?php
/**
 * Control password reset
 *
 * @category PHP
 * @package  VenoFileManager
 * @author   Nicola Franchini <info@veno.it>
 * @license  Exclusively sold on CodeCanyon
 * @link     http://filemanager.veno.it/
 */
if (!class_exists('Resetter', false)) {
    /**
     * Class Resetter
     *
     * @category PHP
     * @package  VenoFileManager
     * @author   Nicola Franchini <info@veno.it>
     * @license  Exclusively sold on CodeCanyon
     * @link     http://filemanager.veno.it/
     */
    class Resetter
    {
        /**
         * Call update user functions
         *
         * @return $message
         */
        public function init()
        {
            global $updater;
            global $resetter;
            global $_USERS;
            global $users;
            $users = $_USERS;

            $resetpwd = filter_input(INPUT_POST, 'reset_pwd', FILTER_UNSAFE_RAW);
            $resetconf = filter_input(INPUT_POST, 'reset_conf', FILTER_UNSAFE_RAW);
            $userh = filter_input(INPUT_POST, 'userh', FILTER_UNSAFE_RAW);
            $getrp = filter_input(INPUT_POST, 'getrp', FILTER_UNSAFE_RAW);

            if ($resetpwd && $resetconf && $userh && $getrp) {

                if ($resetpwd == $resetconf && $resetter->checkTok($getrp, $userh) === true) {
                    $username = $resetter->getUserFromSha($userh);
                    $updater->updateUserPwd($username, $resetpwd);
                    $updater->updateUserFile('password');
                    $resetter->resetToken($resetter->getMailFromSha($userh));
                }
            }
        }

        /**
         * Get user name from encrypted email
         *
         * @param string $usermailsha user email in SHA1
         *
         * @return username
         */
        public function getUserFromSha($usermailsha)
        {
            global $_USERS;
            $utenti = $_USERS;

            foreach ($utenti as $value) {
                if (isset($value['email']) && sha1($value['email']) === $usermailsha) {
                    return $value['name'];
                }
            }
        }

        /**
         * Get user mail from encrypted email
         *
         * @param string $usermailsha user email in SHA1
         *
         * @return username
         */
        public function getMailFromSha($usermailsha)
        {
            global $_USERS;
            $utenti = $_USERS;

            foreach ($utenti as $value) {
                if (isset($value['email']) && sha1($value['email']) === $usermailsha) {
                    return $value['email'];
                }
            }
        }

        /**
         * Get user name from email
         *
         * @param string $usermail user email
         *
         * @return username
         */
        public function getUserFromMail($usermail)
        {
            global $_USERS;
            $utenti = $_USERS;

            foreach ($utenti as $value) {
                if (isset($value['email'])) {
                    if ($value['email'] === $usermail) {
                        return $value['name'];
                    }
                }
            }
        }

        /**
         * Reset token
         *
         * @param string $usermail user email
         *
         * @return mail to user
         */
        public function resetToken($usermail)
        {
            global $_TOKENS;
            global $tokens;
            $tokens = $_TOKENS;
            unset($tokens[$usermail]);

            $tkns = '$_TOKENS = ';

            if (false == (file_put_contents(
                'vfm-admin/_content/users/token.php',
                "<?php\n\n $tkns".var_export($tokens, true).";\n"
            ))
            ) {
                Utils::setError('error, no token reset');
                return false;
            }
        }

        /**
         * Set token for password recovering
         *
         * @param string $usermail user email
         * @param string $path     path to token.php
         *
         * @return mail to user
         */
        public function setToken($usermail, $path = '')
        {
            global $resetter;
            global $_TOKENS;
            global $tokens;
            $tokens = $_TOKENS;

            $birth = time();
            $salt = SetUp::getConfig('salt');
            $token = sha1($salt.$usermail.$birth);

            $tokens[$usermail]['token'] = $token;
            $tokens[$usermail]['birth'] = $birth;
            $tkns = '$_TOKENS = ';

            if (false == (file_put_contents(
                $path.'token.php',
                "<?php\n\n $tkns".var_export($tokens, true).";\n"
            ))
            ) {
                return false;
            } else {
                $message = array();
                $message['name'] = $resetter->getUserFromMail($usermail);
                $message['tok'] = '?rp='.$token.'&usr='.sha1($usermail);
                return $message;
            }
            return false;
        }

        /**
         * Check token validity and lifetime
         *
         * @param string $getrp  time to check
         * @param string $getusr getusr to check
         *
         * @return true/false
         */
        public function checkTok($getrp, $getusr)
        {
            global $_TOKENS;
            global $tokens;
            $tokens = $_TOKENS;
            $now = time();

            foreach ($tokens as $key => $value) {
                if (sha1($key) === $getusr) {
                    if ($value['token'] === $getrp) {
                        if ($now < $value['birth'] + 3600) {
                            return true;
                        }
                    }
                }
            }
            return false;
        }
    }
}

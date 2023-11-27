<?php
/**
 * Various utilities
 *
 * @category PHP
 * @package  VenoFileManager
 * @author   Nicola Franchini <info@veno.it>
 * @license  Exclusively sold on CodeCanyon
 * @link     http://filemanager.veno.it/
 */
if (!class_exists('Utils', false)) {
    /**
     * Utilities class
     *
     * @category PHP
     * @package  VenoFileManager
     * @author   Nicola Franchini <info@veno.it>
     * @license  Exclusively sold on CodeCanyon
     * @link     http://filemanager.veno.it/
     */
    class Utils
    {
        /**
         * Generate random string
         *
         * @param string $length string lenght
         *
         * @return $randomString random string
         */
        public static function randomString($length = 9)
        {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return '$1$'.$randomString;
        }

        /**
         * Check captcha code
         *
         * @param string $feat captcha to check
         *
         * @return true / false
         */
        public static function checkCaptcha($feat = 'show_captcha')
        {
            if (SetUp::getConfig($feat) !== true) {
                return true;
            }
            $gcaptcha = filter_input(INPUT_POST, 'g-recaptcha-response', FILTER_UNSAFE_RAW);
            $postcaptcha = filter_input(INPUT_POST, 'captcha', FILTER_UNSAFE_RAW);

            if ($postcaptcha) {
                $postcaptcha = strtolower($postcaptcha);
                if (isset($_SESSION['captcha'])
                    && $postcaptcha === $_SESSION['captcha']
                ) {
                    return true;
                }
            }
            if ($gcaptcha && SetUp::getConfig('recaptcha_secret')) {
                $response = json_decode(
                    file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.SetUp::getConfig('recaptcha_secret').'&response='.$gcaptcha), 
                    true
                );
                return $response['success'];
            }
            return false;
        }

        /**
         * Remove Query string from url
         *
         * @param string $url  the original url
         * @param array  $keys the qs to be removed
         *
         * @return ext
         */
        public static function removeQS($url, $keys = array())
        {
            foreach ($keys as $key) {
                $url = preg_replace('/(.*)(?|&)' . $key . '=[^&]+?(&)(.*)/i', '$1$2$4', $url . '&');
                $url = substr($url, 0, -1);
            }
            return $url;
        }

        /**
         * Get the file extension
         *
         * @param string $filepath file to check
         *
         * @return ext
         */
        public static function getFileExtension($filepath)
        {
            $infoext = pathinfo($filepath, PATHINFO_EXTENSION);
            $ext = $infoext ? filter_var(trim(urldecode($infoext)), FILTER_SANITIZE_URL) : false;
            return $ext;
        }

        /**
         * Determine the size of a file
         *
         * @param string $path file to calculate
         *
         * @return sizeInBytes
         * @since  3.0.3
         */
        public static function getFileSize($path)
        {
            $size = filesize($path);

            if (!($file = fopen($path, 'rb'))) {
                return false;
            }
            if ($size >= 0) { // Check if it really is a small file (< 2 GB)
                if (fseek($file, 0, SEEK_END) === 0) { // It really is a small file
                    fclose($file);
                    return $size;
                }
            }
            // Quickly jump the first 2 GB with fseek. After that fseek is not working on 32 bit php (it uses int internally)
            $size = PHP_INT_MAX - 1;
            if (fseek($file, $size) !== 0) {
                fclose($file);
                return false;
            }
            $length = 1024 * 1024;
            while (!feof($file)) { // Read the file until end
                $read = fread($file, $length);
                $size = bcadd($size, $length);
            }
            $size = bcsub($size, $length);
            $size = bcadd($size, strlen($read));

            fclose($file);
            return $size;
        }

        /**
         * Get the directory size
         *
         * @param string $path directory
         *
         * @return integer
         */
        public static function getDirSize($path)
        {
            $bytestotal = 0;
            $path = realpath($path);
            if ($path !== false) {
                foreach (
                    new RecursiveIteratorIterator(
                        new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS)
                    ) as $object
                ) {
                    $bytestotal += $object->getSize();
                }
            }
            $total['size'] = $bytestotal;
            return $total;
        }

        /**
         * Get pathinfo in UTF-8
         *
         * @param string $filepath to search
         *
         * @return array $ret
         */
        public static function mbPathinfo($filepath)
        {
            preg_match(
                '%^(.*?)[\\\\/]*(([^/\\\\]*?)(\.([^\.\\\\/]+?)|))[\\\\/\.]*$%im',
                $filepath,
                $node
            );

            if (isset($node[1])) {
                $ret['dirname'] = $node[1];
            } else {
                $ret['dirname'] = '';
            }

            if (isset($node[2])) {
                $ret['basename'] = $node[2];
            } else {
                $ret['basename'] = '';
            }

            if (isset($node[3])) {
                $ret['filename'] = $node[3];
            } else {
                $ret['filename'] = '';
            }

            if (isset($node[5])) {
                $ret['extension'] = $node[5];
            } else {
                $ret['extension'] = '';
            }
            return $ret;
        }

        /**
         * Get user data by username
         *
         * @param int $search username to search
         *
         * @return user array requested
         */
        public static function getCurrentUser($search)
        {
            $currentuser = array();
            $users = SetUp::getUsers();
            if ($users) {
                foreach ($users as $user) {
                    if (strtolower($user['name']) == strtolower($search)) {
                        $currentuser = $user;
                        return $currentuser;
                    }
                }
            }
            return false;
        }

        /**
         * Return current username
         *
         * @return username
         */
        public static function getUserName()
        {
            return isset($_SESSION['vfm_user_name']) ? $_SESSION['vfm_user_name'] : '--';
        }

        /**
         * Remove some chars from string
         *
         * @param string $str string to clean
         *
         * @return $str
         */
        public static function normalizeStr($str)
        {
            $invalid = array(
                '&#34;' => '', '&#39;' => '' ,
                '&lt;' => '', '&gt;' => '' ,
                '&quot;' => '', '&amp;' => '-',
                ' ' => '-',
                '[' => '-', ']' => '-',
                '{' => '-', '}' => '-',
                '<' => '', '>' => '',
                '`' => '', '´' => '',
                '„' => '', '”' => '', 
                '’' => '', '"' => '',
                '!' => '', '¡' => '',
                '?' => '', '¿' => '',
                '|' => '', '=' => '-', 
                '*' => 'x', ':' => '-',
                ',' => '.', ';' => '',
                'ª' => '', 'º' => '', 
                '~' => '', '&' => '-',  
                '\\' => '', '\'' => '-', '/' => '-',
                '§' => 's', '°' => '', '^' => '', '·' => '', '.' => '_',
                '$' => 'usd', '¢' => 'cent', '£' => 'lb', '€' => 'eur',
                '®' => '', '™' => '', '@' => '-at-', '%00' => '', chr(0) => '',
                // '(' => '-', ')' => '-', 
            );
            $cleanstring = strtr($str, $invalid);

            $cleanstring = strip_tags($cleanstring);
            $cleanstring = trim($cleanstring);
            $cleanstring = trim($cleanstring, '.');
            $cleanstring = stripslashes($cleanstring);
            $cleanstring = htmlspecialchars($cleanstring);

            // cut name if has more than 31 chars;
            // if (strlen($cleanstring) > 31) {
            //     $cleanstring = substr($cleanstring, 0, 31);
            // }
            return $cleanstring;
        }

        /**
         * Normalize NFD and NFC chars
         * requires (PHP 5 >= 5.3.0, PHP 7, PECL intl >= 1.0.0)
         *
         * @param string $str string to clean
         *
         * @return $cleanstring
         */
        public static function normalizeName($str)
        {
            $normalized = $str;
            if (function_exists('normalizer_is_normalized')) {
                if (!normalizer_is_normalized($normalized)) {
                    $normalized = normalizer_normalize($normalized);
                }
            }
            return $normalized;
        }

        /**
         * Remove accents from string.
         *
         * @param string $str string to clean
         *
         * @return unaccented value
         */
        public static function unaccent($str)
        {
            $accented = array(
                'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
                'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
                'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
                'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
                'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y'
            );
            $str = strtr($str, $accented);
            return $str;
        }

        /**
         * Replace some chars from string
         *
         * @param string $str string to clean
         *
         * @return $str
         */
        public static function extraChars($str)
        {
            $apici = array('&#34;', '&#39;');
            $realapici = array('"', '\'');
            $str = str_replace($apici, $realapici, $str);
            return $str;
        }

        /**
         * Convert square brackets in path
         * to be used before glob()
         *
         * @param string $path path to convert
         *
         * @return converted $path
         */
        public static function preGlob($path)
        {
            $path = str_replace('[', '\[', $path);
            $path = str_replace(']', '\]', $path);
            $path = str_replace('\[', '[[]', $path);
            $path = str_replace('\]', '[]]', $path);
            return $path;
        }

        /**
         * Check Magic quotes
         *
         * @param string $name string to check
         *
         * @return $name
         */
        public static function checkMagicQuotes($name)
        {
            $name = stripslashes($name);
            return $name;
        }

        /**
         * Check IP and redirect blacklisted
         *
         * @return true/false
         */
        public static function checkIP()
        {
            $kickoff = false;
            $ip_list = SetUp::getConfig('ip_list');
            $guest_ip = $_SERVER['REMOTE_ADDR'];
            $dest = SetUp::getConfig('ip_redirect', 'http://google.com');
            $whitelist = SetUp::getConfig('ip_whitelist');
            $blacklist = SetUp::getConfig('ip_blacklist');

            if ($ip_list && ($whitelist || $blacklist)) {
                if ($ip_list === 'allow' && $whitelist && !Utils::inList($guest_ip, $whitelist)) {
                    $kickoff = true;
                }
                if ($ip_list === 'reject' && $blacklist && Utils::inList($guest_ip, $blacklist)) {
                    $kickoff = true;
                }
                if ($kickoff) {
                    header('Location: '.$dest);
                    exit();
                }
            }
        }

        /**
         * Check if item is in list
         *
         * @param string $item item to check
         * @param string $list list where to look
         *
         * @return true/false
         */
        public static function inList($item, $list)
        {
            if (is_array($list)
                && count($list) > 0
                && in_array($item, $list)
            ) {
                return true;
            }
            return false;
        }

        /**
         * Check if file or folder exists (case insensitive)
         *
         * @param string $path what to search
         *
         * @return boolean
         */
        public static function fileExists($path)
        {
            $pathinfo = Utils::mbPathinfo($path);

            $filename = $pathinfo['filename'];
            $dirname = $pathinfo['dirname'];

            if (file_exists($path)) {
                return true;
            }
            // Handle case insensitive requests
            $dirname = Utils::preGLob($dirname);
            $fileArray = glob($dirname . '/*', GLOB_NOSORT);
            $fileNameLowerCase = strtolower($path);

            foreach ($fileArray as $file) {
                if (strtolower($file) == $fileNameLowerCase) {
                    return true;
                }
            }
            return false;
        }

        /**
         * Check if target file is writeable
         *
         * @param string $file path to check
         *
         * @return true/false
         */
        public static function isFileWritable($file)
        {
            if (file_exists($file) && is_writable($file)) {
                return true;
            }
            if (is_writable(dirname($file))) {
                return true;
            }
            return false;
        }

        /**
         * Output errors
         *
         * @param string $message error message
         *
         * @return output error
         */
        public static function setError($message)
        {
            if (isset($_SESSION['error']) && in_array($message, $_SESSION['error'])) {
                return false;
            }
            $_SESSION['error'][] = $message;
        }

        /**
         * Output success
         *
         * @param string $message success message
         *
         * @return output success
         */
        public static function setSuccess($message)
        {
            if (isset($_SESSION['success']) && in_array($message, $_SESSION['success'])) {
                return false;
            }
            $_SESSION['success'][] = $message;
        }

        /**
         * Output warning
         *
         * @param string $message warning message
         *
         * @return output warning
         */
        public static function setWarning($message)
        {
            if (isset($_SESSION['warning']) && in_array($message, $_SESSION['warning'])) {
                return false;
            }
            $_SESSION['warning'][] = $message;
        }
    }
}

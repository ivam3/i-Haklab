<?php
/**
 *  Main configuration
 *
 * @category PHP
 * @package  VenoFileManager
 * @author   Nicola Franchini <info@veno.it>
 * @license  Exclusively sold on CodeCanyon
 * @link     http://filemanager.veno.it/
 */
if (!class_exists('SetUp', false)) {
    /**
     * SetUp Class
     *
     * @category PHP
     * @package  VenoFileManager
     * @author   Nicola Franchini <info@veno.it>
     * @license  Exclusively sold on CodeCanyon
     * @link     http://filemanager.veno.it/
     */
    class SetUp
    {
        public $lang;
        /**
         * Set session and language
         *
         * @param string $relative relative path to call
         *
         * @return set lang session
         */
        public function __construct($relative = 'vfm-admin/')
        {
            $timeconfig = $this->getConfig('default_timezone');
            $timezone = (strlen($timeconfig) > 0) ? $timeconfig : "UTC";
            date_default_timezone_set($timezone);

            if (!isset($_SESSION)) {
                if (strlen($this->getConfig('session_name')) > 0) {
                    session_name($this->getConfig('session_name'));
                }
                if (PHP_VERSION_ID >= 70300) {
                    session_set_cookie_params(
                        // ['httponly' => true]
                        ['httponly' => true, 'samesite' => 'strict']
                    );
                }
                session_start();
            }

            if (isset($_GET['lang']) && file_exists($relative.'translations/'.$_GET['lang'].'.php')) {
                $this->lang = $_GET['lang'];
                $_SESSION['lang'] = $_GET['lang'];
            }

            if (isset($_SESSION['lang'])) {
                $this->lang = $_SESSION['lang'];
            } else {
                $lang = $this->getConfig('lang');

                // Get browser lang
                if ($this->getConfig('browser_lang')) {
                    global $translations_index;
                    $acceptLang = is_array($translations_index) ? array_keys($translations_index) : array($lang);
                    $arr = explode(",", $_SERVER['HTTP_ACCEPT_LANGUAGE'], 2);
                    $get_lang = $arr[0];
                    $sublang = substr($get_lang, 0, 2);
                    $stolang = $lang;
                    foreach ($acceptLang as $value) {
                        if ($value == $get_lang) {
                            $stolang = $value;
                            break;
                        }
                        $subval = substr($value, 0, 2);
                        if ($subval == $sublang) {
                            $stolang = $value;
                        }
                        if ($get_lang == $subval || $value == $sublang) {
                            $stolang = $value;
                        }
                    }
                    if (file_exists($relative.'translations/'.$stolang.'.php')) {
                        $lang = $stolang;
                    }
                }
                $_SESSION['lang'] = $lang;
                $this->lang = $lang;
            }
        }

        /**
         * Get string in current language
         *
         * @param string $stringName string to translate
         *
         * @return translated string
         */
        public function getString($stringName)
        {
            return $this->getLangString($stringName, $this->lang);
        }

        /**
         * The function for getting a translated string.
         * Falls back to english if the correct language is missing something.
         *
         * @param string $stringName string to translate
         *
         * @return translation
         */
        public static function getLangString($stringName)
        {
            global $_TRANSLATIONS;
            if (isset($_TRANSLATIONS)
                && is_array($_TRANSLATIONS)
                && isset($_TRANSLATIONS[$stringName])
                && strlen($_TRANSLATIONS[$stringName]) > 0
            ) {
                $translation = htmlspecialchars($_TRANSLATIONS[$stringName], ENT_COMPAT, 'UTF-8', false);

                // Don't bother if there are no specialchars - saves some processing.
                if (!preg_match('/[&<>"\']/', $translation)) {
                    return $translation;
                }
                $translation = stripslashes(strip_tags($translation));
                return $translation;
            } else {
                return '&gt;'.stripslashes(strip_tags(htmlspecialchars($stringName))).'&lt;';
            }
        }

        /**
         * Print languages list
         *
         * @param string $dir realtive path to translations
         *
         * @return Languages list
         */
        public function printLangMenu($dir = '')
        {
            global $translations_index;
            $menu = '';
            $files = glob($dir.'translations/*.php');
////            parse_str($_SERVER['QUERY_STRING'], $params);
if(isset($_SERVER['QUERY_STRING'])){
parse_str($_SERVER['QUERY_STRING'], $params);
} else {
$params = array();
}
if(isset($_SERVER['QUERY_STRING'])){
parse_str($_SERVER['QUERY_STRING'], $params);
} else {
$params = array();
}
            unset($params['lang']);
            $query = http_build_query($params);
            $query = $query !== '' ? '?'.$query.'&' : '?';

            foreach ($files as $item) {
                $fileinfo = Utils::mbPathinfo($item);
                $langvar = $fileinfo['filename'];
                $menu .= '<li';
                if ($this->lang === $langvar) {
                    $menu .= ' class="active"';
                }
                $menu .='><a class="dropdown-item" href="'.$query.'lang='.$langvar.'">';
                $out = isset($translations_index[$langvar]) ? $translations_index[$langvar] : $langvar;
                $menu .= '<span>'.$out.'</span></a></li>';
            }
            return $menu;
        }

        /**
         * The function outputting the shortcut icon tag
         *
         * @param string $path relative path to the file
         *
         * @return $output
         */
        public function printIcon($path = '')
        {
            $icon_ico = $path.'favicon.ico';
            $icon_png = $path.'favicon-152.png';
            $output = '';

            if (file_exists($icon_ico)) {
                $output .= '<link rel="shortcut icon" href="'.$icon_ico.'">';
            }
            if (file_exists($icon_png)) {
                $output .= '<link rel="apple-touch-icon-precomposed" href="'.$icon_png.'">';
            }
            return $output;
        }

        /**
         * The function for getting configuration values
         *
         * @param string $name    config option name
         * @param string $default optional default value
         *
         * @return config value
         */
        public static function getConfig($name, $default = false)
        {
            global $_CONFIG;
            if (isset($_CONFIG) && isset($_CONFIG[$name])) {
                if ($_CONFIG[$name] !== false) {
                    return $_CONFIG[$name];
                }
            }
            return $default;
        }

        /**
         * Get app description
         *
         * @return html decoded description or false
         */
        public function getDescription()
        {
            $fulldesc = html_entity_decode(Setup::getConfig('description'), ENT_QUOTES, 'UTF-8');
            $cleandesc = strip_tags($fulldesc, '<img>');

            if (strlen(trim($cleandesc)) > 0) {
                return $fulldesc;
            }
            return false;
        }

        /**
         * Print alert messages
         *
         * @return the alert
         */
        public function printAlert()
        {
            $_ERROR = isset($_SESSION['error']) ? $_SESSION['error'] : false;
            $_SUCCESS = isset($_SESSION['success']) ? $_SESSION['success'] : false;
            $_WARNING = isset($_SESSION['warning']) ? $_SESSION['warning'] : false;

            $alert = false;
            $output = '';
            $sticky_class = ' top-0 start-0';

            $stickypos = array(
                'top-left' => ' top-0 start-0',
                'bottom-left' => ' bottom-0 start-0',
                'top-right' => ' top-0 end-0',
                'bottom-right' => ' bottom-0 end-0',
            );

            $stickypos_get = SetUp::getConfig('sticky_alerts_pos', 'top-left');
            $sticky_class = isset($stickypos[$stickypos_get]) ? $stickypos[$stickypos_get] : $sticky_class;

            $output .= '<div class="position-fixed p-3'.$sticky_class.'" style="z-index: 1031"><div class="toast-container d-none">';
            $opentoast = '<div class="toast align-items-center fade show bg-light rounded-0" role="alert" aria-live="assertive" aria-atomic="true"><div class="d-flex">';
            $closetoast = '</div></div>';
            $closebtn = '<button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>';

            if (is_array($_ERROR)) {
                foreach ($_ERROR as $error) {
                    $output .= '<div class="toast align-items-center fade show bg-light rounded-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false"><div class="d-flex"><div class="toast-body border-5 border-start border-danger">'.$error.'</div>'.$closebtn.$closetoast;
                }
                $alert = true;
            }
            if (is_array($_WARNING)) {
                foreach ($_WARNING as $warning) {
                    $output .= $opentoast.'<div class="toast-body border-5 border-start border-warning">'.$warning.'</div>'.$closebtn.$closetoast;
                }
                $alert = true;
            }

            if (is_array($_SUCCESS)) {
                foreach ($_SUCCESS as $success) {
                    $output .= $opentoast.'<div class="toast-body border-5 border-start border-success">'.$success.'</div>'.$closebtn.$closetoast;
                }
                $alert = true;
            }
            
            $output .= '</div></div>';

            if ($alert === true) {
                unset($_SESSION['success']);
                unset($_SESSION['error']);
                unset($_SESSION['warning']);
                return $output;
            }
            return false;
        }

        /**
         * Format modification date time
         *
         * @param string $time new format
         *
         * @return formatted date
         */
        public static function formatModTime($time)
        {
            $timeformat = 'd.m.y H:i:s';
            if (SetUp::getConfig('time_format') != null
                && strlen(SetUp::getConfig('time_format')) > 0
            ) {
                $timeformat = SetUp::getConfig('time_format');
            }
            return date($timeformat, $time);
        }

        /**
         * Format file size
         *
         * @param string $size new format
         *
         * @return formatted size
         */
        public function formatSize($size)
        {
            $sizes = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB');
            $syz = $sizes[0];
            for ($i = 1; (($i < count($sizes)) && ($size >= 1024)); $i++) {
                $size = $size / 1024;
                $syz  = $sizes[$i];
            }
            return round($size, 2).' '.$syz;
        }

        /**
         * Get all users from users.php
         *
         * @return users array
         */
        public static function getUsers()
        {
            global $_USERS;
            if (isset($_USERS)) {
                return $_USERS;
            }
            return false;
        }

        /**
         * Return ini values in bytes
         *
         * @param string $val value to convert
         *
         * @return value in bytes
         */
        public function returnIniBytes($val)
        {
            $val = trim($val);
            $last = strtolower($val[strlen($val)-1]);

            $val = floatval($val);

            switch($last) 
            {
            case 'g':
                $val *= 1024;
            case 'm':
                $val *= 1024;
            case 'k':
                $val *= 1024;
            }
            return $val;
        }

        /**
         * Server available max upload size
         *
         * @return available max upload size in bytes
         */
        public function getMaxUploadSize()
        {
            // select maximum upload size
            $max_upload = ($this->returnIniBytes(ini_get('upload_max_filesize'))/2);
            // select post limit
            $max_post = ($this->returnIniBytes(ini_get('post_max_size'))/2);
            // select memory limit
            $init_memory_limit = ini_get('memory_limit');
            // set equal to post_max_size if memory_limit is unlimited
            $memory_limit = $init_memory_limit == '-1' ? $max_post : ($this->returnIniBytes($init_memory_limit)/2);
            // get the smallest of them, this defines the real limit
            $available = min($max_upload, $max_post, $memory_limit);
            // Set 1MB as minimum safe
            $available_safe = max(1048576, $available);
            // return the value in bytes
            return round($available_safe);
        }

        /**
         * Upload chunk size
         *
         * @return chunksize in bytes (32M if the server can upload at least 64M).
         */
        public function getChunkSize()
        {
            $serverSize = $this->getMaxUploadSize();
            $idealSize = 32*1048576; // 1048576 == 1MB
            return min($serverSize, $idealSize);
        }

        /**
         * Check if target file is writeable
         *
         * @param string $path path to check
         *
         * @return true/false
         */
        public function sanitizePath($path)
        {
            $prefix = ltrim(SetUp::getConfig('starting_dir'), './');
            $trimpath = ltrim($path, './');

            if (substr($trimpath, 0, strlen($prefix)) == $prefix) {
                $trimpath = substr($trimpath, strlen($prefix));
            }
            return $trimpath;
        }

    }
}

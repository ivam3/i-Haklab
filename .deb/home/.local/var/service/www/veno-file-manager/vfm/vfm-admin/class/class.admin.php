<?php
/**
 *  Admin functions
 *
 * @category PHP
 * @package  VenoFileManager
 * @author   Nicola Franchini <info@veno.it>
 * @license  Exclusively sold on CodeCanyon
 * @link     http://filemanager.veno.it/
 */
if (!class_exists('Admin', false)) {
    /**
     * Admin Class
     *
     * @category PHP
     * @package  VenoFileManager
     * @author   Nicola Franchini <info@veno.it>
     * @license  Exclusively sold on CodeCanyon
     * @link     http://filemanager.veno.it/
     */
    class Admin
    {
        /**
         * Get the url of the application
         *
         * @return url of the app
         */
        public static function getAppUrl()
        {
            /**
            * Check if http or https
            */
            if (!empty($_SERVER['HTTPS'])
                && $_SERVER['HTTPS'] !== 'off'
                || $_SERVER['SERVER_PORT'] == 443
            ) {
                $http = 'https://';
            } else {
                $http = 'http://';
            }
            /**
            * Setup the application url
            */
            $actual_link = $http.$_SERVER['HTTP_HOST'].dirname($_SERVER['REQUEST_URI']);
            $chunks = explode('vfm-admin', $actual_link);
            $cleanqs = $chunks[0];
            return $cleanqs;
        }

        /**
         * Filter IP
         *
         * @param string $ip the IP to filter
         *
         * @return validated IP or false
         */
        public function filterIP($ip)
        {
            return filter_var(trim($ip), FILTER_VALIDATE_IP);
        }

        /**
         * Return folders available inside given directory
         *
         * @param string $dir realtive path
         *
         * @return $folders array
         */
        public function getFolders($dir = '')
        {
            $directory = '.'.SetUp::getConfig('starting_dir');
            $files = array_diff(
                scandir($dir.$directory),
                array('.', '..')
            );
            $files = preg_grep('/^([^.])/', $files);

            $folders = array();

            foreach ($files as $item) {
                if (is_dir($directory.$item) && $directory.$item !== '../vfm-admin') {
                    array_push($folders, $item);
                }
            }
            return $folders;
        }

        /**
         * Return languages list as array
         *
         * @param string $dir realtive path to translations
         *
         * @return $languages array
         */
        public function getLanguages($dir = '')
        {
            global $translations_index;

            $files = glob($dir.'translations/*.php');
            $languages = array();

            foreach ($files as $item) {
                $fileinfo = Utils::mbPathinfo($item);
                $langvar = $fileinfo['filename'];
                $langname = isset($translations_index[$langvar]) ? $translations_index[$langvar] : $langvar;
                $languages[$langvar] = $langname;
            }
            return $languages;
        }


        /**
         * Update users file
         *
         * @param array $_USERS file users
         * @param array $users  updated users
         *
         * @return file updated
         */
        public function updateUsers($_USERS, $users)
        {
            global $_USERS;
            global $users;
            global $setUp;

            $usrs = '$_USERS = ';

            if (false == (file_put_contents('_content/users/users.php', "<?php\n\n $usrs".var_export($users, true).";\n"))) {
                Utils::setError('Error writing on _content/users/users.php, check CHMOD');
            } else {
                $_USERS = $users;
                Utils::setSuccess($setUp->getString("users_updated"));
            }
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

            if (isset($_GET['res'])) {
                $_SUCCESS = urldecode($_GET['res']);
            }

            $alert = false;
            $output = '';

            $closealert = '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            
            if (is_array($_ERROR)) {
                $class = ' alert-danger';
                $icon = 'x-circle';
                $openalert = '<div class="alert alert-dismissible fade show rounded-0'.$class.'" role="alert"><i class="bi bi-'.$icon.'"></i> ';
                foreach ($_ERROR as $error) {
                    $output .= $openalert . $error . $closealert;
                }
                $alert = true;
            }

            if (is_array($_WARNING)) {
                $class = ' alert-warning';
                $icon = 'exclamation-triangle';
                $openalert = '<div class="alert alert-dismissible fade show rounded-0'.$class.'" role="alert"><i class="bi bi-'.$icon.'"></i> ';
                foreach ($_WARNING as $warning) {
                    $output .= $openalert . $warning . $closealert;
                }
                $alert = true;
            }

            if (is_array($_SUCCESS)) {
                $class = ' alert-success';
                $icon = 'check-circle';
                $openalert = '<div class="alert alert-dismissible fade show rounded-0'.$class.'" role="alert"><i class="bi bi-'.$icon.'"></i> ';
                foreach ($_SUCCESS as $success) {
                    $output .= $openalert . $success . $closealert;
                }
                $alert = true;
            }
            if ($alert === true) {
                unset($_SESSION['success']);
                unset($_SESSION['error']);
                unset($_SESSION['warning']);
                return $output;
            }
            return false;
        }

        /**
         * Upload Image
         *
         * @param string $file     file to upload
         * @param string $filename file name
         * @param bool   $svg      accept svg
         *
         * @return the file or false
         */
        public function uploadImage($file, $filename = false, $svg = true)
        {
            // if (get_magic_quotes_gpc()) {
            //     $newimage = time().'-'.stripslashes($file['name']);
            // } else {
            //     $newimage = time().'-'.$file['name'];
            // }
            $newimage = time().'-'.stripslashes($file['name']);

            $allowedExts = array("gif", "jpeg", "jpg", "png");

            if ($svg == true) {
                $allowedExts[] = 'svg';
            }

            $extension = strtolower(pathinfo($newimage, PATHINFO_EXTENSION));
            // $filename = strtolower(pathinfo($newimage, PATHINFO_FILENAME));

            if (!is_dir('_content/uploads/')) {
                mkdir('_content/uploads/');
            }

            if (in_array($extension, $allowedExts)) {
                $newimage = $filename ? $filename.'.'.$extension : $newimage;

                if ($file["error"] > 0) {
                    Utils::setError('Error uploading:'.$file["error"]);
                    return;
                } else {
                    move_uploaded_file($file["tmp_name"], "_content/uploads/" . $newimage);
                    // Utils::setSuccess($newimage);
                    return $newimage;
                }
            } else {
                Utils::setError('Invalid file. Allowed extensions: '.implode(", ", $allowedExts));
                return false;
            }
        }

        /**
         * Get image or transparent placeholder
         *
         * @param string $file file path to search
         *
         * @return the file or false
         */
        public function printImgPlace($file = '')
        {
            $output = 'admin-panel/images/placeholder.png';
            if (file_exists($file)) {
                $output = $file;
            }
            return $output;
        }

        /**
         * Explode HSL color value
         *
         * @param string $hsl color to covert
         *
         * @return color hsl array
         */
        public function explodeHSL($hsl)
        {

            $nopre = explode('(', $hsl);
            $nopost = isset($nopre[1]) ? explode(')', $nopre[1]) : false;
            $content = $nopost && isset($nopost[0]) ? $nopost[0] : false;
            // $content = explode(')', (explode('(', $hsl)[1]))[0];

            $hslarray = $content ? explode(',', $content) : false;
            $converted = array(
                'basecolor' => '210, 16%',
                'baseluminance' => '98%',
                'basetext' => '#212529',
                'baselink' => '#374048',
            );

            if (isset($hslarray[0]) && isset($hslarray[1]) && isset($hslarray[2])) {
                $thresold = floatval($hslarray[2])/100.00;
                $colortext = $thresold >= 0.6 ? '#212529' : '#f8f9fa';
                $colorlink = $thresold >= 0.6 ? '#374048' : '#C7CDD0';
                $converted = array(
                    'basecolor' => trim($hslarray[0]).','.trim($hslarray[1]),
                    'baseluminance' => trim($hslarray[2]),
                    'basetext' => $colortext,
                    'baselink' => $colorlink,
                );
            }
            return $converted;
        }

        /**
         * Save custom css
         *
         * @return update css file
         */
        public function updateCss()
        {
            $hsl_primary = $this->explodeHSL(SetUp::getConfig('--color-primary', 'hsl(216, 98%, 52%)'));
            $hsl_dark = $this->explodeHSL(SetUp::getConfig('--color-dark', 'hsl(210, 11%, 15%)'));
            $hsl_light = $this->explodeHSL(SetUp::getConfig('--color-light', 'hsl(210, 16%, 98%)'));

            $output = ':root {';
            $output .= '--base-color-primary:'.$hsl_primary['basecolor'].';';
            $output .= '--base-l-primary:'.$hsl_primary['baseluminance'].';';
            $output .= '--color-primary-text:'.$hsl_primary['basetext'].';';
            $output .= '--color-primary-link:'.$hsl_primary['baselink'].';';

            $output .= '--base-color-light:'.$hsl_light['basecolor'].';';
            $output .= '--base-l-light:'.$hsl_light['baseluminance'].';';
            $output .= '--color-light-text:'.$hsl_light['basetext'].';';
            $output .= '--color-light-link:'.$hsl_light['baselink'].';';

            $output .= '--base-color-dark:'.$hsl_dark['basecolor'].';';
            $output .= '--base-l-dark:'.$hsl_dark['baseluminance'].';';
            $output .= '--color-dark-text:'.$hsl_dark['basetext'].';';
            $output .= '--color-dark-link:'.$hsl_dark['baselink'].';';
            if (SetUp::getConfig('dark_header')) {
                $output .= '--color-header-text: var(--color-dark-text);';
                $output .= '--color-header: var(--color-dark-lighter);';
            }
            $output .= '}';

            if (false === (file_put_contents('css/colors.css', $output))) {
                Utils::setError('Error saving /css/colors.css file');
            }
        }
    }
}

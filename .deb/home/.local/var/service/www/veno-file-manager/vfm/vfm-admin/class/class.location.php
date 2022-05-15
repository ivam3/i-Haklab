<?php
/**
 * Holds the informations about path location
 *
 * @category PHP
 * @package  VenoFileManager
 * @author   Nicola Franchini <info@veno.it>
 * @license  Exclusively sold on CodeCanyon
 * @link     http://filemanager.veno.it/
 */
if (!class_exists('Location', false)) {
    /**
     * Location class
     *
     * @category PHP
     * @package  VenoFileManager
     * @author   Nicola Franchini <info@veno.it>
     * @license  Exclusively sold on CodeCanyon
     * @link     http://filemanager.veno.it/
     */
    class Location
    {
        public $path;
        /**
         * Set the current directory
         *
         * @param string $getdir explicit dir to point
         *
         * @return current directory
         */
        public function __construct($getdir = false)
        {
            $getdir = $getdir ? $getdir : filter_input(INPUT_GET, 'dir', FILTER_UNSAFE_RAW);

            if (!$getdir || !is_dir($getdir)) {
                $this->path = $this->splitPath(SetUp::getConfig('starting_dir'));
            } else {
                $this->path = $this->splitPath($getdir);
            }
        }

        /**
         * Split a file path into array elements
         *
         * @param string $dir directory to split
         *
         * @return $path2
         */
        public static function splitPath($dir)
        {
            $dir = stripslashes($dir);
            $path1 = preg_split("/[\\\\\/]+/", $dir);
            $path2 = array();

            if (is_dir($dir)) {
                for ($i = 0; $i < count($path1); $i++) {
                    if ($path1[$i] == '..' || $path1[$i] == '.' || $path1[$i] == '') {
                        continue;
                    }
                    $path2[] = $path1[$i];
                }
            }

            if (count($path2) < 1 && strlen(SetUp::getConfig('starting_dir')) > 2) {
                $path2[] = SetUp::getConfig('starting_dir');
            }
            return $path2;
        }

        /**
         * Get the current directory.
         *
         * @param boolean $prefix  Include the prefix ("./")
         * @param boolean $encoded URL-encode the string
         * @param boolean $html    HTML-encode the string
         * @param int     $upper   return directory n-levels up
         * @param string  $dir     relative path
         *
         * @return $dir
         */
        public function getDir($prefix, $encoded, $html, $upper, $dir = false)
        {
            //$dir = '';
            if (!$dir && $prefix == true) {
                $dir = './';
            }
            if (!$dir) {
                $dir = '';
            }
            for ($i = 0; $i < ((count($this->path) >= $upper
                && $upper > 0) ? count($this->path) - $upper : count($this->path)); $i++) {

                $temp = $this->path[$i];

                if ($encoded) {
                    $temp = rawurlencode($temp);
                }
                if ($html) {
                    $temp = htmlspecialchars($temp);
                }
                $dir .= $temp.'/';
            }
            $dir = Utils::extraChars($dir);
            return $dir;
        }

        /**
         * Get directory link for breadcrumbs
         *
         * @param int     $level breadcrumb level
         * @param boolean $html  HTML-encode the name
         *
         * @return path name
         */
        public function getPathLink($level, $html)
        {
            if ($html) {
                return htmlspecialchars($this->path[$level]);
            } else {
                return $this->path[$level];
            }
        }

        /**
         * Get full directory path
         *
         * @return path name
         */
        public function getFullPath($path = false)
        {
            $fullpath = (strlen(SetUp::getConfig('basedir')) > 0 ? SetUp::getConfig('basedir') : str_replace('\\', '/', dirname(dirname(dirname(realpath(__FILE__))))))."/".$this->getDir(false, false, false, 0);
            $fullpath = Utils::extraChars($fullpath);
            return $fullpath;
        }


        /**
         * Get clean directory path
         *
         * @return path name
         */
        public function getCleanPath()
        {
            $thispath = $this->getDir(true, false, false, 0);
            $fullpath = str_replace(SetUp::getConfig('starting_dir'), '', $thispath);
            return $fullpath;
        }


        /**
         * Check if editing is allowed into the current directory,
         * based on configuration settings
         *
         * @param string $relative relative path to index.php
         *
         * @return true/false
         */
        public function editAllowed($relative = false)
        {
            $totdirs = count($this->path);

            $father = $this->getDir(false, true, false, $totdirs -1);
            if (in_array(basename($father), SetUp::getConfig('hidden_dirs'))) {
                return false;
            }

            if ($this->checkUserDir($relative) === true) {
                return true;
            }
            return false;
        }

        /**
         * Check if directory is available for user
         *
         * @param string $relative relative path to index.php
         *
         * @return true/false
         */
        public function checkUserDir($relative = false)
        {
            $thispath = $this->getDir(true, false, false, 0, $relative);

            if (!is_dir(realpath($thispath))) {
                return false;
            }

            $getUserInfo = GateKeeper::getUserInfo('dir');
            if ($getUserInfo === null) {
                return true;
            }

            $startdir = SetUp::getConfig('starting_dir');
            $userpatharray = $getUserInfo !== null ? json_decode($getUserInfo, true) : array();
            $thiscleanpath = ltrim($thispath, './');
            $cleanstartdir = rtrim(ltrim($startdir, './'), '/');
            $thispatharray = explode('/', $thiscleanpath);
            $checkpath = $thispatharray[0] === $cleanstartdir && strlen($cleanstartdir) ? $thispatharray[1] : $thispatharray[0];
            $pathcounter = $thispatharray[0] === $cleanstartdir && strlen($cleanstartdir) ? (int)2 : (int)1;

            // Check for multiple folders assigned
            foreach ($userpatharray as $value) {

                // Check if a sub/sub folder is assigned
                $userdirarray = explode('/', $value);
                $usersubs = count($userdirarray) - 1;
                if ($usersubs > 0) {
                    $subscounter = $usersubs + $pathcounter;
                    for ($i = $pathcounter; $i < $subscounter; $i++) {
                        $checkpath .= '/'.$thispatharray[$i];
                    }
                }

                // Finally check if the location is accessible by the user
                if ($value === $checkpath) {
                    return true;
                }
            }
            return false;
        }

        /**
         * Check if current directory is writeable
         *
         * @return true/false
         */
        public function isWritable()
        {
            return is_writable($this->getDir(true, false, false, 0));
        }

        /**
         * Create links to logout, delete and open directory
         *
         * @param boolean $logout set logout
         * @param string  $delete path to delete
         * @param string  $dir    path to link
         *
         * @return link
         */
        public function makeLink($logout, $delete, $dir)
        {
            $link = '?';

            if ($logout == true) {
                $link .= 'logout';
                return $link;
            }
            $link .= 'dir='.$dir;
            if ($delete != null) {
                $link .= '&amp;del='.base64_encode($delete);
            }
            return $link;
        }
    }
}

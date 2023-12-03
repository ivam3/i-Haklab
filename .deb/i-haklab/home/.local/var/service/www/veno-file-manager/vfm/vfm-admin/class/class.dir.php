<?php
/**
 * Hold the information about one directory in the list
 *
 * @category PHP
 * @package  VenoFileManager
 * @author   Nicola Franchini <info@veno.it>
 * @license  Exclusively sold on CodeCanyon
 * @link     http://filemanager.veno.it/
 */
if (!class_exists('Dir', false)) {
    /**
     * Dir class
     *
     * @category PHP
     * @package  VenoFileManager
     * @author   Nicola Franchini <info@veno.it>
     * @license  Exclusively sold on CodeCanyon
     * @link     http://filemanager.veno.it/
     */
    class Dir
    {
        public $name;
        public $location;
        public $modTime;

        /**
         * Constructor
         *
         * @param string $name     path name
         * @param string $location current location
         * @param string $relative relative path
         *
         * @return directory name and location
         */
        public function __construct($name, $location, $relative = '')
        {
            $this->name = $name;
            // $this->name = iconv(mb_detect_encoding($name, mb_detect_order(), true), "UTF-8", $name);
            $this->location = $location;
            $this->modTime = filemtime(
                $this->location->getDir(true, false, false, 0, $relative).$name
            );
        }

        /**
         * Get directory location
         *
         * @return directory location
         */
        public function getLocation()
        {
            return $this->location->getDir(true, false, false, 0);
        }
        
        /**
         * Get directory name
         *
         * @return directory name
         */
        public function getName()
        {
            return $this->name;
        }

        /**
         * Get directory HTML name
         *
         * @return directory name
         */
        public function getNameHtml()
        {
            return htmlspecialchars($this->name);
        }

        /**
         * Get directory name urlencoded
         *
         * @return directory name
         */
        public function getNameEncoded()
        {
            return rawurlencode($this->name);
        }

        /**
         * Get time
         *
         * @return mod time
         */
        public function getModTime()
        {
            return $this->modTime;
        }

        /**
         * Count files and folders inside dir
         *
         * @param string $dir path to check
         *
         * @return array with files and folders count
         */
        public static function countContents($dir)
        {
            $fullpath = Utils::preGLob($dir);
            $aprila = new FilesystemIterator($fullpath, FilesystemIterator::SKIP_DOTS);

            if ($aprila) {

                $filter_files = new CallbackFilterIterator(
                    $aprila, function ($cur, $key, $iter) {
                        return $cur->isFile();
                    }
                );
                $filter_dirs = new CallbackFilterIterator(
                    $aprila, function ($cur, $key, $iter) {
                        return $cur->isDir();
                    }
                );
                $quantifiles = iterator_count($filter_files);
                $quantedir = iterator_count($filter_dirs);

            } else {
                $quantifiles = 0;
                $quantedir = 0;
            }
            $result = array(
                'files' => $quantifiles,
                'folders' => $quantedir
            );
            return $result;
        }
    }
}

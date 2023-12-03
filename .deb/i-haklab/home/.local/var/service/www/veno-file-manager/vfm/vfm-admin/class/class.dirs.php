<?php
/**
 * Manage the folder archive
 *
 * @category PHP
 * @package  VenoFileManager
 * @author   Nicola Franchini <info@veno.it>
 * @license  Exclusively sold on CodeCanyon
 * @link     http://filemanager.veno.it/
 */
if (!class_exists('Dirs', false)) {
    /**
     * Class Dirs
     *
     * @category PHP
     * @package  VenoFileManager
     * @author   Nicola Franchini <info@veno.it>
     * @license  Exclusively sold on CodeCanyon
     * @link     http://filemanager.veno.it/
     */
    class Dirs
    {
        public $location,
        $dirs,
        $fullpath;

        /**
         * Constructor
         *
         * @param string $location Current location
         * @param string $fullpath Full location path
         * @param string $relative Relative path to index.php
         *
         * @return all file data
         */
        public function __construct($location, $fullpath, $relative = '')
        {
            $this->location = $location;
            $this->openDir($fullpath, $relative);
        }

        /**
         * Read the file list from the directory
         *
         * @param string $fullpath Full location path
         * @param string $relative Relative path to index.php
         *
         * @return Reading the data of files and directories
         */
        public function openDir($fullpath, $relative = '')
        {
            global $setUp;

            $totdirs = count($this->location->path);
            $father = $this->location->getDir(false, true, false, $totdirs -1);
            $hidden_dirs = $setUp->getConfig('hidden_dirs');
            $startingdir = $setUp->getConfig('starting_dir');
            // check if any folder is assigned to the current user
            $userpatharray = GateKeeper::getUserInfo('dir') !== null ? json_decode(GateKeeper::getUserInfo('dir'), true) : false;

            // Block reading hidden dirs
            if (in_array(basename($father), $hidden_dirs)) {
                Utils::setError($setUp->getString('unable_to_read_dir'));
                return false;
            }

            $hidefiles = false;

            if (strlen($startingdir) < 3 && $startingdir === $this->location->getDir(true, true, false, 0)) {
                $hidefiles = true;
            }

            if (is_dir($fullpath)) {
                $fullpath = Utils::preGLob($fullpath);
                $content = glob($fullpath.'/*');

                $this->dirs = array();

                if (is_array($content)) {
                    foreach ($content as $item) {

                        if (is_dir($item)) {

                            $mbitem = Utils::mbPathinfo($item);
                            $item_basename = $mbitem['basename'];

                            // get only users' assigned folders if any
                            if ($userpatharray && !in_array($item_basename, $userpatharray) && !$this->location->editAllowed($relative)) {
                                continue;
                            }
                        
                            // Skip /vfm-admin/ if the main uploads dir is the root
                            if (!$hidefiles || ($hidefiles && !in_array($item_basename, $hidden_dirs))) {
                                $this->dirs[] = new Dir($item_basename, $this->location, $relative);
                            }
                        }
                    }
                }
            }
        }
    }
}

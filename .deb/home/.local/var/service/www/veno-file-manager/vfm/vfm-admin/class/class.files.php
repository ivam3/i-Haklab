<?php
/**
 * Manage the file archive
 *
 * @category PHP
 * @package  VenoFileManager
 * @author   Nicola Franchini <info@veno.it>
 * @license  Exclusively sold on CodeCanyon
 * @link     http://filemanager.veno.it/
 */
if (!class_exists('Files', false)) {
    /**
     * Class Files
     *
     * @category PHP
     * @package  VenoFileManager
     * @author   Nicola Franchini <info@veno.it>
     * @license  Exclusively sold on CodeCanyon
     * @link     http://filemanager.veno.it/
     */
    class Files
    {
        public $location,
        $files,
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
            $this->getFiles($fullpath, $relative);
        }

        /**
         * Read the file list from the directory
         *
         * @param string $fullpath Path to scan
         * @param string $relative Relative path to index.php
         *
         * @return Reading the data of files
         */
        public function getFiles($fullpath, $relative = '')
        {
            global $setUp;

            if (is_dir($fullpath)) {

                $totdirs = count($this->location->path);
                $father = $this->location->getDir(false, true, false, $totdirs -1);
                $hidden_dirs = $setUp->getConfig('hidden_dirs');
                $hidden_files = $setUp->getConfig('hidden_files');
                $startingdir = $setUp->getConfig('starting_dir');

                if (in_array(basename($father), $hidden_dirs)) {
                    Utils::setError($setUp->getString('unable_to_read_dir'));
                    return false;
                }
                $hide_vfm_files = false;

                if (strlen($startingdir) < 3 && $startingdir === $this->location->getDir(true, true, false, 0)) {
                    $hide_vfm_files = true;
                }

                $fullpath = Utils::preGLob($fullpath);

                // Show hidden files.
                if ($setUp->getConfig('show_hidden_files') === true) {
                    $files = array_merge(glob($fullpath.'/*'), glob($fullpath.'/{,.}*', GLOB_BRACE));
                } else {
                    $files = glob($fullpath.'/*');
                }

                $this->files = array();
                if (is_array($files)) {
                    foreach ($files as $item) {
                        $mbitem = Utils::mbPathinfo($item);
                        $item_basename = $mbitem['basename'];
                        if (!is_dir($item) && $item_basename !== '.htaccess' && $item_basename !== 'web.config') {
                            // Skip VFM and hidden files if the main uploads dir is the root.
                            if (!$hide_vfm_files || ($hide_vfm_files && !in_array($item_basename, $hidden_files))) {
                                $this->files[] = new File($item_basename, $this->location, $relative);
                            }
                        }
                    }
                }
            }
        }
    }
}

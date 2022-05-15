<?php
/**
 * Control the templating system
 *
 * @category PHP
 * @package  VenoFileManager
 * @author   Nicola Franchini <info@veno.it>
 * @license  Exclusively sold on CodeCanyon
 * @link     http://filemanager.veno.it/
 */
if (!class_exists('Template', false)) {
    /**
     * Template class
     *
     * @category PHP
     * @package  VenoFileManager
     * @author   Nicola Franchini <info@veno.it>
     * @license  Exclusively sold on CodeCanyon
     * @link     http://filemanager.veno.it/
     */
    class Template
    {
        /**
         * Check if all the parts exist
         *
         * @param string $file - the template part to search
         *
         * @return include file
         */
        public function include( $file )
        {
            if (file_exists(dirname(dirname(__FILE__)).'/_content/template/'.$file.'.php')) {
                $path = '/_content/template/'.$file.'.php';
            } else {
                $path = '/template/'.$file.'.php';
            }
            return $path;
        }

        /**
         * Check if all the parts exist
         *
         * @param string $file     - the template part to search
         * @param string $relative - the relative path
         *
         * @return include file
         */
        public function getPart($file, $relative = 'vfm-admin/')
        {
            global
            $parentfile,
            $_IMAGES,
            $_USERS,
            $newusers,
            $downloader,
            $gateKeeper,
            $getdownloadlist,
            $location,
            $resetter,
            $getrp,
            $setUp,
            $updater,
            $vfm_version;

            if (file_exists($relative.'_content/template/'.$file.'.php')) {
                $thefile = $relative.'_content/template/'.$file.'.php';
            } else {
                $thefile =  $relative.'include/'.$file.'.php';
            }
            include $thefile;
        }
    }
}

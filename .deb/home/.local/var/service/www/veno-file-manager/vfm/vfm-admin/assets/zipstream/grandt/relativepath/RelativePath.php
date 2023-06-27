<?php
/**
 * Simple relative path normalizer utility.
 *
 * The utility was inspired by PHP's realPath function, though that required the given path to exist, RelativePath does not.
 * 
 * Particularly useful is you need to parse and normalize paths gathered from for instance URL's and HTML pages.
 *
 * These functions are also included in Zip and ZipStream classes version 1.23 onwards on PHPClasses.org.
 * http://www.phpclasses.org/package/6110 and http://www.phpclasses.org/package/6616 respectively.
 * 
 * License: GNU LGPL, Attribution required for commercial implementations, requested for everything else.
 *
 * @author A. Grandt <php@grandt.com>
 * @copyright 2011 A. Grandt
 * @license GNU LGPL, Attribution required for commercial implementations, requested for everything else.
 * @link http://www.phpclasses.org/package/6844
 * @version 1.01
 */
class RelativePath {
    const VERSION = 1.01;

    /**
     * Join $file to $dir path, and clean up any excess slashes.
     *
     * @author A. Grandt <php@grandt.com>
     * @author Greg Kappatos
     *
     * @param string $dir
     * @param string $file
     *
     * @return string Joined path, with the correct forward slash dir separator.
     */
    public static function pathJoin($dir, $file) {
        return \RelativePath::getRelativePath(
            $dir . (empty($dir) || empty($file) ? '' : DIRECTORY_SEPARATOR) . $file
        );
    }

    /**
     * Clean up a path, removing any unnecessary elements such as /./, // or redundant ../ segments.
     * If the path starts with a "/", it is deemed an absolute path and any /../ in the beginning is stripped off.
     * The returned path will not end in a "/".
     *
     * @param String $path The path to clean up
     * @return String the clean path
     */
    public static function getRelativePath($path) {
        $path = preg_replace("#/+\.?/+#", "/", str_replace("\\", "/", $path));
        $dirs = explode("/", rtrim(preg_replace('#^(\./)+#', '', $path), '/'));
                
        $offset = 0;
        $sub = 0;
        $subOffset = 0;
        $root = "";

        if (empty($dirs[0])) {
            $root = "/";
            $dirs = array_splice($dirs, 1);
        } else if (preg_match("#[A-Za-z]:#", $dirs[0])) {
            $root = strtoupper($dirs[0]) . "/";
            $dirs = array_splice($dirs, 1);
        } 

        $newDirs = array();
        foreach ($dirs as $dir) {
            if ($dir !== "..") {
                $subOffset--;    
                $newDirs[++$offset] = $dir;
            } else {
                $subOffset++;
                if (--$offset < 0) {
                    $offset = 0;
                    if ($subOffset > $sub) {
                        $sub++;
                    } 
                }
            }
        }

        if (empty($root)) {
            $root = str_repeat("../", $sub);
        } 
        return $root . implode("/", array_slice($newDirs, 0, $offset));
    }
}
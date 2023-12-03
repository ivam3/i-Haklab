<?php
/**
 * Manage main actions
 *
 * @category PHP
 * @package  VenoFileManager
 * @author   Nicola Franchini <info@veno.it>
 * @license  Exclusively sold on CodeCanyon
 * @link     http://filemanager.veno.it/
 */
if (!class_exists('Actions', false)) {
    /**
     * Class Actions
     *
     * @category PHP
     * @package  VenoFileManager
     * @author   Nicola Franchini <info@veno.it>
     * @license  Exclusively sold on CodeCanyon
     * @link     http://filemanager.veno.it/
     */
    class Actions
    {
        /**
         * The main function, checks if the user wants to perform any supported operations
         *
         * @param string $location to run
         *
         * @return checks if any action is required
         */
        public function __construct($location = false)
        {
            if (!$location) {
                return false;
            }

            $postnewdir = filter_input(INPUT_POST, 'userdir', FILTER_UNSAFE_RAW);
            $renamedir = filter_input(INPUT_POST, 'newname', FILTER_UNSAFE_RAW);
            $postoldname = filter_input(INPUT_POST, 'oldname', FILTER_UNSAFE_RAW);
            $getdel = filter_input(INPUT_GET, 'del', FILTER_UNSAFE_RAW);

            // delete files or folders
            if ($getdel && GateKeeper::isAllowed('delete_enable')) {

                $decode_del = base64_decode($getdel, true);

                if ($decode_del) {
                    // $getdel = str_replace(' ', '+', urldecode($decode_del));
                    // $getdel = Utils::extraChars($getdel);
                    $getdel = Utils::extraChars(urldecode($decode_del));
                    $this->setDel($getdel);
                } else {
                    Utils::setError('<i class="bi bi-slash-circle"></i> Character encoding error, remove the file via FTP');
                }
            }

            // add new folder
            if ($postnewdir) {
                $dirname = Utils::normalizeStr($postnewdir);
                Actions::newFolder($location, $dirname);
            }
            // rename files or folders 
            if ($renamedir && $postoldname) {
                $this->setRename($postoldname, Utils::normalizeStr($renamedir));
            }
            // Upload files in the old fashioned way ( IE <= 9 & Safari on Windows)
            if (isset($_FILES['userfile']['name'])) {
                Uploader::uploadMulti($_FILES['userfile']);
            }
        }

        /**
         * Check path to delete
         *
         * @param string $path to search
         *
         * @return true/false
         */
        public static function checkDel($path)
        {
            $startdir = SetUp::getConfig('starting_dir');

            $cash = filter_input(INPUT_GET, 'h', FILTER_UNSAFE_RAW);
            $del = filter_input(INPUT_GET, 'del', FILTER_UNSAFE_RAW);

            $del = str_replace(' ', '+', $del);

            if (md5($del.SetUp::getConfig('salt').SetUp::getConfig('session_name')) === $cash) {

                if (GateKeeper::getUserInfo('dir') != null) {
                    $userdirs = json_decode(GateKeeper::getUserInfo('dir'), true);

                    foreach ($userdirs as $value) {
                        $userpath = $startdir.$value;
                        $pos = strpos('./'.$path, $userpath);

                        if ($pos !== false) {
                            return true;
                        }
                    }
                    return false;
                }
                $pos = strpos('./'.$path, $startdir);

                $filepathinfo = Utils::mbPathinfo($path);
                $basepath = $filepathinfo['basename'];
                $evil = array('', '/', '\\', '.');
                $avoid = SetUp::getConfig('hidden_files');

                if ($pos === false
                    || in_array($path, $evil)
                    || in_array($basepath, $avoid)
                    || realpath($path) === realpath($startdir)
                    || realpath($path) === realpath(dirname(__FILE__))
                ) {
                    return false;
                }
                return true;
            }
            return false;
        }

        /**
         * Setup file to delete
         *
         * @param string $getdel path to delete
         *
         * @return call deleteFile()
         */
        public function setDel($getdel)
        {
            global $gateKeeper;
            global $setUp;

            if (Actions::checkDel($getdel) == false) {
                Utils::setError('<i class="bi bi-slash-circle"></i> '.$setUp->getString('not_allowed'));
                return;
            }
            if (is_dir($getdel)) {
                if ($gateKeeper->getUserSpace() !== false) {
                    $ritorno = Utils::getDirSize("./".$getdel);
                    $totalsize = $ritorno['size'];

                    if ($totalsize > 0) {
                        Actions::updateUserSpace(false, true, $totalsize);
                    }
                }
                Actions::deleteDir($getdel);

                Utils::setWarning('<span><i class="bi bi-trash"></i> <strong>'.substr($getdel, strrpos($getdel, '/') + 1).'</strong></span>');
                // Directory successfully deleted, sending log notification
                Logger::logDeletion('./'.$getdel, true);

            } elseif (is_file($getdel)) {
                Actions::deleteFile($getdel);
            }
        }

        /**
         * Delete directory
         *
         * @param string $dir directory to delete
         *
         * @return deletes directory
         */
        public static function deleteDir($dir)
        {
            if (is_dir($dir)) {
                $objects = scandir($dir);
                foreach ($objects as $object) {
                    if ($object != '.' && $object != '..') {
                        if (filetype($dir.'/'.$object) == 'dir') {
                            Actions::deleteDir($dir.'/'.$object);
                        } else {
                            $filetime = filemtime($dir.'/'.$object);
                            $filetime = $filetime ? $filetime : 'no-data';
                            unlink($dir.'/'.$object);
                            Actions::deleteThumb($dir.'/'.$object, $filetime);
                        }
                    }
                }
                reset($objects);
                rmdir($dir);
            }
        }

        /**
         * Delete file
         *
         * @param string $file  file to delete
         * @param bool   $multi delete multiple files
         *
         * @return deletes file
         */
        public static function deleteFile($file, $multi = false)
        {
            if (is_file($file)) {

                Actions::updateUserSpace($file, true);

                $filepathinfo = Utils::mbPathinfo($file);
                $basepath = $filepathinfo['basename'];

                $filetime = filemtime($file);
                $filetime = $filetime ? $filetime : 'no-data';

                if ($multi) {
                    Actions::deleteThumb(substr($file, 6), $filetime, true);
                    Utils::setWarning('<span><i class="bi bi-trash"></i> <strong>'.$basepath.'</strong></span> ');
                    Logger::logDeletion(substr($file, 1), false, true);
                } else {
                    $filetime = filemtime($file);
                    $filetime = $filetime ? $filetime : 'no-data';
                    Actions::deleteThumb($file, $filetime);
                    Utils::setWarning('<span><i class="bi bi-trash"></i> <strong>'.$basepath.'</strong></span>');
                    Logger::logDeletion('./'.$file, false);
                }
                unlink($file);
            }
        }

        /**
         * Setup file renaming
         *
         * @param string $postoldname original file or directory name
         * @param string $postnewname new file or directory name
         *
         * @return call renameFile();
         */
        public function setRename($postoldname, $postnewname)
        {
            if (GateKeeper::isAccessAllowed()
                && GateKeeper::isAllowed('rename_enable')
            ) {
                $postthisext = filter_input(INPUT_POST, "thisext", FILTER_UNSAFE_RAW);
                $postthisdir = filter_input(INPUT_POST, "thisdir", FILTER_UNSAFE_RAW);

                if ($postoldname && $postnewname) {
                    if ($postthisext) {
                        $oldname = $postthisdir.$postoldname.".".$postthisext;
                        $newname = $postthisdir.Utils::normalizeStr($postnewname).".".$postthisext;
                    } else {
                        $oldname = $postthisdir.$postoldname;
                        $newname = $postthisdir.Utils::normalizeStr($postnewname);
                    }
                    Actions::renameFile($oldname, $newname, $postnewname);
                }
            }
        }

        /**
         * Rename files
         *
         * @param string $oldname    original file path
         * @param string $newname    new file path
         * @param string $thenewname new name
         * @param bool   $move       move file
         * @param bool   $copy       copy file
         *
         * @return boolean
         */
        public static function renameFile($oldname, $newname, $thenewname, $move = false, $copy = false)
        {
            global $setUp;

            $oldname = Utils::extraChars($oldname);
            $newname = Utils::extraChars($newname);

            if (!file_exists($oldname)) {
                Utils::setError('<span><i class="bi bi-exclamation-circle"></i> <strong>' .$oldname. '</strong> does not exist</span>');
                return false;
            }

            if (Utils::fileExists($newname)) {
                Utils::setWarning('<span><i class="bi bi-info-circle"></i> <strong>' .$thenewname. '</strong> '.$setUp->getString('file_exists').'</span>');
                return false;
            }

            if ($copy) {
                if (!copy($oldname, $newname)) {
                    Utils::setError('<span><i class="bi bi-exclamation-circle"></i> <strong>' .$thenewname. '</strong> can\'t be copied</span>');
                    return false;
                } else {
                    Actions::updateUserSpace($oldname);
                    return true;
                }
            } else {
                $filetime = filemtime($oldname);
                $filetime = $filetime ? $filetime : 'no-data';
                $delfilename = $move ? substr($oldname, 6) : substr($oldname, 3);

                if (!rename($oldname, $newname)) {
                    Utils::setError('<span><i class="bi bi-exclamation-circle"></i> <strong>' .$thenewname. '</strong> can\'t be edited</span>');
                    return false;
                } else {
                    if ($move) {
                        // Delete old thumbnail
                        Actions::deleteThumb($delfilename, $filetime, true);
                    } else {
                        // Simple name change
                        Utils::setSuccess('<span><strong>'.$thenewname. '</strong> '.$setUp->getString('updated').'</span>');
                        Actions::deleteThumb($oldname, $filetime);  
                    }
                    return true;
                }
            }
        }

        /**
         * Show available directories
         *
         * @param string $dir        base path
         * @param string $currentdir current directory browsing
         * @param bool   $link       set link or data-dest
         * @param string $relative   relative path '../.' to be called from /vfm-admin/ajax/ instead of '' from index
         *
         * @return directories tree
         */
        public static function walkDir($dir, $currentdir, $link = false, $relative = '')
        {
            $output = false;

            $relativedir = $relative.$dir;

            if (is_dir($relativedir)) {
                $scandir = glob($relativedir.'*', GLOB_ONLYDIR);

                natcasesort($scandir);

                $output = '<ul>';

                foreach ($scandir as $folder) {
                    $filepathinfo = Utils::mbPathinfo($folder);
                    $file = $filepathinfo['basename'];
                    // $file = basename($folder);

                    if ($relativedir.$file == $relative.'./vfm-admin' || substr($file, 0, 1) == '.') {
                        continue;
                    }

                    if (is_dir($relativedir.$file)) {
                        $output .= '<li>';

                        if ($relativedir.$file."/" == $relative.$currentdir) {
                            $output .= '<i class="bi bi-folder2-open"></i> <span class="search-highlight">'.$file.'</span>';
                        } else {
                            if ($link) {
                                $output .= '<a href="?dir='.ltrim($dir.$file, './').'">';
                            } else {
                                $output .= '<a href="#" data-dest="'.urlencode('./'.ltrim($dir.$file, './')).'" class="movelink">';
                            }
                            $output .= '<i class="bi bi-folder"></i> '.$file.'</a>';
                        }

                        $scansub = glob($relativedir.$file.'/'.'*', GLOB_ONLYDIR);

                        if (count($scansub) > 0) {
                            $output .= '<span class="toggle-tree"><i class="bi bi-dash-square tree-toggler bg-lighter"></i></span>';
                            $output .= Actions::walkDir($relativedir.$file.'/', $relative.$currentdir, $link);
                        }
                        $output .= '</li>';
                    }
                }
                $output .= '</ul>';
            }
            return $output;
        }

        /**
         * Create new folder
         *
         * @param string $location where to create new folder
         * @param string $dirname  new dir name
         *
         * @return adds new folder
         */
        public static function newFolder($location, $dirname)
        {
            global $setUp;

            if (GateKeeper::isAllowed('newdir_enable')) {
                if (strlen($dirname) > 0) {

                    if (!$location->editAllowed()) {
                        // The system configuration does not allow uploading here
                        Utils::setError($setUp->getString('upload_not_allowed'));
                        return false;
                    }
                    if (!$location->isWritable()) {
                        // The target directory is not writable
                        Utils::setError($setUp->getString('upload_dir_not_writable'));
                        return false;
                    }
                    if (Utils::fileExists($location->getDir(true, false, false, 0).$dirname)) {
                        Utils::setWarning(
                            '<span><i class="bi bi-folder"></i> <strong>'.$dirname.'</strong> '
                            .$setUp->getString('file_exists').'</span>'
                        );
                        return false;
                    }
                    if (!mkdir($location->getDir(true, false, false, 0).$dirname, 0755)) {
                        // Error creating a new directory
                        Utils::setError($setUp->getString('new_dir_failed'));
                        return false;
                    }
                    Utils::setSuccess(
                        '<span><i class="bi bi-folder"></i> <strong>'.$dirname.'</strong> '
                        .$setUp->getString('created').'</span>'
                    );
                    // Directory successfully created, sending e-mail notification
                    Logger::logCreation($location->getDir(true, false, false, 0).$dirname, true);
// Redirect to the new folder.
// header('Location:'.$setUp->getConfig('script_url')."?dir=".$location->getDir(false, false, false, 0).$dirname);
                    return true;
                }
                Utils::setError($setUp->getString('new_dir_failed'));
                return false;
            }
        }

        /**
         * Delete thumbnail
         *
         * @param string $file     file to delete
         * @param string $filetime file time
         * @param bool   $multi    called from vfm-del.php or vfm-move.php
         *
         * @return deletes thumb
         */
        public static function deleteThumb($file, $filetime = 'no-data', $multi = false)
        {
            if ($multi == false) {
                $relativepath = 'vfm-admin/';
            } else {
                $relativepath = '../';
            }
            $thumbdir = $relativepath.'_content/thumbs/';

            $thumbname = md5($file.$filetime);

            $thumb = $thumbdir.$thumbname.'.jpg';
            $thumb_big = $thumbdir.$thumbname.'-big.jpg';

            if (is_file($thumb)) {
                unlink($thumb);
            }
            if (is_file($thumb_big)) {
                unlink($thumb_big);
            }
        }

        /**
         * Check if user has space to upload
         *
         * @param string $file     file to check
         * @param int    $thissize size to check
         * @param bool   $upload   uploaded file
         *
         * @return true/false
         */
        public static function checkUserSpace($file = false, $thissize = false, $upload = false)
        {
            global $setUp;

            if ($upload) {
                $max_upload_filesize = $setUp->getConfig('max_upload_filesize');
                if ($max_upload_filesize > 0) {
                    $max_upload_filesize = ($max_upload_filesize*1024*1024);
                    if (!$thissize && $file) {
                        $thissize = Utils::getFileSize($file);
                    }
                    if ($thissize > $max_upload_filesize) {
                        return false;
                    }
                }
            }

            if (isset($_SESSION['vfm_user_used'])
                && isset($_SESSION['vfm_user_space'])
            ) {
                if (!$thissize && $file) {
                    $thissize = Utils::getFileSize($file);
                }
                $oldused = $_SESSION['vfm_user_used'];
                $newused = $oldused + $thissize;
                $freespace = $_SESSION['vfm_user_space'];
                
                if ($newused > $freespace) {
                    return false;
                }
            }
            return true;
        }

        /**
         * Update user used space by file (add or subtract)
         *
         * @param string  $file file to add/subtract
         * @param boolean $add  true/false add or subtract
         * @param int     $size size to add/subtract
         *
         * @return updates total used space
         */
        public static function updateUserSpace($file = false, $add = false, $size = false)
        {
            if (isset($_SESSION['vfm_user_used'])) {

                $thissize = ($size && !$file) ? $size : Utils::getFileSize($file);
                $usedspace = $_SESSION['vfm_user_used'];

                if ($add) {
                    $usedspace = (abs($usedspace) - abs($thissize));
                } else {
                    $usedspace = (abs($usedspace) + abs($thissize));
                }
                $_SESSION['vfm_user_used'] = $usedspace;
            }
        }
    }
}

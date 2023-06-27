<?php
/**
 * Manage zip archives
 *
 * @category PHP
 * @package  VenoFileManager
 * @author   Nicola Franchini <info@veno.it>
 * @license  Exclusively sold on CodeCanyon
 * @link     http://filemanager.veno.it/
 */
if (!class_exists('Zipper', false)) {
    /**
     * Zipper class
     *
     * @category PHP
     * @package  VenoFileManager
     * @author   Nicola Franchini <info@veno.it>
     * @license  Exclusively sold on CodeCanyon
     * @link     http://filemanager.veno.it/
     */
    class Zipper
    {
        /**
         * Prepare ZIP archive
         *
         * @param array  $files  files array to download
         * @param string $folder folder path or false
         *
         * @return file served
         */
        public function prepareZip(
            $files = false,
            $folder = false
        ) {
            $response = array('error' => false);

            // create /tmp/ folder if needed
            $temp_path = dirname(dirname(__FILE__)).'/tmp';
            if (!is_dir($temp_path)) {
                if (!mkdir($temp_path, 0755, true)) {
                    $response['error'] = 'Cannot create a tmp dir for .zip files';
                    return $response;
                }
            }

            global $setUp;

            $time = time();
            $json_name = md5($folder.$time);
            $hash = md5($setUp->getConfig('salt').$time);

            $starting_dir = $setUp->getConfig('starting_dir');
            $cleanpath = dirname(dirname(dirname(__FILE__))).'/'.ltrim($starting_dir, './');

            $filesarray = array();

            if ($files && is_array($files)) {
                $response['name'] = 'zip-'.$time.'.zip';
                foreach ($files as $pezzo) {
                    // Keep files inside main dir and avoid tricky injections.
                    $cleanfile = $setUp->sanitizePath(urldecode(base64_decode($pezzo)));
                    if (realpath($cleanpath.$cleanfile)) {
                        $filesarray[] = $cleanfile;
                    }
                }
            }

            if ($folder) {
                $cleanfolder = $setUp->sanitizePath($folder);
                if (realpath($cleanpath.$cleanfolder)) {
                    $folder = $cleanfolder;
                } else {
                    $folder = false;
                }
                $folderpathinfo = Utils::mbPathinfo($cleanfolder);
                $archivename = Utils::checkMagicQuotes($folderpathinfo['filename']);
                $response['name'] = $archivename.'.zip';
            }

            $saveData = array(
                'time' => $time,
                'hash' => $hash,
                'dir' => $folder,
                'files' => $filesarray,
            );

            // save dowloadable link if it does not already exists
            if (!file_exists($temp_path.'/'.$json_name.'.json')) {
                $fp = fopen($temp_path.'/'.$json_name.'.json', 'w');
                fwrite($fp, json_encode($saveData));
                fclose($fp);
            }

            // Delete tmp file if is older than 48 hours
            $oldtmp = glob($temp_path.'/*');
            foreach ($oldtmp as $oldfile) {
                if (is_file($oldfile)) {
                    if (filemtime($oldfile) < time() - 60*60*48) {
                        unlink($oldfile);
                    }
                }
            }

            $response['json'] = $json_name;
            $response['supah'] = md5($time.$hash);

            return $response;
        }

        // /**
        //  * Create ZIP archive DEPRECATED since vfm 4.0.0
        //  *
        //  * @param array  $files    files array to download
        //  * @param string $folder   folder path or false
        //  * @param string $relative specific path for logging
        //  *
        //  * @return file served
        //  */
        // public function createZip(
        //     $files = false,
        //     $folder = false,
        //     $relative = ''
        // ) {
        //     $response = array('error' => false);

        //     global $setUp;

        //     @set_time_limit(0);

        //     $maxfiles = $setUp->getConfig('max_zip_files');
        //     $maxfilesize = $setUp->getConfig('max_zip_filesize');
        //     $starting_dir = $setUp->getConfig('starting_dir');
        //     $maxbytes = $maxfilesize*1024*1024;

        //     if ($files && is_array($files)) {
        //         $totalsize = 0;
        //         $filesarray = array();
        //         foreach ($files as $pezzo) {
        //             // Keep files inside main dir and avoid tricky injections.
        //             $cleanfile = ltrim(urldecode(base64_decode($pezzo)), './');
        //             if ($starting_dir == './') {
        //                 $cleanfile = ltrim($cleanfile, 'vfm-admin/');
        //             }
        //             $myfile = "../../".$cleanfile;
        //             if (file_exists($myfile)) {
        //                 $totalsize = $totalsize + Utils::getFileSize($myfile);
        //                 array_push($filesarray, $myfile);
        //             }
        //         }
        //         $howmany = count($filesarray);
        //     }

        //     if ($folder) {

        //         $folder = ltrim($folder, './');
        //         if ($starting_dir == './') {
        //             $folder = ltrim($folder, 'vfm-admin/');
        //         }

        //         $folderpath = "../../".$folder;

        //         if (!is_dir($folderpath)) {
        //             $response['error'] = '<strong>'.$folder.'</strong> does not exist';
        //             return $response;
        //         }

        //         $folderpathinfo = Utils::mbPathinfo($folder);
        //         $folderbasename = Utils::checkMagicQuotes($folderpathinfo['filename']);

        //         // Create recursive directory iterator
        //         $filesarray = new RecursiveIteratorIterator(
        //             new RecursiveDirectoryIterator($folderpath),
        //             RecursiveIteratorIterator::LEAVES_ONLY
        //         );
        //         $foldersize = Utils::getDirSize($folderpath);
        //         $totalsize = $foldersize['size'];
        //         $howmany = 0;
        //         foreach ($filesarray as $piece) {
        //             if (!is_dir($piece)) {
        //                 $howmany++;
        //             }
        //         }
        //     }

        //     $response['totalsize'] = $totalsize;
        //     $response['numfiles'] = $howmany;

        //     // skip if size or number exceedes
        //     if ($totalsize > $maxbytes) {
        //         $response['error'] = '<strong>'.$setUp->formatsize($totalsize).'</strong>: '
        //         .$setUp->getString('size_exceeded').'<br>(&lt; '.$setUp->formatsize($maxbytes).')';
        //         return $response;
        //     }
        //     if ($howmany > $maxfiles) {
        //         $response['error'] = '<strong>'.number_format($howmany).'</strong>: '
        //         .$setUp->getString('too_many_files').' '.number_format($maxfiles);
        //         return $response;
        //     }

        //     if ($howmany < 1) {
        //         $response['error'] = '<i class="bi bi-files"></i> - <strong>0</strong>';
        //         return $response;
        //     }
        //     // create /tmp/ folder if needed
        //     if (!is_dir($relative.'tmp')) {
        //         if (!mkdir('tmp', 0755)) {
        //             $response['error'] = 'Cannot create a tmp dir for .zip files';
        //             return $response;
        //         }
        //     }

        //     // create temp zip
        //     $file = tempnam($relative.'tmp', 'zip_');

        //     if (!$file) {
        //         $response['error'] = 'Cannot create: tempnam("tmp","zip") from createZip()';
        //         return $response;
        //     }

        //     $zip = new ZipArchive();

        //     if ($zip->open($file, ZipArchive::OVERWRITE) !== true) {
        //         $response['error'] = 'cannot open: '.$file;
        //         return $response;
        //     }

        //     session_write_close();

        //     $counter = 0;
        //     $logarray = array();

        //     foreach ($filesarray as $piece) {

        //         $filepathinfo = Utils::mbPathinfo($piece);
        //         $basename = Utils::checkMagicQuotes($filepathinfo['filename']).'.'.$filepathinfo['extension'];

        //         // Skip directories (they would be added automatically)
        //         if (!is_dir($piece) && file_exists($piece)) {
        //             $counter++;
        //             if ($counter > 100) {
        //                 $zip->close();
        //                 $zip->open($file, ZipArchive::CHECKCONS);
        //                 $counter = 0;
        //             }
        //             // Add current file to archive
        //             if ($folder) {
        //                 $relativePath = substr($piece, strlen($folderpath));
        //                 $zip->addFile($piece, $relativePath);
        //             } else {
        //                 $zip->addFile($piece, $basename);
        //                 array_push($logarray, './'.ltrim($piece, './'));
        //             }
        //         }
        //     }
        //     $zip->close();

        //     // delete tmp file if is older than 4 hours
        //     $oldtmp = glob($relative.'tmp/*');
        //     foreach ($oldtmp as $oldfile) {
        //         if (is_file($oldfile)) {
        //             if (filemtime($oldfile) < time() - 60*60*4) {
        //                 unlink($oldfile);
        //             }
        //         }
        //     }

        //     $response['dir'] = $folder;
        //     $response['file'] = basename($file);

        //     if ($folder) {
        //         array_push($logarray, './'.ltrim($folder, './'));
        //     }
        //     $response['logarray'] = $logarray;
        //     return $response;
        // }
    }
}

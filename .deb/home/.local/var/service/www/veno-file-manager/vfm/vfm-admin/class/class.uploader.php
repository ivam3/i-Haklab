<?php
/**
 * Uploader class
 * managed by chunk.php
 *
 * @category PHP
 * @package  VenoFileManager
 * @author   Nicola Franchini <info@veno.it>
 * @license  Exclusively sold on CodeCanyon
 * @link     http://filemanager.veno.it/
 */
if (!class_exists('Uploader', false)) {
    /**
     * Uploader class
     *
     * @category PHP
     * @package  VenoFileManager
     * @author   Nicola Franchini <info@veno.it>
     * @license  Exclusively sold on CodeCanyon
     * @link     http://filemanager.veno.it/
     */
    class Uploader
    {
        /**
         * Verify a file to be uploaded
         *
         * @param string  $fullfilepath path to final upload
         * @param inft    $filesize     the final size
         * @param boolean $remote       if remote check also remote_extensions
         *
         * @return error response
         */
        public static function veryFile($fullfilepath, $filesize, $remote = false)
        {
            $filepathinfo = Utils::mbPathinfo($fullfilepath);
            $filename = $filepathinfo['filename'];
            $basename = $filepathinfo['basename'];
            $extension = strtolower(Utils::getFileExtension($fullfilepath));
            $allowed_ext = $remote ? SetUp::getConfig('remote_extensions') : SetUp::getConfig('upload_allow_type');
            $rejected_ext = $remote ? array() : SetUp::getConfig('upload_reject_extension');
            $rejected_files = SetUp::getConfig('hidden_files');
            $upload_limit = SetUp::getConfig('max_upload_filesize');

            if (!$extension) {
                Utils::setError('<span><i class="bi bi-exclamation-triangle"></i> <strong>'.$basename.'</strong>: '.SetUp::getLangString('file_extension_missing').'</span> ');
                return false;
            }

            if ((!$allowed_ext && !$rejected_ext)
                || ($allowed_ext && !Utils::inList($extension, $allowed_ext))
                || ($rejected_ext && Utils::inList($extension, $rejected_ext))
                || Utils::inList($basename, $rejected_files)
                || substr($basename, 0, 1) === "."
            ) {
                Utils::setError('<span><i class="bi bi-exclamation-triangle"></i> '.$filename.'<strong>.'.$extension.'</strong> '.SetUp::getLangString('not_allowed').'</span> ');
                return false;
            }

            if (Utils::fileExists($fullfilepath)) {
                if (!SetUp::getConfig('overwrite_files') || SetUp::getConfig('overwrite_files') == 'no') {
                    Utils::setWarning('<span><i class="bi bi-info-circle"></i> <strong>'.$basename.'</strong> '.SetUp::getLangString('file_exists').'</span> ');
                    return false;
                }

                // Utils::setWarning('<span><i class="bi bi-info-circle"></i> <strong>'.$basename.'</strong> '.SetUp::getLangString('file_exists').'</span> ');
                // return false;
            }

            if (Actions::checkUserSpace(false, $filesize, true) === false) {
                $max_upload_response = $upload_limit > 0 ? 'max '.$upload_limit.' MB' : $basename;
                Utils::setError(
                    '<span><i class="bi bi-exclamation-triangle"></i> '.SetUp::getLangString('upload_exceeded').': <strong>'.$max_upload_response.'</strong></span> '
                );
                return false;
            }
            return true;
        }

        /**
         * Append .txt to extension
         *
         * @param string $name      name to modify
         * @param string $extension extension to check
         *
         * @return string $name filename with .txt appended
         */
        public static function safeExtension($name, $extension)
        {
            $evil = array(
                'php','php3','php4','php5','htm','html','phtm','phtml',
                'shtm','shtml','asp','pl','py','jsp','sh','cgi','htaccess',
                'htpasswd','386','bat','cmd','pl','ddl','bin', 'asa', 'cer', 'xap',
                );
            if (in_array(strtolower($extension), $evil)) {
                $name = $name.'.txt';
            }
            return $name;
        }

        /**
         * Setup filename to upload
         *
         * @param string $resumableFilename filename to convert
         *
         * @return resumableFilename updated
         */
        public function setupFilename($resumableFilename)
        {
            $extension = Utils::getFileExtension($resumableFilename);
            $filepathinfo = Utils::mbPathinfo($resumableFilename);
            $basename = Utils::normalizeStr(Utils::checkMagicQuotes($filepathinfo['filename']));
            $resumableFilename = $basename.'.'.$extension;

            //  Append date-time to file name.
            if (SetUp::getConfig('overwrite_files') == 'date' ) {
                $resumableFilename = $basename.'_'.date('Y-m-d_G-i-s').'.'.$extension;
            }

            // $resumableFilename = $basename.'_'.date('Y-m-d_G-i-s').'.'.$extension;
            $resumabledata = array();
            $resumabledata['extension'] = $extension;
            $resumabledata['basename'] = $basename;
            $resumabledata['filename'] = $resumableFilename;

            return $resumabledata;
        }

        /**
         * Check if all the parts exist, and
         *
         * @param string $temp_dir             the temporary directory holding all the parts of the file
         * @param int    $totalSize            original file size (in bytes)
         * @param int    $chunkSize            chunk size (in bytes)
         * @param int    $resumableTotalChunks total chunk number
         *
         * @return uploaded file
         */
        public function checkChunks($temp_dir, $totalSize, $chunkSize, $resumableTotalChunks)
        {
            // count all the parts of this file
            $tempfiles = preg_grep('/^([^.])/', scandir($temp_dir));

            if (is_array($tempfiles)) {
                $total_files = count($tempfiles);

                if ($total_files === $resumableTotalChunks) {
                    if ($total_files * $chunkSize >= ($totalSize - $chunkSize + 1)) {
                        return true;
                    }
                }
            }
            return false;
        }

        /**
         * Gather all the parts of the file together
         *
         * @param string $destination the final destination
         * @param string $temp_dir    the temporary directory holding all the parts of the file
         * @param string $fileName    the original file name
         * @param string $totalSize   original file size (in bytes)
         * @param string $totalChunks total chunks number
         * @param string $logloc      relative location for log file
         *
         * @return uploaded file
         */
        public function createFileFromChunks($destination, $temp_dir, $fileName, $totalSize, $totalChunks, $logloc)
        {
            if (Uploader::veryFile($fileName, $totalSize) !== true) {
                Actions::deleteDir($temp_dir);
                return false;
            }

            $upload_dir = str_replace('\\', '', $destination);
            $extension = Utils::getFileExtension($fileName);
            $finalfile = Uploader::safeExtension($fileName, $extension);

            if (file_exists($upload_dir.$finalfile) && (!SetUp::getConfig('overwrite_files') || SetUp::getConfig('overwrite_files') == 'no')) {
                Utils::setWarning('<span><i class="bi bi-info-circle"></i> <strong>'.$fileName.'</strong> '.SetUp::getLangString('file_exists').'</span> ');
                if (rename($temp_dir, $temp_dir.'_UNUSED')) {
                    Actions::deleteDir($temp_dir.'_UNUSED');
                } else {
                    Actions::deleteDir($temp_dir);
                }
                return false;
            }

            // create the final file
            if (is_dir($upload_dir) && ($openfile = fopen($upload_dir.$finalfile, 'w')) !== false) {
                // $log_start_time = microtime(true);
                
                for ($i=1; $i<=$totalChunks; $i++) {
                    /*
                    * Old method higher memory usage
                    */
                    // $logmethod = 'chunked fwrite';
                    // if (($stream_chunk = fopen($temp_dir.'/'.$fileName.'.part'.$i, 'r')) !== false) {
                    //     while (!feof($stream_chunk)) {
                    //         fwrite($openfile, fread($stream_chunk, 1048576));
                    //     }
                    // }
                    /*
                    * stream_copy_to_stream method lower memory usage
                    */
                    // $logmethod = 'stream copy';
                    if (($stream_chunk = fopen($temp_dir.'/'.$fileName.'.part'.$i, 'r')) !== false) {
                        stream_copy_to_stream($stream_chunk, $openfile);
                        fclose($stream_chunk);
                    }
                }

                fclose($openfile);

                // track upload performance
                // $this->logUpload($log_start_time, $logmethod, $totalSize);

                // rename the temporary directory (to avoid access from other concurrent chunks uploads) and then delete it
                if (rename($temp_dir, $temp_dir.'_UNUSED')) {
                    Actions::deleteDir($temp_dir.'_UNUSED');
                } else {
                    Actions::deleteDir($temp_dir);
                }
                Utils::setSuccess(' <span><i class="bi bi-check-circle"></i> <strong>'.$finalfile.'</strong></span> ');
                Actions::updateUserSpace(false, false, $totalSize);
                Logger::logCreation($logloc.$finalfile, false);

            } else {
                Utils::setError(' <span><i class="bi bi-exclamation-triangle"></i> cannot create the destination file inside <strong>'.basename($upload_dir).'</strong></span>');
                return false;
            }
        }

        /**
         * Track upload performance
         *
         * @param int    $log_start_time intial function time
         * @param string $logmethod      method used
         * @param string $totalSize      total file size
         *
         * @return the size of the remote file
         */
        public function logUpload($log_start_time, $logmethod, $totalSize)
        {
            $log_elapsed = (microtime(true) - $log_start_time);
            $log = PHP_EOL.'********************************************'.PHP_EOL;
            $log = date('d/m/Y - G:i:s').PHP_EOL;
            $log .= 'Method: '.$logmethod.PHP_EOL;
            $log .= 'File size: '.($totalSize/1024/1024).' MB'.PHP_EOL;
            $log .= 'Memory: '.(memory_get_usage(true)/1024/1024).' MB'.PHP_EOL;
            $log .= 'Memory peak: '.(memory_get_peak_usage(true)/1024/1024).' MB'.PHP_EOL;
            $log .= 'Elapsed time: '.$log_elapsed.PHP_EOL;

            $log .= '********************************************'.PHP_EOL.PHP_EOL;
            file_put_contents('vfm_uploader_log.txt', $log, FILE_APPEND);
        }

        /**
         * Get size of remote file
         *
         * @param string $url Url to check
         *
         * @return the size of the remote file
         */
        public function getRemoteSize($url)
        {
            $totalsize = false;
            $avoid = false;
         
            if (filter_var($url, FILTER_VALIDATE_URL)) {
                $cinit = curl_init();
                curl_setopt_array(
                    $cinit,
                    array(
                        CURLOPT_URL => $url,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_HEADER => true,
                        CURLOPT_NOBODY => true,
                        CURLOPT_SSL_VERIFYPEER => false,
                        CURLOPT_FOLLOWLOCATION => false,
                    )
                );

                $data = curl_exec($cinit);

                if (curl_error($cinit)) {
                    Utils::setError(curl_error($cinit));
                } else {
                    // Check if response is OK
                    $httpCode = curl_getinfo($cinit, CURLINFO_HTTP_CODE);
                    if ($httpCode !== 200) {
                        $message = Uploader::getHeaderError($data);
                        Utils::setError(' <span><i class="bi bi-exclamation-triangle"></i> '.$message.'</span>');
                        $avoid = true;
                    }
                    // Check if is not a web page
                    $type = curl_getinfo($cinit, CURLINFO_CONTENT_TYPE);
                    $htmltype = strpos(strtolower($type), 'text/html');
                    if ($htmltype !== false) {
                        Utils::setError(' <span><i class="bi bi-exclamation-triangle"></i> '.SetUp::getLangString('invalid_link').'</span>');
                        $avoid = true;
                    }
                    if (!$avoid) {
                        $totalsize = curl_getinfo($cinit, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
                    }
                }
                curl_close($cinit);
            }
            return $totalsize;
        }

        /**
         * Prepare multiple files for upload in the classic way
         *
         * @param array $coda $_FLES['userfile']
         *
         * @return call uploadFIle()
         */
        public static function uploadMulti($coda)
        {
            global $location;
            if ($location->editAllowed()
                && GateKeeper::isAllowed('upload_enable')
            ) {
                // Number of files to uploaded
                $num_files = count($coda['tmp_name']);
                $totnames = array();
                for ($i=0; $i < $num_files; $i++) {
                    $filepathinfo = Utils::mbPathinfo($coda['name'][$i]);

                    $filename = $filepathinfo['filename'];
                    $filex = $filepathinfo['extension'];
                    $thename = $filepathinfo['basename'];
                    $tempname = $coda['tmp_name'][$i];
                    $filerror = $coda['error'][$i];
                    $size = $coda['size'][$i];

                    if (in_array($thename, $totnames)) {
                        $thename = $filename.$i.".".$filex;
                    }
                    array_push($totnames, $thename);

                    if ($thename) {
                        Uploader::uploadFile($location, $thename, $tempname, $size);
                        // check uplad errors
                        Uploader::upLog($filerror);
                    }
                }
            }
        }

        /**
         * Upload single file
         *
         * @param string $location where to upload
         * @param string $thename  file name
         * @param string $tempname temp name
         * @param int    $size     file size
         *
         * @return uploads file
         */
        public static function uploadFile($location, $thename, $tempname, $size)
        {
            global $setUp;

            $extension = Utils::getFileExtension($thename);
            $filepathinfo = Utils::mbPathinfo($thename);
            $name = Utils::normalizeStr($filepathinfo['filename']).'.'.$extension;
            $upload_dir = $location->getFullPath();
            $upload_file = $upload_dir.$name;

            if (!$location->editAllowed() || !$location->isWritable()) {
                Utils::setError('<span><i class="bi bi-exclamation-triangle"></i> '.$setUp->getString('upload_not_allowed').'</span> ');
                return false;
            }

            if (Uploader::veryFile($upload_file, $size) == true) {
                $clean_file = $upload_dir.Uploader::safeExtension($name, $extension);
      
                if (!is_uploaded_file($tempname)) {
                    Utils::setError($setUp->getString('failed_upload'));

                } elseif (!move_uploaded_file($tempname, $clean_file)) {
                    Utils::setError($setUp->getString('failed_move'));

                } else {
                    Utils::setSuccess('<span><i class="bi bi-check-circle"></i> <strong>'.$name.'</strong></span> ');
                    // file successfully uploaded, sending log notification
                    Logger::logCreation($location->getDir(true, false, false, 0).$name, false);
                }
            }
        }

        /**
         * Add log uploading errors to old html uploader
         *
         * @param num $filerr array value of $_FILES['userfile']['error'][$i]
         *
         * @return error response
         */
        public static function upLog($filerr)
        {
            $error_types = array(
            0=>'OK',
            1=>'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
            2=>'The uploaded file exceeds the MAX_FILE_SIZE specified in the HTML form.',
            3=>'The uploaded file was only partially uploaded.',
            4=>'No file was uploaded.',
            6=>'Missing a temporary folder.',
            7=>'Failed to write file to disk.',
            8=>'A PHP extension stopped the file upload.',
            'post_max_size' => 'The uploaded file exceeds the post_max_size directive in php.ini',
            'max_file_size' => 'File is too big',
            'min_file_size' => 'File is too small',
            'accept_file_types' => 'Filetype not allowed',
            'max_number_of_files' => 'Maximum number of files exceeded',
            'max_width' => 'Image exceeds maximum width',
            'min_width' => 'Image requires a minimum width',
            'max_height' => 'Image exceeds maximum height',
            'min_height' => 'Image requires a minimum height',
            'abort' => 'File upload aborted',
            'image_resize' => 'Failed to resize image'
            );

            $error_message = $error_types[$filerr];
            if ($filerr > 0) {
                Utils::setError(' :: '.$error_message);
            }
        }

        /**
         * Get first header from remote file data
         *
         * @param string $data to parse
         *
         * @return error response
         */
        public static function getHeaderError($data)
        {
            list($header, $body) = explode("\r\n\r\n", $data, 2);
            $header = explode("\r\n", $header);
            return $header[0];
        }

        /**
         * Remove query string
         *
         * @param string $url url to modify
         *
         * @return string $Return url without ?...=
         */
        public static function removeQueryString($url)
        {
            $parts = explode('?', $url);
            return $parts[0];
        }
    }
}

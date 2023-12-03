<?php
/**
 * Manage file downloading
 *
 * @category PHP
 * @package  VenoFileManager
 * @author   Nicola Franchini <info@veno.it>
 * @license  Exclusively sold on CodeCanyon
 * @link     http://filemanager.veno.it/
 */
if (!class_exists('Downloader', false)) {
    /**
     * Downloader class
     *
     * @category PHP
     * @package  VenoFileManager
     * @author   Nicola Franchini <info@veno.it>
     * @license  Exclusively sold on CodeCanyon
     * @link     http://filemanager.veno.it/
     */
    class Downloader
    {
        /**
         * Checks if file is under user folder
         *
         * @param string $checkPath path to check
         *
         * @return true/false
         */
        public function subDir($checkPath)
        {
            global $gateKeeper;

            if ($gateKeeper->getUserInfo('dir') == null) {
                return true;
            } else {
                $userdirs = json_decode($gateKeeper->getUserInfo('dir'), true);
                foreach ($userdirs as $value) {
                    $pos = strpos($checkPath, $value);
                    if ($pos !== false) {
                        return true;
                    }
                }
            }
            return false;
        }

        /**
         * The safe way
         *
         * @param string $checkfile file to check
         * @param string $path      relative path to call the functionf from /ajax/
         *
         * @return true/false
         */
        public function checkFile($checkfile, $path = '')
        {
            global $setUp;
            $fileclean = ltrim(base64_decode($checkfile), './');
            $file = $path.'../'.ltrim(urldecode($fileclean), './');

            $filepathinfo = Utils::mbPathinfo($fileclean);

            $filename = $filepathinfo['basename'];
            $safedir = $filepathinfo['dirname'];
            $safedir = str_replace(array('/', '.'), '', $safedir);
            $realfile = realpath($file);

            $realsetup = realpath($path.'.'.$setUp->getConfig('starting_dir'));

            $avoidDir = array('vfm-admin', 'etc');
            // $avoidFile = array('index.php', 'vfm-thumb.php', '.htaccess', '.htpasswd');
            $avoidFile = $setUp->getConfig('hidden_files');

            if (strpos($realfile, $realsetup) !== false
                && !in_array($safedir, $avoidDir) 
                && !in_array($filename, $avoidFile)
                && file_exists($file)
            ) {
                return true;
            }
            return false;
        }

        /**
         * Check download lifetime
         *
         * @param string $time time to check
         *
         * @return true/false
         */
        public function checkTime($time)
        {
            global $setUp;

            $lifedays = (int)$setUp->getConfig('lifetime');
            $lifetime = 86400 * $lifedays;
            if (time() <= $time + $lifetime) {
                return true;
            }
            return false;
        }

        /**
         * Get file info before processing download
         *
         * @param string $getfile file to download
         * @param string $playmp3 check audio
         *
         * @return $headers array
         */
        public function getHeaders($getfile, $playmp3 = false)
        {
            $headers = array();

            $audiofiles = array('mp3','wav', 'flac', 'aac');
            $trackfile = './'.urldecode(base64_decode($getfile));
            $file = '.'.$trackfile;

            $filepathinfo = Utils::mbPathinfo($file);
            $filename = $filepathinfo['basename'];
            $dirname = $filepathinfo['dirname'].'/';
            $ext = $filepathinfo['extension'];
            $file_size = Utils::getFileSize($file);
            // $disposition = 'inline';
            $disposition = 'attachment';
            $content_type = 'application/force-download';

            if (strtolower($ext) == 'pdf') {
                $content_type = 'application/pdf';
                $disposition = 'inline';
            }
            if (strtolower($ext) == 'zip') {
                $content_type = 'application/zip';
            }
            if (in_array(strtolower($ext), $audiofiles) && $playmp3 == 'play') {
                $content_type = 'audio/'.strtolower($ext);
                $disposition = 'inline';
            }
            $headers['file'] = $file;
            $headers['filename'] = $filename;
            $headers['file_size'] = $file_size;
            $headers['content_type'] = $content_type;
            $headers['disposition'] = $disposition;
            $headers['trackfile'] = $trackfile;
            $headers['dirname'] = $dirname;

            return $headers;
        }

        /**
         * Download files
         *
         * @param string $file         path to download
         * @param string $filename     file name
         * @param string $file_size    file size
         * @param string $content_type header content type
         * @param string $disposition  header disposition
         * @param bool   $android      android device
         *
         * @return file served
         */
        public function download(
            $file,
            $filename,
            $file_size,
            $content_type,
            $disposition = 'inline',
            $android = false
        ) {
            // Gzip enabled may set the wrong file size.
            if (function_exists('apache_setenv')) {
                @apache_setenv('no-gzip', 1);
            }
            if (ini_get('zlib.output_compression')) {
                @ini_set('zlib.output_compression', 'Off');
            }
            @set_time_limit(0);
            session_write_close();
            header("Content-Length: ".$file_size);

            if ($android) {
                header("Content-Type: application/octet-stream");
                header("Content-Disposition: attachment; filename=\"".$filename."\"");
            } else {
                header("Content-Type: $content_type");
                header("Content-Disposition: $disposition; filename=\"".$filename."\"");
                // header("Content-Transfer-Encoding: binary");
                header("Expires: -1");
            }
            if (ob_get_level()) {
                ob_end_clean();
            }
            readfile($file);
            return true;
        }
    }
}

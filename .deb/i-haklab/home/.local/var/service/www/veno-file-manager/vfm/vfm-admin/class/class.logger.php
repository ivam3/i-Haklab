<?php
/**
 * Lgging user activity
 *
 * @category PHP
 * @package  VenoFileManager
 * @author   Nicola Franchini <info@veno.it>
 * @license  Exclusively sold on CodeCanyon
 * @link     http://filemanager.veno.it/
 */
if (!class_exists('Logger', false)) {
    /**
     * Class Logger
     *
     * @category PHP
     * @package  VenoFileManager
     * @author   Nicola Franchini <info@veno.it>
     * @license  Exclusively sold on CodeCanyon
     * @link     http://filemanager.veno.it/
     */
    class Logger
    {
        /**
         * Print log file
         *
         * @param string $message the message to log
         * @param string $relpath relative path of log file // DROPPED in favor of dirname()
         *
         * @return $message
         */
        public static function log($message, $relpath = 'vfm-admin/')
        {
            if (SetUp::getConfig('log_file') == true) {

                $logjson = dirname(dirname(__FILE__)).'/_content/log/'.date('Y-m-d').'.json';

                if (Utils::isFileWritable($logjson)) {
                    $message['time'] = date('H:i:s');
                    if (file_exists($logjson)) {
                        $oldlog = json_decode(file_get_contents($logjson), true);
                    } else {
                        $oldlog = array();
                    }

                    $daily = date('Y-m-d');
                    $oldlog[$daily][] = $message;
                    $f = fopen($logjson, 'a');
                    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                        file_put_contents($logjson, json_encode($oldlog, JSON_FORCE_OBJECT));
                    } else {
                        if (flock($f, LOCK_EX | LOCK_NB)) {
                            file_put_contents($logjson, json_encode($oldlog, JSON_FORCE_OBJECT));
                            flock($f, LOCK_UN);
                        }
                    }
                    fclose($f);
                } else {
                    Utils::setError('The script does not have permissions to write inside "/_content/log/" folder. check CHMOD'.$logjson);
                    return;
                }
            }
        }

        /**
         * Log user login
         *
         * @return $message
         */
        public static function logAccess()
        {
            $message = array(
                'user' => GateKeeper::getUserInfo('name'),
                'action' => 'log_in',
                'type' => '',
                'item' => 'IP: '.Logger::getClientIP(),
            );
            Logger::log($message);
            if (SetUp::getConfig('notify_login')) {
                Logger::emailNotification('--', 'login');
            }
        }

        /**
         * Get user IP
         *
         * @return $ipaddress
         */
        public static function getClientIP()
        {
            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                // check ip from share internet
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                // check ip is pass from proxy
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } elseif (!empty($_SERVER['REMOTE_ADDR'])) {
                $ip = $_SERVER['REMOTE_ADDR'];
            } else {
                $ip = 'UNKNOWN';
            }
            return $ip;
        }

        /**
         * Log user creation of folders and files
         *
         * @param string $path  the path to set
         * @param string $isDir may be 'dir' or 'file'
         *
         * @return $message
         */
        public static function logCreation($path, $isDir)
        {
            $path = addslashes($path);

            $message = array(
                'user' => GateKeeper::getUserInfo('name'),
                'action' => 'ADD',
                'type' => $isDir ? 'folder':'file',
                'item' => ltrim($path, './'),
            );
            Logger::log($message);
            if (!$isDir && SetUp::getConfig('notify_upload')) {
                Logger::emailNotification($path, 'upload');
            }
            if ($isDir && SetUp::getConfig('notify_newfolder')) {
                Logger::emailNotification($path, 'newdir');
            }
        }

        /**
         * Log user deletion of folders and files
         *
         * @param string  $path   the path to set
         * @param boolean $isDir  file or directory
         * @param boolean $remote true if called inside vfm-admin
         *
         * @return $message
         */
        public static function logDeletion($path, $isDir, $remote = false)
        {
            $path = addslashes($path);
            $message = array(
                'user' => GateKeeper::getUserInfo('name'),
                'action' => 'REMOVE',
                'type' => $isDir ? 'folder':'file',
                'item' => ltrim($path, './'),
            );
            Logger::log($message);
        }
        
        /**
         * Log download of single files
         *
         * @param string $path     the path to set
         * @param bool   $folder   if is folder
         * @param string $relative relative path to /log/ folder
         *
         * @return $message
         */
        public static function logDownload($path, $folder = false, $relative = '')
        {
            $user = Utils::getUserName();
            $mailmessage = '';
            $type = $folder ? 'folder' : 'file';
            if (is_array($path)) {
                foreach ($path as $value) {
                    $path = addslashes($value);
                    $message = array(
                        'user' => $user,
                        'action' => 'DOWNLOAD',
                        'type' => $type,
                        'item' => ltrim($path, './'),
                    );
                    $mailmessage .= $path."\n";
                    Logger::log($message, $relative);
                }
            } else {
                $path = addslashes($path);
                $message = array(
                    'user' => $user,
                    'action' => 'DOWNLOAD',
                    'type' => $type,
                    'item' => ltrim($path, './'),
                );
                $mailmessage = $path;
                Logger::log($message, $relative);
            }
            if (SetUp::getConfig('notify_download')) {
                Logger::emailNotification($mailmessage, 'download');
            }
        }

        /**
         * Log play of single track
         *
         * @param string $path the path to set
         *
         * @return $message
         */
        public static function logPlay($path)
        {
            $path = addslashes($path);
            $message = array(
                'user' =>  GateKeeper::getUserInfo('name') ? GateKeeper::getUserInfo('name') : '--',
                'action' => 'PLAY',
                'type' => 'file',
                'item' => ltrim($path, './'),
            );
            Logger::log($message, '');
        }

        /**
         * Send email notfications for activity logs
         *
         * @param string $path   the path to set
         * @param string $action can be 'download' | 'upload' | 'newdir' | 'login'
         *
         * @return $message
         */
        public static function emailNotification($path, $action = false)
        {
            global $setUp;
            if (strlen(SetUp::getConfig('upload_email')) > 5) {

                $time = SetUp::formatModTime(time());
                $appname = SetUp::getConfig('appname');
                switch ($action) {
                case 'download':
                    $title = $setUp->getString('new_download');
                    break;
                case 'upload':
                    $title = $setUp->getString('new_upload');
                    break;
                case 'newdir':
                    $title = $setUp->getString('new_directory');
                    break;
                case 'login':
                    $title = $setUp->getString('new_access');
                    break;
                default:
                    $title = $setUp->getString('new_activity');
                    break;
                }
                $message = $time."\n\n";
                $message .= "IP : ".Logger::getClientIP()."\n";
                $message .= $setUp->getString('user')." : ".GateKeeper::getUserInfo('name')."\n";
                $message .= $setUp->getString('path')." : ".$path."\n";
         
                $sendTo = SetUp::getConfig('upload_email');
                $from = "=?UTF-8?B?".base64_encode($appname)."?=";
                mail(
                    $sendTo,
                    "=?UTF-8?B?".base64_encode($title)."?=",
                    $message,
                    "Content-type: text/plain; charset=UTF-8\r\n".
                    "From: ".$from." <noreply@{$_SERVER['SERVER_NAME']}>\r\n".
                    "Reply-To: ".$from." <noreply@{$_SERVER['SERVER_NAME']}>"
                );
            }
        }
    }
}

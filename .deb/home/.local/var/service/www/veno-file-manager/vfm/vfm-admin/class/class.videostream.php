<?php
/**
 * Stream videos
 *
 * @category PHP
 * @package  VenoFileManager
 * @author   Nicola Franchini <info@veno.it>
 * @license  Exclusively sold on CodeCanyon
 * @link     http://filemanager.veno.it/
 */
if (!class_exists('VideoStream', false)) {
    /**
     * VideoStream class
     *
     * PHP version >= 5.3
     *
     * @category PHP
     * @package  VenoFileManager
     * @author   Nicola Franchini <info@veno.it>
     * @license  Exclusively sold on CodeCanyon
     * @link     http://filemanager.veno.it/ - https://gist.github.com/ranacseruet/9826293
     */
    class VideoStream
    {
        private $_path = "";
        private $_stream = "";
        private $_buffer = 102400;
        private $_start  = -1;
        private $_end    = -1;
        private $_size   = 0;
        private $_videoFormats = array(
            "mp4"=>"video/mp4", 
            "webm"=>"video/webm", 
            "ogg"=>"video/ogg", 
            "ogv"=>"video/ogg",
           // "flv"=>"video/x-flv",
            );
        /**
         * Construct.
         *
         * @param string $filePath file path
         */    
        function __construct($filePath) 
        {
            $this->_path = $filePath;
        }

        /**
         * The safe way
         *
         * @return true/false
         */
        public function checkVideo()
        {
            $realsetup = realpath('../.'.SetUp::getConfig('starting_dir'));
            $realfile = realpath($this->_path);
            if (strpos($realfile, $realsetup) !== false && file_exists($this->_path)) {
                return true;
            }
            return false;
        }

        /**
         * Open stream
         *
         * @return fopen stream
         */
        private function _open()
        {
            if (!($this->_stream = fopen($this->_path, 'rb'))) {
                die('Could not open stream for reading');
            }    
        }
         
        /**
         * Set proper header to serve the video content.
         *
         * @return video headers
         */
        private function _setHeader()
        {
            ob_get_clean();
            header("Content-Type: video/mp4");
            header("Content-Type: ".($this->_videoFormats[strtolower(pathinfo($this->_path, PATHINFO_EXTENSION))]));
            header("Cache-Control: max-age=2592000, public");
            header("Expires: ".gmdate('D, d M Y H:i:s', time()+2592000) . ' GMT');
            header("Last-Modified: ".gmdate('D, d M Y H:i:s', @filemtime($this->_path)) . ' GMT');
            $this->_start = 0;
            $this->_size  = filesize($this->_path);
            $this->_end   = $this->_size - 1;
            header("Accept-Ranges: 0-".$this->_end);
             
            if (isset($_SERVER['HTTP_RANGE'])) {
      
                $c_start = $this->_start;
                $c_end = $this->_end;
     
                list(, $range) = explode('=', $_SERVER['HTTP_RANGE'], 2);
                if (strpos($range, ',') !== false) {
                    header('HTTP/1.1 416 Requested Range Not Satisfiable');
                    header("Content-Range: bytes $this->_start-$this->_end/$this->_size");
                    exit;
                }
                if ($range == '-') {
                    $c_start = $this->_size - substr($range, 1);
                } else {
                    $range = explode('-', $range);
                    $c_start = $range[0];
                     
                    $c_end = (isset($range[1]) && is_numeric($range[1])) ? $range[1] : $c_end;
                }
                $c_end = ($c_end > $this->_end) ? $this->_end : $c_end;
                if ($c_start > $c_end || $c_start > $this->_size - 1 || $c_end >= $this->_size) {
                    header('HTTP/1.1 416 Requested Range Not Satisfiable');
                    header("Content-Range: bytes $this->_start-$this->_end/$this->_size");
                    exit;
                }
                $this->_start = $c_start;
                $this->_end = $c_end;
                $length = $this->_end - $this->_start + 1;
                fseek($this->_stream, $this->_start);
                header('HTTP/1.1 206 Partial Content');
                header("Content-Length: ".$length);
                header("Content-Range: bytes $this->_start-$this->_end/".$this->_size);
            } else {
                header("Content-Length: ".$this->_size);
            }
        }

        /**
         * Close curretly opened stream
         *
         * @return fclose stream
         */
        private function _end()
        {
            fclose($this->_stream);
            exit;
        }
         
        /**
         * Perform the streaming of calculated range
         *
         * @return stream
         */
        private function _stream()
        {
            $i = $this->_start;
            set_time_limit(0);
            while (!feof($this->_stream) && $i <= $this->_end) {
                $bytesToRead = $this->_buffer;
                if (($i+$bytesToRead) > $this->_end) {
                    $bytesToRead = $this->_end - $i + 1;
                }
                $data = fread($this->_stream, $bytesToRead);
                echo $data;
                flush();
                $i += $bytesToRead;
            }
        }
         
        /**
         * Start streaming video content
         *
         * @return start stream
         */
        function _start()
        {
            $this->_open();
            $this->_setHeader();
            $this->_stream();
            $this->_end();
        }
    }
}

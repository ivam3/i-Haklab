<?php
/**
 * If you use mbstring.func_overload, or the server you are running on has it enabled, you are in trouble.
 * This class will help overcome that, by provide alternative functions to work around it.
 *
 * see readme.markdown for further details.
 *
 * @author A. Grandt <php@grandt.com>
 * @copyright 2014 A. Grandt
 * @license GNU LGPL 2.1
 */
namespace com\grandt;

class BinString {
    const VERSION = 1.00;

    private $has_mbstring = FALSE;
    private $has_mb_shadow = FALSE;
    private $has_mb_mail_overload = FALSE;
    private $has_mb_string_overload = FALSE;
    private $has_mb_regex_overload = FALSE;

    /**
     * mbstring.func_overload has an undocumented feature, to retain access to the original function. 
     * As it is undocumented, it is uncertain if it'll remain, therefore it's being made an optional.
     * 
     * @var boolean 
     */
    public $USE_MB_ORIG = false;

    function __construct() {
        $this->has_mbstring = extension_loaded('mbstring');
        $this->has_mb_shadow = (int) ini_get('mbstring.func_overload');
        $this->has_mb_mail_overload = $this->has_mbstring && ($this->has_mb_shadow & 1);
        $this->has_mb_string_overload = $this->has_mbstring && ($this->has_mb_shadow & 2);
        $this->has_mb_regex_overload = $this->has_mbstring && ($this->has_mb_shadow & 4);
    }

    public function getPHPVersionId() {
        if (!defined('PHP_VERSION_ID')) {
            $version = explode('.', PHP_VERSION);

            define('PHP_VERSION_ID', ($version[0] * 10000 + $version[1] * 100 + $version[2]));
        }

        return PHP_VERSION_ID;
    }

    /**
     * @link http://php.net/manual/en/function.mail.php
     */
    public function _mail($to, $subject, $message, $additional_headers = null, $additional_parameters = null) {
        if ($this->has_mb_mail_overload) {
            if ($this->USE_MB_ORIG) {
                return mb_orig_mail($to, $subject, $message, $additional_headers, $additional_parameters);
            }
            $lang = mb_language(); // get current language
            mb_language("en"); // Force encoding to iso8859-1
            $rv = mb_send_mail($to, $subject, $message, $additional_headers, $additional_parameters);
            mb_language($lang);
            return $rv;
        } else {
            return mail($to, $subject, $message, $additional_headers, $additional_parameters);
        }
    }

    /**
     * @link http://php.net/manual/en/function.strlen.php
     */
    public function _strlen($string) {
        if ($this->has_mb_string_overload) {
            if ($this->USE_MB_ORIG) {
                return mb_orig_strlen($string);
            }
            return mb_strlen($string, 'latin1');
        } else {
            return strlen($string);
        }
    }

    /**
     * @link http://php.net/manual/en/function.strpos.php
     */
    public function _strpos($haystack, $needle, $offset = 0) {
        if ($this->has_mb_string_overload) {
            if ($this->USE_MB_ORIG) {
                return mb_orig_strpos($haystack, $needle, $offset);
            }
            return mb_strpos($haystack, $needle, $offset, 'latin1');
        } else {
            return strpos($haystack, $needle, $offset);
        }
    }

    /**
     * @link http://php.net/manual/en/function.strrpos.php
     */
    public function _strrpos($haystack, $needle, $offset = 0) {
        if ($this->has_mb_string_overload) {
            if ($this->USE_MB_ORIG) {
                return mb_orig_strrpos($haystack, $needle, $offset);
            }
            return mb_strrpos($haystack, $needle, $offset, 'latin1');
        } else {
            return strrpos($haystack, $needle, $offset);
        }
    }

    /**
     * @link http://php.net/manual/en/function.stripos.php
     */
    public function _stripos($haystack, $needle, $offset = 0) {
        if ($this->getPHPVersionId() >= 50200 && $this->has_mb_string_overload) {
            if ($this->USE_MB_ORIG) {
                return mb_orig_stripos($haystack, $needle, $offset);
            }
            return mb_stripos($haystack, $needle, $offset, 'latin1');
        } else {
            return stripos($haystack, $needle, $offset);
        }
    }

    /**
     * @link http://php.net/manual/en/function.strripos.php
     */
    public function _strripos($haystack, $needle, $offset = 0) {
        if ($this->getPHPVersionId() >= 50200 && $this->has_mb_string_overload) {
            if ($this->USE_MB_ORIG) {
                return mb_orig_strripos($haystack, $needle, $offset);
            }
            return mb_strripos($haystack, $needle, $offset, 'latin1');
        } else {
            return strripos($haystack, $needle, $offset);
        }
    }

    /**
     * @link http://php.net/manual/en/function.strstr.php
     */
    public function _strstr($haystack, $needle, $before_needle = false) {
        if ($this->getPHPVersionId() >= 50200 && $this->has_mb_string_overload) {
            if ($this->USE_MB_ORIG) {
                return mb_orig_strstr($haystack, $needle, $before_needle);
            }
            return mb_strstr($haystack, $needle, $before_needle, 'latin1');
        } else {
            return strstr($haystack, $needle, $before_needle);
        }
    }

    /**
     * @link http://php.net/manual/en/function.stristr.php
     */
    public function _stristr($haystack, $needle, $before_needle = false) {
        if ($this->getPHPVersionId() >= 50200 && $this->has_mb_string_overload) {
            if ($this->USE_MB_ORIG) {
                return mb_orig_stristr($haystack, $needle, $before_needle);
            }
            return mb_stristr($haystack, $needle, $before_needle, 'latin1');
        } else {
            return stristr($haystack, $needle, $before_needle);
        }
    }

    /**
     * @link http://php.net/manual/en/function.strrchr.php
     */
    public function _strrchr($haystack, $needle) {
        if ($this->getPHPVersionId() >= 50200 && $this->has_mb_string_overload) {
            if ($this->USE_MB_ORIG) {
                return mb_orig_strrchr($haystack, $needle);
            }
            return mb_strrchr($haystack, $needle, 'latin1');
        } else {
            return strrchr($haystack, $needle);
        }
    }

    /**
     * @link http://php.net/manual/en/function.substr.php
     */
    public function _substr($string, $start, $length = null) {
        if ($this->has_mb_string_overload) {
            if ($this->USE_MB_ORIG) {
                if (func_num_args() == 2) { // Kludgry hack, as PHP substr is lobotomized.
                    return mb_orig_substr($string, $start);
                }
                return mb_orig_substr($string, $start, $length);
            }
            if (func_num_args() == 2) { // Kludgry hack, as mb_substr is lobotomized, AND broken.
                return mb_substr($string, $start, mb_strlen($string, 'latin1'), 'latin1');
            }
            return mb_substr($string, $start, $length, 'latin1');
        } else {
                if (func_num_args() == 2) { // Kludgry hack, as PHP substr is lobotomized.
                    return substr($string, $start);
                }
            return substr($string, $start, $length);
        }
    }

    /**
     * @link http://php.net/manual/en/function.strtolower.php
     */
    public function _strtolower($string) {
        if ($this->has_mb_string_overload) {
            if ($this->USE_MB_ORIG) {
                return mb_orig_strtolower($string);
            }
            return mb_strtolower($string, 'latin1');
        } else {
            return strtolower($string);
        }
    }

    /**
     * @link http://php.net/manual/en/function.strtoupper.php
     */
    public function _strtoupper($string) {
        if ($this->has_mb_string_overload) {
            if ($this->USE_MB_ORIG) {
                return mb_orig_strtoupper($string);
            }
            return mb_strtoupper($string, 'latin1');
        } else {
            return strtoupper($string);
        }
    }

    /**
     * @link http://php.net/manual/en/function.substr_count.php
     */
    public function _substr_count($haystack, $needle, $offset = 0, $length = null) {
        if ($this->has_mb_string_overload) {
            if ($this->USE_MB_ORIG) {
                if (func_num_args() > 3) { // Kludgry hack, as PHP substr_count is lobotomized.
                    return mb_orig_substr_count($haystack, $needle, $offset, $length);
                }
                return mb_orig_substr_count($haystack, $needle, $offset);
            }
            return mb_substr_count($haystack, $needle, 'latin1');
        } else {
            if (func_num_args() > 3) { // Kludgry hack, as PHP substr_count is lobotomized.
                return substr_count($haystack, $needle, $offset, $length);
            }
            return substr_count($haystack, $needle, $offset);
        }
    }

    /**
     * @link http://php.net/manual/en/function.ereg.php
     * @deprecated ereg_* functions are deprecated in PHP 5.3 onwards, use the PCRE preg_* instead.
     */
    public function _ereg($pattern, $string, array &$regs) {
        if ($this->has_mb_regex_overload) {
            if ($this->USE_MB_ORIG) {
                return mb_orig_ereg($pattern, $string, $regs);
            }
            $enc = mb_regex_encoding(); // get current encoding
            mb_regex_encoding("latin1"); // Force encoding to iso8859-1
            $rv = mb_ereg($pattern, $string, $regs);
            mb_regex_encoding($enc);
            return $rv;
        } else {
            return ereg($pattern, $string, $regs);
        }
    }

    /**
     * @link http://php.net/manual/en/function.eregi.php
     * @deprecated ereg_* functions are deprecated in PHP 5.3 onwards, use the PCRE preg_* instead.
     */
    public function _eregi($pattern, $string, array &$regs) {
        if ($this->has_mb_regex_overload) {
            if ($this->USE_MB_ORIG) {
                return mb_orig_eregi($pattern, $string, $regs);
            }
            $enc = mb_regex_encoding(); // get current encoding
            mb_regex_encoding("latin1"); // Force encoding to iso8859-1
            $rv = mb_eregi($pattern, $string, $regs);
            mb_regex_encoding($enc);
            return $rv;
        } else {
            return eregi($pattern, $string, $regs);
        }
    }

    /**
     * @link http://php.net/manual/en/function.ereg_replace.php
     * @deprecated ereg_* functions are deprecated in PHP 5.3 onwards, use the PCRE preg_* instead.
     */
    public function _ereg_replace($pattern, $replacement, $string, $mb_specific_option = "msr") {
        if ($this->has_mb_regex_overload) {
            if ($this->USE_MB_ORIG) {
                return mb_orig_ereg_replace($pattern, $replacement, $string);
            }
            $enc = mb_regex_encoding(); // get current encoding
            mb_regex_encoding("latin1"); // Force encoding to iso8859-1
            $rv = mb_ereg_replace($pattern, $replacement, $string, $mb_specific_option);
            mb_regex_encoding($enc);
            return $rv;
        } else {
            return ereg_replace($pattern, $replacement, $string);
        }
    }

    /**
     * @link http://php.net/manual/en/function.eregi_replace.php
     * @deprecated ereg_* functions are deprecated in PHP 5.3 onwards, use the PCRE preg_* instead.
     */
    public function _eregi_replace($pattern, $replacement, $string, $mb_specific_option = "msri") {
        if ($this->has_mb_regex_overload) {
            if ($this->USE_MB_ORIG) {
                return mb_orig_eregi_replace($pattern, $replacement, $string);
            }
            $enc = mb_regex_encoding(); // get current encoding
            mb_regex_encoding("latin1"); // Force encoding to iso8859-1
            $rv = mb_eregi_replace($pattern, $replacement, $string, $mb_specific_option);
            mb_regex_encoding($enc);
            return $rv;
        } else {
            return eregi_replace($pattern, $replacement, $string);
        }
    }

    /**
     * @link http://php.net/manual/en/function.split.php
     * @deprecated Split is deprecated in PHP 5.3 onwards, use preg_split instead. It'll bypass mb_* anyway.
     */
    public function _split($pattern, $string, $limit = -1) {
        if ($this->has_mb_regex_overload) {
            if ($this->USE_MB_ORIG) {
                return mb_orig_split($pattern, $string, $limit);
            }
            $enc = mb_regex_encoding(); // get current encoding
            mb_regex_encoding("latin1"); // Force encoding to iso8859-1
            $rv = mb_split($pattern, $string, $limit);
            mb_regex_encoding($enc);
            return $rv;
        } else {
            return split($pattern, $string, $limit);
        }
    }
    /**
     * Checks if the $haystack starts with the text in the $needle.
     * Case sensitive.

     * @param string $haystack
     * @param string $needle
     *
     * @return bool
     */
    public function startsWith($haystack, $needle) {
        return $needle === '' || $this->_strpos($haystack, $needle) === 0;
    }

    /**
     * Checks if the $haystack ends with the text in the $needle.
     * Case sensitive.
     *
     * @param string $haystack
     * @param string $needle
     *
     * @return bool
     */
    public function endsWith($haystack, $needle) {
        return $needle === '' || $this->_substr($haystack, -$this->_strlen($needle)) === $needle;
    }
}

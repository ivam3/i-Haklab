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

class BinStringStatic {
    const VERSION = 1.00;

    /**
     * mbstring.func_overload has an undocumented feature, to retain access to the original function. 
     * As it is undocumented, it is uncertain if it'll remain, therefore it's being made an optional.
     * 
     * @var boolean 
     */
    public static $USE_MB_ORIG = false;

    /**
     * Initialize the vars that'll allow us to override mbstring.func_overload, if needed.
     *
     * @author A. Grandt <php@grandt.com>
     *
     * @return bool true if mbstring.func_overload is enabled.
     */
    public static function isMBMailOverloaded() {
        static $has_mb_mail_overload = null;
        if ($has_mb_mail_overload ===  null) {
            $has_mbstring = extension_loaded('mbstring');
            $has_mb_shadow = (int) ini_get('mbstring.func_overload');
            $has_mb_mail_overload = $has_mbstring && ($has_mb_shadow & 1);
        }
        return $has_mb_mail_overload;
    }

    /**
     * Initialize the vars that'll allow us to override mbstring.func_overload, if needed.
     *
     * @author A. Grandt <php@grandt.com>
     *
     * @return bool true if mbstring.func_overload is enabled.
     */
    public static function isMBStringOverloaded() {
        static $has_mb_overload = null;
        if ($has_mb_overload ===  null) {
            $has_mbstring = extension_loaded('mbstring');
            $has_mb_shadow = (int) ini_get('mbstring.func_overload');
            $has_mb_overload = $has_mbstring && ($has_mb_shadow & 2);
        }
        return $has_mb_overload;
    }

    public static function getPHPVersionId() {
        if (!defined('PHP_VERSION_ID')) {
            $version = explode('.', PHP_VERSION);

            define('PHP_VERSION_ID', ($version[0] * 10000 + $version[1] * 100 + $version[2]));
        }

        return PHP_VERSION_ID;
    }

    /**
     * Initialize the vars that'll allow us to override mbstring.func_overload, if needed.
     *
     * @author A. Grandt <php@grandt.com>
     *
     * @return bool true if mbstring.func_overload is enabled.
     */
    public static function isMBRegexOverloaded() {
        static $has_mb_regex_overload = null;
        if ($has_mb_regex_overload ===  null) {
            $has_mbstring = extension_loaded('mbstring');
            $has_mb_shadow = (int) ini_get('mbstring.func_overload');
            $has_mb_regex_overload = $has_mbstring && ($has_mb_shadow & 4);
        }
        return $has_mb_regex_overload;
    }

    /**
     * @link http://php.net/manual/en/function.mail.php
     */
    public static function _mail($to, $subject, $message, $additional_headers = null, $additional_parameters = null) {
        if (self::isMBMailOverloaded()) {
            if (self::$USE_MB_ORIG) {
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
    public static function _strlen($string) {
        if (self::isMBStringOverloaded()) {
            if (self::$USE_MB_ORIG) {
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
    public static function _strpos($haystack, $needle, $offset = 0) {
        if (self::isMBStringOverloaded()) {
            if (self::$USE_MB_ORIG) {
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
    public static function _strrpos($haystack, $needle, $offset = 0) {
        if (self::isMBStringOverloaded()) {
            if (self::$USE_MB_ORIG) {
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
    public static function _stripos($haystack, $needle, $offset = 0) {
        if (self::getPHPVersionId() >= 50200 && self::isMBStringOverloaded()) {
            if (self::$USE_MB_ORIG) {
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
    public static function _strripos($haystack, $needle, $offset = 0) {
        if (self::getPHPVersionId() >= 50200 && self::isMBStringOverloaded()) {
            if (self::$USE_MB_ORIG) {
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
    public static function _strstr($haystack, $needle, $before_needle = false) {
        if (self::getPHPVersionId() >= 50200 && self::isMBStringOverloaded()) {
            if (self::$USE_MB_ORIG) {
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
    public static function _stristr($haystack, $needle, $before_needle = false) {
        if (self::getPHPVersionId() >= 50200 && self::isMBStringOverloaded()) {
            if (self::$USE_MB_ORIG) {
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
    public static function _strrchr($haystack, $needle) {
        if (self::getPHPVersionId() >= 50200 && self::isMBStringOverloaded()) {
            if (self::$USE_MB_ORIG) {
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
    public static function _substr($string, $start, $length = null) {
        if (self::isMBStringOverloaded()) {
            if (self::$USE_MB_ORIG) {
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
    public static function _strtolower($string) {
        if (self::isMBStringOverloaded()) {
            if (self::$USE_MB_ORIG) {
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
    public static function _strtoupper($string) {
        if (self::isMBStringOverloaded()) {
            if (self::$USE_MB_ORIG) {
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
    public static function _substr_count($haystack, $needle, $offset = 0, $length = null) {
        if (self::isMBStringOverloaded()) {
            if (self::$USE_MB_ORIG) {
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
    public static function _ereg($pattern, $string, array &$regs) {
        if (self::isMBRegexOverloaded()) {
            if (self::$USE_MB_ORIG) {
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
    public static function _eregi($pattern, $string, array &$regs) {
        if (self::isMBRegexOverloaded()) {
            if (self::$USE_MB_ORIG) {
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
    public static function _ereg_replace($pattern, $replacement, $string, $mb_specific_option = "msr") {
        if (self::isMBRegexOverloaded()) {
            if (self::$USE_MB_ORIG) {
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
    public static function _eregi_replace($pattern, $replacement, $string, $mb_specific_option = "msri") {
        if (self::isMBRegexOverloaded()) {
            if (self::$USE_MB_ORIG) {
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
    public static function _split($pattern, $string, $limit = -1) {
        if (self::isMBRegexOverloaded()) {
            if (self::$USE_MB_ORIG) {
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
    public static function startsWith($haystack, $needle) {
        return $needle === '' || self::_strpos($haystack, $needle) === 0;
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
    public static function endsWith($haystack, $needle) {
        return $needle === '' || self::_substr($haystack, -self::_strlen($needle)) === $needle;
    }
}

<?php
/**
 * VFM - veno file manager: admin-panel/view/admin-head-translations.php
 * main translations setting process
 *
 * PHP version >= 5.3
 *
 * @category  PHP
 * @package   VenoFileManager
 * @author    Nicola Franchini <support@veno.it>
 * @copyright 2013 Nicola Franchini
 * @license   Exclusively sold on CodeCanyon: https://codecanyon.net/item/veno-file-manager-host-and-share-files/6114247
 * @link      http://filemanager.veno.it/
 */

if ($get_action == 'update') {
    $postnewlang = filter_input(INPUT_POST, "thenewlang", FILTER_UNSAFE_RAW);
    $getremove = filter_input(INPUT_GET, "remove", FILTER_UNSAFE_RAW);

    if ($postnewlang || $getremove) {

        if ($getremove) {

            $thelang = $getremove;
            $langtoremove = "translations/".$thelang.".php";

            if (!file_exists($langtoremove) || !unlink($langtoremove)) {
                Utils::setError('language "'.$thelang.'" does not exist');
            } else {
                Utils::setSuccess($setUp->getString("language_removed"));
            }

        } else {

            $thelang = $postnewlang;

            if (array_key_exists($thelang, $translations)) {
                foreach ($baselang as $key => $value) {

                    $postkey = filter_input(INPUT_POST, $key, FILTER_UNSAFE_RAW);
        
                    $_TRANSLATIONSEDIT[$key] = $postkey;
                }
                Utils::setSuccess($setUp->getString("language_updated"));
            } else {
                $newlang = array();
                foreach ($baselang as $key => $value) {

                    $postkey = filter_input(INPUT_POST, $key, FILTER_UNSAFE_RAW);
                    $newlang[$key] = $postkey;
                }
                $_TRANSLATIONSEDIT = array_merge($_TRANSLATIONSEDIT, $newlang);
                Utils::setSuccess($setUp->getString("language_added"));
            }

            $langname = $_TRANSLATIONSEDIT['LANGUAGE_NAME'];
            $translations_index[$thelang] = $langname;

            file_put_contents($jsonindex, json_encode($translations_index, JSON_FORCE_OBJECT));

            $trans = '$_TRANSLATIONS = ';
            if (false == (file_put_contents(
                'translations/'.$thelang.'.php',
                "<?php\n\n $trans".var_export($_TRANSLATIONSEDIT, true).";\n"
            ))
            ) {
                Utils::setError('Error updating language file');
            } else {
                $updater->clearCache('translations/'.$thelang.'.php');
            }
        }
    }
}
<?php
/**
 * VFM - veno file manager: include/user-redirect.php
 * redirect user inside his directory if only one
 *
 * PHP version >= 5.3
 *
 * @category  PHP
 * @package   VenoFileManager
 * @author    Nicola Franchini <support@veno.it>
 * @copyright 2013 Nicola Franchini
 * @license   Exclusively sold on CodeCanyon
 * @link      http://filemanager.veno.it/
 */
if (!defined('VFM_APP')) {
    return;
}
/**
* Redirect User
*/
// check if any folder is assigned to the current user
if ($gateKeeper->isAccessAllowed() && $gateKeeper->getUserInfo('dir') !== null) {
    $userpatharray = array();
    $userpatharray = json_decode($gateKeeper->getUserInfo('dir'), true);

    // check if user has only one folder
    if (count($userpatharray) === 1) {
        $cleandir = substr($setUp->getConfig('starting_dir').$userpatharray[0], 2);
        
        // check if user is trying to access to the root
        if (!isset($_GET['dir']) || strlen($_GET['dir']) < strlen($cleandir)) { 
            if (isset($_SESSION['vfm_user_name_new'])) { 
                $_SESSION['warning'] = $setUp->getString('your_new_username_is').$_SESSION['vfm_user_name_new'];
                $_SESSION['vfm_user_name_new'] = null;
            }
            ?>
            <script type="text/javascript">
                window.location.replace("?dir=<?php echo $cleandir; ?>");
            </script>
            <?php
        }
    }
}
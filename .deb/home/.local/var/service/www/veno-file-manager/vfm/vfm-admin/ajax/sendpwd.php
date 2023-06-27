<?php
/**
 * VFM - veno file manager: ajax/sendpwd.php
 *
 * Send link to reset password
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
if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) 
    || (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest')
) {
    exit;
}
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once dirname(dirname(__FILE__)).'/config.php';
require_once dirname(dirname(__FILE__)).'/_content/users/users.php';
require_once dirname(dirname(__FILE__)).'/_content/users/token.php';

require_once dirname(dirname(__FILE__)).'/class/class.setup.php';
require_once dirname(dirname(__FILE__)).'/class/class.utils.php';
require_once dirname(dirname(__FILE__)).'/class/class.updater.php';
require_once dirname(dirname(__FILE__)).'/class/class.resetter.php';

$setUp = new SetUp();
$utils = new Utils();
$updater = new Updater();
$resetter = new Resetter();
$lang = $setUp->lang;
require_once dirname(dirname(__FILE__)).'/translations/'.$lang.'.php';

$dest = filter_input(INPUT_POST, "user_email", FILTER_VALIDATE_EMAIL);
$pulito = filter_input(INPUT_POST, 'cleanurl', FILTER_UNSAFE_RAW);

$setfrom = SetUp::getConfig('email_from');

if ($setfrom == null) {
    echo '<div class="alert alert-danger">'.$setUp->getString('setup_email_application').'</div>';
    exit();
}

global $_USERS;
global $_TOKENS;

if (!$dest) {
    echo '<div class="alert alert-warning">'.$setUp->getString('fill_all_fields').'</div>';
    exit();
}
if (!Utils::checkCaptcha('show_captcha_reset')) {
    echo '<div class="alert alert-danger">'.$setUp->getString('wrong_captcha').'</div>';
    exit();
}

if (!$updater->findUser($dest, true)) {
    echo '<div class="alert alert-danger">'.$setUp->getString('email_not_exist').'</div>';
    exit();
}
$token = $resetter->setToken($dest, dirname(dirname(__FILE__)).'/_content/users/');
if (!$token) {
    echo '<div class="alert alert-danger">Error: token not set</div>';
    exit();
}

use PHPMailer\PHPMailer\PHPMailer;
require_once dirname(dirname(__FILE__)).'/assets/mail/vendor/autoload.php';

$mail = new PHPMailer();

$mail->CharSet = 'UTF-8';
$mail->setLanguage($lang);

if ($setUp->getConfig('smtp_enable') == true) {

    $mail->isSMTP();
    $mail->SMTPDebug = ($setUp->getConfig('debug_smtp') ? 2 : 0);
    $mail->Debugoutput = 'html';
    
    $smtp_auth = $setUp->getConfig('smtp_auth');
    $mail->Host = $setUp->getConfig('smtp_server');
    $mail->Port = (int)$setUp->getConfig('port');

    if (version_compare(PHP_VERSION, '5.6.0', '>=')) {
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            )
        );
    }
    if ($setUp->getConfig('secure_conn') !== "none") {
        $mail->SMTPSecure = $setUp->getConfig('secure_conn');
    }
    
    $mail->SMTPAuth = $smtp_auth;

    if ($smtp_auth == true) {
        $mail->Username = $setUp->getConfig('email_login');
        $mail->Password = $setUp->getConfig('email_pass');
    }
}
$mail->setFrom($setfrom, $setUp->getConfig('appname'));
$mail->addAddress($dest, '<'.$dest.'>');

$mail->Subject = $setUp->getConfig('appname').": ".$setUp->getString('reset_password');

$altmessage = $setUp->getString('someone_requested_pwd_reset_1').": ".$token['name']."/n"
    .$setUp->getString('someone_requested_pwd_reset_2')."\n"
    .$setUp->getString('someone_requested_pwd_reset_3')."\n"
    .$pulito.$token['tok'];

$email_logo = SetUp::getConfig('email_logo', false) ? '../_content/uploads/'.SetUp::getConfig('email_logo') : '../images/px.png';
$mail->AddEmbeddedImage($email_logo, 'logoimg');

// Retrieve the email template required
$message = file_get_contents('../_content/mail-template/template-reset-password.html');

// Replace the % with the actual information
$message = str_replace('%app_url%', $pulito, $message);
$message = str_replace('%app_name%', $setUp->getConfig('appname'), $message);

$message = str_replace(
    '%translate_someone_requested_pwd_reset_1%', 
    $setUp->getString('someone_requested_pwd_reset_1'), $message
);
$message = str_replace(
    '%translate_someone_requested_pwd_reset_2%', 
    $setUp->getString('someone_requested_pwd_reset_2'), $message
);
$message = str_replace(
    '%translate_someone_requested_pwd_reset_3%', 
    $setUp->getString('someone_requested_pwd_reset_3'), $message
);

$message = str_replace('%translate_username%', $setUp->getString('username'), $message);
$message = str_replace('%username%', $token['name'], $message);
$message = str_replace('%translate_reset_password%', $setUp->getString('reset_password'), $message);
$message = str_replace('%tok%', $pulito.$token['tok'], $message);

$mail->msgHTML($message);

$mail->AltBody = $altmessage;

if (!$mail->send()) {
    echo '<div class="alert alert-danger">Mailer Error: '.$mail->ErrorInfo.'</div>';
} else {
    echo '<div class="alert alert-success">'.$setUp->getString('message_sent').': '.$dest.'</div>';
}
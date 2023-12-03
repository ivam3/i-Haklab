<?php
/**
 * VFM - veno file manager: ajax/usr-reg.php
 *
 * Send email to new pending user
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
require dirname(dirname(__FILE__)).'/config.php';
require_once dirname(dirname(__FILE__)).'/class/class.setup.php';
require_once dirname(dirname(__FILE__)).'/class/class.utils.php';
require_once dirname(dirname(__FILE__)).'/class/class.gatekeeper.php';
require_once dirname(dirname(__FILE__)).'/class/class.updater.php';

require_once dirname(dirname(__FILE__)).'/_content/users/users.php';

$setUp = new SetUp();
$lang = $setUp->lang;
require dirname(dirname(__FILE__)).'/translations/'.$lang.'.php';

if (file_exists(dirname(dirname(__FILE__)).'/_content/users/users-new.php')) {
    include dirname(dirname(__FILE__)).'/_content/users/users-new.php';
} else {
    $newusers = array();
}

$updater = new Updater();

$setfrom = SetUp::getConfig('email_from');

if ($setfrom == null) {
    echo $setUp->getString("setup_email_application")."<br>";
    exit();
}

$filterType = array(
    'string' => FILTER_UNSAFE_RAW,
    'integer' => FILTER_VALIDATE_INT,
);

$post = array();

// filter inputs
foreach ($_POST as $key => $value) {
    $filter = $filterType[gettype($value)];
    $value = filter_var($value, $filter);
    $post[$key] = $value;
}

$post = array_filter($post, '!empty');

$postname = isset($post['user_name']) ? $post['user_name'] : false;
$postpass = isset($post['user_pass']) ? $post['user_pass'] : false;
$postpassconfirm = isset($post['user_pass_confirm']) ? $post['user_pass_confirm'] : false;
$postmail = isset($post['user_email']) ? filter_var($post['user_email'], FILTER_VALIDATE_EMAIL) : false;

if (!$postname 
    || !$postmail
    || !$postpass 
    || !$postpassconfirm
) {
    echo '<div class="alert alert-warning" role="alert">'.$setUp->getString("fill_all_fields").' *</div>';
    exit();
}

$postname = preg_replace('/\s+/', '', $postname);

// minimum username lenght
if (!empty($postname) < 3) {
    echo '<div class="alert alert-danger" role="alert">'.$setUp->getString("minimum").' 3 chars</div>';
    exit();
}

// passwords mismatch
if ($postpass !== $postpassconfirm) {
    echo '<div class="alert alert-danger" role="alert">'.$setUp->getString("passwords_dont_match").'</div>';
    exit();
}

// username already exists
if ($updater->findUser($postname)) {
    echo '<div class="alert alert-danger" role="alert"><strong>'.$postname.'</strong> '.$setUp->getString("file_exists").'</div>';
    exit();
}

// e-mail already exists
if ($updater->findUser($postmail, true)) {
    echo '<div class="alert alert-warning" role="alert"><strong>'.$postmail.'</strong> '.$setUp->getString("file_exists").'</div>';
    exit();
}

// check capcha
if (!Utils::checkCaptcha('show_captcha_register')) {
    echo '<div class="alert alert-warning" role="alert">'.$setUp->getString("wrong_captcha").'</div>';
    exit();
}
// if is already on pre-registration 
// send again an activation link
$prereguser = $updater->findUserPre($postmail, true);

// mail exist in pre-reg
if ($prereguser) {
    // username is different from the first associated to this e-mail
    // resend activation mail with first username chosen
    echo '<div class="alert alert-warning" role="alert"><strong>'.$postmail.'</strong> '.$setUp->getString("file_exists").'</div>';
    if ($prereguser !== $postname) {
        $postname = $prereguser['name'];
    }
} else {
    // e-mail has never been used, check if username is alredy pre-registered
    if ($updater->findUserPre($postname)) {
        echo '<div class="alert alert-warning" role="alert"><strong>'.$postname.'</strong> '.$setUp->getString("file_exists").'</div>';
        exit();
    }
}

if (!$prereguser) {

    $newuser = array();
    $newuser['name'] = $postname;
    $salt = SetUp::getConfig('salt');
    $appurl =  SetUp::getConfig('script_url');
    $newuser['pass'] = crypt($salt.urlencode($postpass), Utils::randomString());
    $newuser['email'] = $postmail;

    // remove standard fields
    unset($post['user_name'], $post['user_pass'], $post['user_pass_confirm'], $post['user_email'], $post['captcha'], $post['g-recaptcha-response']);

    // loop remaining custom fields
    foreach ($post as $custom => $value) {
        $newuser[$custom] = $value;
    }

    $date = date("Y-m-d-H-i-s", time());
    $newuser['date'] = $date;

    $activekey = md5($postname.$salt.$date);
    $newuser['key'] = $activekey;
    $activationlink = $appurl."?act=".$activekey;

    array_push($newusers, $newuser);

} else {

    $date = $prereguser['date'];
    $activekey = md5($postname.$salt.$date);
    $activationlink = $appurl."?act=".$activekey;
}

use PHPMailer\PHPMailer\PHPMailer;
require_once dirname(dirname(__FILE__)).'/assets/mail/vendor/autoload.php';

$mail = new PHPMailer();

$mail->CharSet = 'UTF-8';
$mail->setLanguage($lang);

if (SetUp::getConfig('smtp_enable') == true) {

    $mail->isSMTP();
    $mail->SMTPDebug = (SetUp::getConfig('debug_smtp') ? 2 : 0);
    $mail->Debugoutput = 'html';

    $smtp_auth = SetUp::getConfig('smtp_auth');

    $mail->Host = SetUp::getConfig('smtp_server');
    $mail->Port = (int)SetUp::getConfig('port');
    if (version_compare(PHP_VERSION, '5.6.0', '>=')) {
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            )
        );
    }
    if (SetUp::getConfig('secure_conn') !== "none") {
        $mail->SMTPSecure = SetUp::getConfig('secure_conn');
    }
    
    $mail->SMTPAuth = $smtp_auth;

    if ($smtp_auth == true) {
        $mail->Username = SetUp::getConfig('email_login');
        $mail->Password = SetUp::getConfig('email_pass');
    }
}
$mail->setFrom($setfrom, SetUp::getConfig('appname'));
$mail->addAddress($postmail, '<'.$postmail.'>');

$mail->Subject = SetUp::getConfig('appname').": ".$setUp->getString('activate_account');

$altmessage = $setUp->getString('follow_this_link_to_activate')."/n".$activationlink;

$email_logo = SetUp::getConfig('email_logo', false) ? '../_content/uploads/'.SetUp::getConfig('email_logo') : '../images/px.png';;
$mail->AddEmbeddedImage($email_logo, 'logoimg');

// Retrieve the email template required
$message = file_get_contents('../_content/mail-template/template-activate-account.html');

// Replace the % with the actual information
$message = str_replace('%app_url%', $appurl, $message);
$message = str_replace('%app_name%', SetUp::getConfig('appname'), $message);

$message = str_replace(
    '%translate_follow_this_link_to_activate%', 
    $setUp->getString('follow_this_link_to_activate'), $message
);
$message = str_replace(
    '%activation_link%', 
    $activationlink, $message
);
$message = str_replace(
    '%translate_activate%', 
    $setUp->getString('activate'), $message
);

$message = str_replace(
    '%translate_username%', 
    $setUp->getString('username').": <strong>".$postname."<strong>", $message
);

$mail->msgHTML($message);

$mail->AltBody = $altmessage;

if (!$mail->send()) {
    echo '<div class="alert alert-danger" role="alert">Mailer Error: ' .$mail->ErrorInfo.'</div>';
} else {
    if ($updater->updateRegistrationFile($newusers, "../_content/users/")) {
        echo '<div class="alert alert-success" role="alert">'.$setUp->getString('activation_link_sent').'</div>';   
    } else {
        echo '<div class="alert alert-danger" role="alert"><strong>users-new</strong> file update failed</div>';
    }
}
exit;

<?php
/**
 * VFM - veno file manager: ajax/sedfiles.php
 *
 * Sharing link email sender
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
require_once dirname(dirname(__FILE__)).'/config.php';
require_once dirname(dirname(__FILE__)).'/class/class.setup.php';
require_once dirname(dirname(__FILE__)).'/class/class.utils.php';

$setUp = new SetUp();
$utils = new Utils();

$lang = $setUp->lang;
require_once '../translations/'.$lang.'.php';

$setfrom = SetUp::getConfig('email_from');

if ($setfrom == null) {
    echo $setUp->getString("setup_email_application");
    exit();
}

$from = filter_input(INPUT_POST, "mitt", FILTER_VALIDATE_EMAIL);
$dest = filter_input(INPUT_POST, "dest", FILTER_VALIDATE_EMAIL);
$link = filter_input(INPUT_POST, "sharelink", FILTER_UNSAFE_RAW);
$attachments = explode(",", filter_input(INPUT_POST, "attach", FILTER_UNSAFE_RAW));
$text_message = filter_input(INPUT_POST, "message", FILTER_UNSAFE_RAW);
$passlink = filter_input(INPUT_POST, "passlink", FILTER_UNSAFE_RAW);
$bcc = filter_input(INPUT_POST, 'send_cc', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

use PHPMailer\PHPMailer\PHPMailer;

if ($from && $dest && $link) {

    include_once dirname(dirname(__FILE__)).'/assets/mail/vendor/autoload.php';

    $mail = new PHPMailer();

    $mail->CharSet = 'UTF-8';
    $mail->setLanguage($lang);

    if ($setUp->getConfig('smtp_enable') == true) {

        $mail->SMTPDebug = ($setUp->getConfig('debug_smtp') ? 2 : 0);
        $mail->Debugoutput = 'html';

        $mail->isSMTP();

        $mail->Host = $setUp->getConfig('smtp_server');

        $smtp_auth = $setUp->getConfig('smtp_auth');
        $mail->SMTPAuth = $smtp_auth;

        if ($smtp_auth == true) {
            $mail->Username = $setUp->getConfig('email_login');
            $mail->Password = $setUp->getConfig('email_pass');
        }

        if (version_compare(PHP_VERSION, '5.6.0', '>=')) {
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
        }
            
        if ($setUp->getConfig('secure_conn') !== "none") {
            $mail->SMTPSecure = $setUp->getConfig('secure_conn');
        }
        $mail->Port = (int)$setUp->getConfig('port');
    }
    $app_name = $setUp->getConfig('appname');
    $app_url = $setUp->getConfig('script_url');

    $mail->setFrom($setfrom, $setUp->getConfig('appname'));
    $mail->addReplyTo($from, '<'.$from.'>');
    $mail->addAddress($dest, '<'.$dest.'>');

    if ($bcc) {
        foreach ($bcc as $newcc) {
            $cleancc = filter_var($newcc, FILTER_VALIDATE_EMAIL);
            if ($cleancc) {
                $mail->AddBCC($cleancc, '<'.$cleancc.'>');
            }
        }
    }

    $mail->Subject = $from." ".$setUp->getString('sent_some_files');

    $myfiles = "<ul>";
    foreach ($attachments as $value) {
        $filepathinfo = $utils->mbPathinfo(urldecode(base64_decode($value)));
        $filename = $filepathinfo['basename'];
        $myfiles .= "<li>".$filename."</li>";
    }
    $myfiles .= "</ul>";

    $email_logo = $setUp->getConfig('email_logo', false) ? '../_content/uploads/'.$setUp->getConfig('email_logo') : '../images/px.png';
    $mail->AddEmbeddedImage($email_logo, 'logoimg');

    // Retrieve the email template required
    $message = file_get_contents('../_content/mail-template/template-send-files.html');

    // Replace the % with the actual information
    $message = str_replace('%app_name%', $app_name, $message);
    $message = str_replace('%app_url%', $app_url, $message);
    $message = str_replace('%from%', $from, $message);
    $message = str_replace('%translate_sent_some_files%', $setUp->getString('sent_some_files'), $message);
    $message = str_replace('%myfiles%', $myfiles, $message);
    $message = str_replace('%link%', $link, $message);
    $message = str_replace('%translate_download%', $setUp->getString('download'), $message);
    $passalink = ($passlink ? $setUp->getString('password').": <strong>".$passlink."</strong>" : "");
    $message = str_replace('%passlink%', $passalink, $message);
    $message = str_replace('%text_message%', nl2br($text_message), $message);

    $mail->msgHTML($message);

    $mail->AltBody = $from." ".$setUp->getString('sent_some_files').":\n " .$link;

    if (!$mail->send()) {
        print "Mailer Error: " . $mail->ErrorInfo;
    } else {
        print $setUp->getString('message_sent').": ".$dest;
    }
    /**
    * Send notification e-mail
    * to additional addresses.
    */
    /*
    $mail2 = clone $mail;
    $mail2->ClearAllRecipients();
    $mail2->Subject = $from." sent some files to: ".$dest;
    $mail2->setFrom($setfrom, $setUp->getConfig('appname'));
    $mail2->MsgHTML("<img src=\"cid:logoimg\" /><br><br>".$from." sent some files to: ".$dest.": ".$myfiles);
    $mail2->AddAddress('who-to@example.com', 'admin');
    // if you want to add some more recipients
    // $mail2->AddBCC('who-to-cc@example.com', 'John Doe');
    // $mail2->AddBCC('who-to-cc2@example.com', 'jack Doe');
    $mail2->send();
    */
} else {
    print $setUp->getString('fill_all_fields');
}

<?php

/**
 *
 * Send the mail to yourself because the sender may use a forged email address
 * Instead, add the sender's mail to the replyPath
 * in whichc case, the entire request should be ignored
 * 
 * */


// PHPMailer configuration and dependencies
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'src/PHPMailer.php';
require_once 'src/Exception.php';
require_once 'src/SMTP.php';

$mailer = new PHPMailer;
// $sanitize = new Sanitize;

//Server settings
$mailer->isSMTP();
$mailer->SMTPAuth = 0;
$mailer->SMTPDebug = false;
$mailer->Host = 'medicareconsultng.com';
$mailer->Username = 'potterinc@medicareconsultng.com';
$mailer->Password = 'RngZndjL2z&6';
$mailer->SMTPSecure = 'ssl';
$mailer->Port = 465;

// CONTACT FORM
if (isset($_REQUEST['Name']) && isset($_REQUEST['Email'])) {

    // Recipient
    $mailer->setFrom("info@medicareconsultng.com", 'Contact Form');
    $mailer->addAddress("medicareconsult@gmail.com");

    // Validating the sender email address
    if ($mailer->addReplyTo($_REQUEST['Email'], $_REQUEST['Name'])) {
        $mailer->isHTML(true);
        $mailer->Subject = "CONTACT FORM";
        $mailer->Body = "<strong>Dear Admin</strong>,<p><h1 align='center'>CONTACT FORM</h1></p>
            {$_REQUEST['Message']} <br /> <br> Yours sincerely,<br>
            <strong>{$_REQUEST['Name']}</strong> <br>
            <strong>{$_REQUEST['Email']}</strong><br>
            <strong>{$_REQUEST['Number']}</strong><br><br><strong>Source: <a href='https://medicareconsultng.com'>https://medicareconsultng.com</a></strong>";
        $mailer->AltBody = "Dear Admin, \n{$_REQUEST['Message']}\n----------------------------------\nYours sincerely,\n
            {$_REQUEST['Name']}\n{$_REQUEST['Email']}\n\nTelephone: {$_REQUEST['Number']}\nSource: https://medicareconsultng.com";

        // sending the mail
        if ($mailer->send())
            print("<input type='button' value='SENT:Thank you for contacting us' class='w3-green' />");
        // $request['status'] = TRUE;
        // $request['message'] = "Thank you for contacting us";
        // print(json_encode($request, JSON_PRETTY_PRINT));
        else
            print("<input type='button' value='Message not sent [" . $mailer->ErrorInfo . "]' class='w3-red' />");
        // $request['status'] = FALSE;
        // $request['message'] = "Message not sent [" . $mailer->ErrorInfo . "]";
        // print(json_encode($request, JSON_PRETTY_PRINT));
    } else
        print("<input type='button' value='Invalid Email: Try again' class='w3-amber' />");
    // $request['status'] = FALSE;
    // $request['message'] = "Invalid Email: Try again";
    // print(json_encode($request, JSON_PRETTY_PRINT));
}

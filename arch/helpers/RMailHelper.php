<?php
/**
 * PHPMailer helper class
 * @author: Raysmond
 * @date: 13-11-27
 */

Rays::import("extensions.phpmailer.*");

class RMailHelper {

    public static $host = 'smtp.126.com';

    public static $smtpAuth = true;

    public static $userName = "fdugroup";

    public static $password = "fdugroup_edu";

    public static $fromEmail = "fdugroup@126.com";

    public static $fromName = "FDUGroup";

    public static $defaultReplyTo = "fdugroup@126.com";

    public static $isHtml = true;

    public static $stmpSecure = "tls"; // Enable encryption, 'ssl' also accepted

    public static function sendEmail($subject,$body,$toEmails)
    {
        $mail = new PHPMailer;

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = static::$host;                          // Specify main and backup server
        $mail->SMTPAuth = static::$smtpAuth;                  // Enable SMTP authentication
        $mail->Username = static::$userName;                  // SMTP username
        $mail->Password = static::$password;                  // SMTP password
        //$mail->SMTPSecure = static::$stmpSecure;              // Enable encryption, 'ssl' also accepted

        $mail->From = static::$fromEmail;
        $mail->FromName = static::$fromEmail;
        if(is_string($toEmails))
            $mail->addAddress($toEmails);
        else{
            foreach($toEmails as $email){
                $mail->addAddress($email);
            }
        }
        $mail->addReplyTo(static::$fromName, static::$fromName);
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        $mail->WordWrap = 50;                                 // Set word wrap to 50 characters
        //$mail->addAttachment('/var/tmp/file.tar.gz');       // Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');  // Optional name
        $mail->isHTML(static::$isHtml);                       // Set email format to HTML

        $mail->Subject = $subject;
        $mail->Body    = $body;
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        if(!$mail->send()) {
            return $mail->ErrorInfo;
        }

        return true;
    }

} 
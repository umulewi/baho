
<form action="" method="post">
    <input type="submit" value="save" name="save">
</form>
<?php
$email='umulewi@gmail.com';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $email;
    $subject = 'confirmatiion';
    $message = 'you have been hired,';
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'ntegerejimanalewis@gmail.com';
        $mail->Password = 'zwhcmifrjmnlnziz';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->setFrom('your_email@gmail.com');
        $mail->addAddress($email);
        $mail->isHTML(false);
        $mail->Subject = $subject; 
        $mail->Body = $message;
        $mail->send();
        echo "Email sent successfully!";
    } catch (Exception $e) {
        echo "Email sending failed. Error: {$mail->ErrorInfo}";
    }
}
?>

<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set SMTP configuration
ini_set('SMTP', 'smtp.gmail.com');
ini_set('smtp_port', '587');
ini_set('sendmail_from', 'your_email@gmail.com');
ini_set('auth_username', 'your_email@gmail.com');
ini_set('auth_password', 'your_password');

if (!$_POST) exit('No direct access allowed.');

// Email address verification
function isEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

if (!defined("PHP_EOL")) define("PHP_EOL", "\r\n");

$name = isset($_POST['name']) ? $_POST['name'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$subject = isset($_POST['subject']) ? $_POST['subject'] : '';
$message = isset($_POST['message']) ? $_POST['message'] : '';

if (trim($name) == '') {
    echo '<div class="error_message">Attention! You must enter your name.</div>';
    exit();
} else if (trim($email) == '') {
    echo '<div class="error_message">Attention! Please enter a valid email address.</div>';
    exit();
} else if (!isEmail($email)) {
    echo '<div class="error_message">Attention! You have entered an invalid e-mail address, try again.</div>';
    exit();
}

$address = "info@sansongrp.com";

$e_subject = 'You\'ve been contacted by ' . $name . '.';

$e_body = "Hello, You have been contacted by $name with this Email: $email regarding '$subject'. Below is their message: " . PHP_EOL . PHP_EOL;
$e_content = "\"$message\"" . PHP_EOL . PHP_EOL;
$e_reply = "You can contact $name via email, $email";

$msg = wordwrap($e_body . $e_content . $e_reply, 70);

$headers = "From: $email" . PHP_EOL;
$headers .= "Reply-To: $email" . PHP_EOL;
$headers .= "MIME-Version: 1.0" . PHP_EOL;
$headers .= "Content-type: text/plain; charset=utf-8" . PHP_EOL;
$headers .= "Content-Transfer-Encoding: quoted-printable" . PHP_EOL;

if (mail($address, $e_subject, $msg, $headers)) {
    echo "<fieldset>";
    echo "<div id='success_page'>";
    echo "<h1>Email Sent Successfully.</h1>";
    echo "<p>Thank you <strong>$name</strong>, your message has been submitted to us.</p>";
    echo "</div>";
    echo "</fieldset>";
} else {
    echo 'ERROR!';
}
?>

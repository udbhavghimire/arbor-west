<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

$mail = new PHPMailer;

$mail->isSMTP(); // Set mailer to use SMTP
$mail->Host = 'mail.arborwesthome.ca'; // Specify main and backup SMTP servers
$mail->SMTPAuth = true; // Enable SMTP authentication
$mail->Username = 'info@arborwesthome.ca'; // SMTP username
$mail->Password = 'arborwesthome'; // SMTP password
$mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587; // TCP port to connect to

$mail->setFrom('info@arborwesthome.ca', $_POST['name']);
$mail->addAddress('contact@homebaba.ca');

$mail->addReplyTo($_POST['email']);
$mail->isHTML(true);

$mail->Subject = "Arbor West Homes - Landing Page Inquiry";
$message = '<html>

<body>';
$message .= '<table rules="all" style="border:none;" cellpadding="3">';
$message .= "<tr>
            <td><strong>Name:</strong> </td>
            <td>" . strip_tags($_POST['name']) . "</td>
        </tr>";
$message .= "<tr>
            <td><strong>Phone:</strong> </td>
            <td>" . strip_tags($_POST['phone']) . "</td>
        </tr>";
$message .= "<tr>
            <td><strong>Email:</strong> </td>
            <td>" . strip_tags($_POST['email']) . "</td>
        </tr>";
$message .= "<tr>
        <td><strong>Realtor or working with one?:</strong> </td>
        <td>" . strip_tags($_POST['realtor']) . "</td>
    </tr>";
$message .= "<tr>
            <td><strong>Message : </strong> </td>
            <td>" . strip_tags($_POST['message']) . "</td>
        </tr>";
$message .= "<tr>
            <td><strong>Source : </strong> </td>
            <td>arborwesthome.ca</td>
        </tr>";
$message .= "</table>";
$message .= "</body>

</html>";

$mail->Body = $message;
$mail->AltBody = $_POST['message'] . $_POST['email'] . $_POST['name'] . $_POST['phone'];

if (!$mail->send()) {
    $_SESSION["error"] = "Application not submitted!";

    header('Location: index.php');
    exit();

} else {
    $_SESSION["success"] = "Application submitted.";
    header('Location: ./');
    exit();

}

?>
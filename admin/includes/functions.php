<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';  // Ensure this path is correct

function sendMail($to, $subject, $name, $description, $vehicle_number) {
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->SMTPDebug = 0;  // Disable debug output for production
        $mail->isSMTP();  // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';  // Set the SMTP server to send through
        $mail->SMTPAuth   = true;  // Enable SMTP authentication
        $mail->Username   = 'lorem.ipsum.sample.email@gmail.com';  // Your Gmail address
        $mail->Password   = 'novtycchbrhfyddx';  // Your Gmail App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Enable TLS encryption
        $mail->Port       = 587;  // TCP port for TLS

        // Recipients
        $mail->setFrom('johnlestermacabulos@gmail.com', 'Car Wash');  // Sender's email and name
        $mail->addAddress($to, $name);  // Recipient's email and name

        // Content
        $mail->isHTML(true);  // Set email format to HTML
        $mail->Subject = $subject;

        // Load HTML template for email body
        $template_path = 'includes/htmlEmail.html';  // Ensure this file path is correct
        if (file_exists($template_path)) {
            $mail->Body = file_get_contents($template_path);
        } else {
            return false;  // Template not found, return failure
        }

        // Replace placeholders in the email template with actual data
        $mail->Body = str_replace('{{name}}', $name, $mail->Body);
        $mail->Body = str_replace('{{description}}', $description, $mail->Body);
        $mail->Body = str_replace('{{vehicle_number}}', $vehicle_number, $mail->Body);

        // Send the email
        $mail->send();
        return true;  // Return success if email is sent
    } catch (Exception $e) {
        error_log("Email failed to send: {$mail->ErrorInfo}");  // Log error details
        return false;  // Return failure
    }
}

?>

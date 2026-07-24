<?php
require_once '../includes/config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING);
    $last_name = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
    $subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING);
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

    if (!$first_name || !$last_name || !$email || !$phone || !$subject || !$message) {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
        exit;
    }

    try {
        // Save to database
        $stmt = $pdo->prepare("INSERT INTO contact_queries (first_name, last_name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$first_name, $last_name, $email, $phone, $subject, $message]);

        // Send Email using PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = SMTP_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = SMTP_USER;
            $mail->Password   = SMTP_PASS;
            $mail->SMTPSecure = SMTP_SECURE === 'tls' ? PHPMailer::ENCRYPTION_STARTTLS : PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = SMTP_PORT;

            // Recipients
            $mail->setFrom(FROM_EMAIL, FROM_NAME);
            $mail->addAddress(CONTACT_EMAIL);
            $mail->addReplyTo($email, "$first_name $last_name");

            // Content
            $mail->isHTML(true);
            $mail->Subject = "New Contact Inquiry: $subject";
            $mail->Body    = "<h3>New Message Details:</h3>" .
                             "<p><b>Name:</b> $first_name $last_name</p>" .
                             "<p><b>Email:</b> $email</p>" .
                             "<p><b>Phone:</b> $phone</p>" .
                             "<p><b>Subject:</b> $subject</p>" .
                             "<p><b>Message:</b><br>" . nl2br($message) . "</p>";
            $mail->AltBody = "Name: $first_name $last_name\nEmail: $email\nPhone: $phone\nSubject: $subject\nMessage: $message";

            $mail->send();
        } catch (Exception $mail_error) {
            log_error("Email Error: " . $mail_error->getMessage() . " | ErrorInfo: " . $mail->ErrorInfo);
            echo json_encode(['status' => 'success', 'message' => 'Thank you! Your message was saved, but we encountered an error sending the email notification. (Error logged)']);
            exit;
        }

        echo json_encode(['status' => 'success', 'message' => 'Thank you! Your message has been sent successfully.']);
    } catch (PDOException $pdo_error) {
        log_error("Database Error: " . $pdo_error->getMessage());
        echo json_encode(['status' => 'error', 'message' => 'A database error occurred. (Error logged)']);
    } catch (Exception $general_error) {
        log_error("General Error: " . $general_error->getMessage());
        echo json_encode(['status' => 'error', 'message' => 'An unexpected error occurred. (Error logged)']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}

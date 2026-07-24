<?php
require_once '../includes/config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
    $location = filter_input(INPUT_POST, 'location', FILTER_SANITIZE_STRING);
    $expertise = filter_input(INPUT_POST, 'expertise', FILTER_SANITIZE_STRING);

    if (
        empty($name) ||
        empty($email) ||
        empty($phone) ||
        empty($location) ||
        empty($expertise)
    ) {
        echo json_encode([
            'status' => 'error',
            'message' => 'All fields are required.'
        ]);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid email address.'
        ]);
        exit;
    }

    if (!preg_match('/^[0-9]{10}$/', $phone)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid phone number.'
        ]);
        exit;
    }
    try {
        // Save to database
        $stmt = $pdo->prepare("INSERT INTO carrer (name, email, phone, location, expertise) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $email, $phone, $location, $expertise]);

        // Send Email using PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = SMTP_HOST;
            $mail->SMTPAuth = true;
            $mail->Username = SMTP_USER;
            $mail->Password = SMTP_PASS;
            $mail->SMTPSecure = SMTP_SECURE === 'tls' ? PHPMailer::ENCRYPTION_STARTTLS : PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = SMTP_PORT;

            // Recipients
            $mail->setFrom(FROM_EMAIL, FROM_NAME);
            $mail->addAddress(CONTACT_EMAIL);
            $mail->addReplyTo($email, $name);

            // Content
            $mail->isHTML(true);
            $mail->Subject = "New Application - $expertise";
            $mail->Body = "<h3>New Message Details:</h3>" .
                "<p><b>Name:</b> $name</p>" .
                "<p><b>Email:</b> $email</p>" .
                "<p><b>Phone:</b> $phone</p>" .
                "<p><b>Location:</b> $location</p>" .
                "<p><b>Expertise:</b> $expertise</p>";
            $mail->AltBody = "Name: $name\nEmail: $email\nPhone: $phone\nLocation: $location\nExpertise: $expertise";

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

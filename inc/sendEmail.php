<?php

$siteOwnersEmail = 'bitlakartik@gmail.com';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['contactName']);
    $email = trim($_POST['contactEmail']);
    $subject = trim($_POST['contactSubject']);
    $message = trim($_POST['contactMessage']);

    // Basic validation
    $errors = [];
    if (empty($name)) {
        $errors[] = "Please enter your name.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }
    if (empty($message) || strlen($message) < 15) {
        $errors[] = "Please enter a message with at least 15 characters.";
    }

    if (empty($errors)) {
        // Compose email message
        $messageBody = "Name: $name <br>";
        $messageBody .= "Email: $email <br>";
        $messageBody .= "Message: <br>$message";

        // Email headers
        $headers = "From: $name <$email>\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        // Send email
        if (mail($siteOwnersEmail, $subject, $messageBody, $headers)) {
            echo "OK";
        } else {
            echo "Something went wrong. Please try again.";
        }
    } else {
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
    }
} else {
    echo "Invalid request method.";
}

?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate inputs
    $errors = [];
    
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
    
    if (empty($name)) {
        $errors[] = "Name is required";
    }
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required";
    }
    
    if (empty($message)) {
        $errors[] = "Message is required";
    }
    
    if (!empty($errors)) {
        header("Location: index.html?status=error&message=" . urlencode(implode(", ", $errors)));
        exit;
    }
    
    // Email configuration
    $to = "your@email.com"; // Replace with your actual email
    $subject = "New Portfolio Message from $name";
    $body = "Name: $name\nEmail: $email\n\nMessage:\n$message";
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    
    // Send email
    if (mail($to, $subject, $body, $headers)) {
        header("Location: index.html?status=success&message=Message sent successfully! I'll get back to you soon.");
    } else {
        header("Location: index.html?status=error&message=Failed to send message. Please try again later or contact me directly at your@email.com");
    }
    exit;
}
?>
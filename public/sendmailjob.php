<?php

// Atur informasi email
$to = "antok2000@yahoo.com";
$subject = "Test Email";
$message = "This is a test email sent from sendemailjob.php";
$headers = "From: your@example.com";

// Kirim email
if (mail($to, $subject, $message, $headers)) {
    echo "Email has been sent";
} else {
    echo "Failed to send email";
}

file_put_contents('sendemailjob.log', 'Script executed at ' . date('Y-m-d H:i:s') . PHP_EOL, FILE_APPEND);

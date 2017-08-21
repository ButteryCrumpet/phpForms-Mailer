<?php
include_once "./formLib/form.classes.php";
include_once "./formLib/form.utils.php";

//make into class or lib or somethings
$errors;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $testf->process();
    $mail_data = $testf->theData;
    $errors = $testf->theErrors;

    $message = "Name: ". $mail_data['first-name'] ." ". $mail_data['last-name'];
    $message .= "(". $mail_data['first-furi'] .' '. $mail_data['last-furi'] .")". "\r\n";
    $message .= "Email: ". $mail_data['email']. "\r\n";
    $message .= "Phone No.: ". (!isset($mail_data['phone']) ? "Not provided" : $mail_data['phone']). "\r\n";
    $message .= $mail_data["content"];

    if ($testf->valid) {
        $sent = send_mail($mail_data['inquiry'], $mail_data['email'], $mail_data['subject'], $message);
        if ($sent) {
            echo "Mail Sent";
            //header("Location: ./confirmation.php");
        } else {
            echo "Could not send";
        }
    }
}

function send_mail($to, $from, $subject, $message) {
    $wrapped_message = wordwrap($message, 70, "\r\n");
    $headers = "From: ". $from ."\r\n".
        "X-Mailer: PHP/". phpversion();
    return mail($to, $subject, $wrapped_message, $headers);
}

?>
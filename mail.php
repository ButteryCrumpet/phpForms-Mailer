<?php
session_start();

//make into class or lib or somethings
$errors;

$mail_data = $_SESSION["testForm"];
$message = "";

foreach ($mail_data as $name => $data) {
    $message .= ucfirst($name). ": ". $data ."\r\n<br>";
}
//$sent = send_mail($mail_data['inquiry'], $mail_data['email'], $mail_data['subject'], $message);
echo $message;
echo '<a href="/" >Return To Form</a>';

session_unset($_SESSION["form-data"]);
session_destroy();

function send_mail($to, $from, $subject, $message) {
    $wrapped_message = wordwrap($message, 70, "\r\n");
    $headers = "From: ". $from ."\r\n".
        "X-Mailer: PHP/". phpversion();
    return mail($to, $subject, $wrapped_message, $headers);
}

?>
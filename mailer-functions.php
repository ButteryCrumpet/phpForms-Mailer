<?php
include "./formLib/form-classes.php";

$mail_addresses = array(
    "booking"=>"b1310321@gl.aiu.ac.jp", 
    "suggestion"=>"crumpetybumpety@gmail.com"
    );

$mailer_fields = array( 
    new GenericField('first-name', true),
    new GenericField('last-name', true),
    new KanaField('first-furi', true),
    new KanaField('last-furi', true),
    new EmailField('email', true),
    new PhoneNoField('phone'),
    new GenericField('subject', true),
    new GenericField('content', true),
    new KeyValueField('inquiry', true, $mail_addresses),
    );

$testf = new Form('mailer', $mailer_fields);

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

if (isset($errors)) {
 foreach ($errors as $field => $error){
        echo "<h2>". $field ." is ". $error ."</h2>";
    }
}

function send_mail($to, $from, $subject, $message) {
    $wrapped_message = wordwrap($message, 70, "\r\n");
    $headers = "From: ". $from ."\r\n".
        "X-Mailer: PHP/". phpversion();
    return mail($to, $subject, $wrapped_message, $headers);
}

?>
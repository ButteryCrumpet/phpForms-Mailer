<?php
session_start();

//shikkari shite fkng quickly //move onto akiken now, spend like two weeks on this
//make into class so much easier
//init func
$config = parse_ini_file("./testForm/config.ini", true);
$config = $config["mail"];
$mail_data = $_SESSION["testForm"];

//get data func
$data = "";
foreach ($mail_data as $name => $value) {
    $data .= ucfirst($name). ": ". $value ."\r\n";
}
//get data func

//parse func
$parsed = implode("\r\n" ,$config["format"]);
$formated = str_replace("{data}", $data, $parsed);

foreach ($mail_data as $name => $value) {
    $search = "{".$name."}";
    $formated = str_replace($search, $value, $formated);
}
//parse func

//add to an array then concat implode() //abstract to method
$Bcc = ($config["Bcc"] != "none") ? $config["Bcc"]."," : "";
$Bcc .= ($config["sendConfirmation"] == "Bcc") ? $mail_data[$config["customerMailName"]] : "";
$Cc = ($config["Bcc"] != "none") ? $mail_data["Bcc"]."," : "";
$Cc .= ($config["sendConfirmation"] == "Cc") ? $mail_data[$config["customerMailName"]] : "";
$to = $config[$mail_data[$config["emailInputName"]]].",";
$to .= ($config["additionalEmails"]) ? $config["additionalEmails"] : "";

$headers = "From: ". $from ."\r\n"."X-Mailer: PHP/". phpversion();
$headers .= "CC: ". $Cc ."\r\n";
$headers .= "Bcc: ". $Bcc ."\r\n";

$sent = send_mail($to, $mail_data[$config["customerMailName"]], $mail_data['subject'], $formated, $headers);

if ($sent){
    echo $message;
    echo "sent";
    session_unset($_SESSION["form-data"]);
    session_destroy();
} else {
    echo "error";
}

function send_mail($to, $from, $subject, $message, $headers) {
    $wrapped_message = wordwrap($message, 70, "\r\n");
    return mail($to, $subject, $wrapped_message, $headers);
}

?>
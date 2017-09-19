<?php
session_start();
//make into class so much easier - no need, just make it functional?

//redirect if no formname
if (!isset($_GET["formName"])){
    header("Location: /");
    die();
}
$formName = $_GET["formName"]; 
$config_file = "./config.ini";
$config = parse_ini_file($config_file, true);
$mail_data = $_SESSION[$formName];

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
$Bcc = ($config["Bcc"] != "none") ? $config["Bcc"] : "";
if ($config["sendConfirmation"] == "true") {
    $Bcc .= ", ".$mail_data[$config["customerMailInputName"]];
}
$Cc = ($config["CC"] != "none") ? $mail_data["CC"] : "";
$to = $config[$mail_data[$config["emailInputName"]]].",";
$to .= ($config["additionalEmails"]) ? $config["additionalEmails"] : "";

$headers = "From: ". $from ."\r\n"."X-Mailer: PHP/". phpversion();
$headers .= "CC: ". $Cc ."\r\n";
$headers .= "Bcc: ". $Bcc ."\r\n";

$sent = send_mail($to, $mail_data[$config["customerMailInputName"]], $mail_data['subject'], $formated, $headers);

if ($sent){
    session_unset($_SESSION["form-data"]);
    session_destroy();
    header("Location: ". "../".$config["mailSent"]);
    die();
} else {
    header("Location: ". $config["mailFailed"]);
    die();
}

function send_mail($to, $from, $subject, $message, $headers) {
    $wrapped_message = wordwrap($message, 70, "\r\n");
    return mail($to, $subject, $wrapped_message, $headers);
}
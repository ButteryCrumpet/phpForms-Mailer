<?php
//config 
include "./formLib/form-classes.php";
include "./mailer-functions.php";

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

?>
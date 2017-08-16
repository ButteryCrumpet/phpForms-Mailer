<?php
/* Needs fixing

$_FORMS;

function create_form($name, $fields) {
    $form = new Form($name, $fields);
    register_form($form);
}

function register_form($form) {
    $_FORMS[$form->name] = $form;
}

function get_form($name){
    if (!isset($_FORMS[$name])) {
        echo 'failed';
    } else {
        return $_FORMS[$name];
    }
}

function get_form_data($name) {
    $form = get_form($name);
    $form->process();
    return $form->theData;
}
*/

function send_mail($to, $from, $subject, $message) {
    $wrapped_message = wordwrap($message, 70, "\r\n");
    $headers = "From: ". $from ."\r\n".
        "X-Mailer: PHP/". phpversion();
    return mail($to, $subject, $wrapped_message, $headers);
}

?>
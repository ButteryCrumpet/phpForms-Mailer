<?php

include "formLib/dom.utils.php";
include "formLib/form.classes.php";
include "formLib/form.auto.php";
include 'mailer/mail.class.php';
include 'config.php';

function displayAutoForm($formName) {

    if (!formExists($formName)) {
        to404();
        return false;
    }

    $template = 'forms/'.$formName.'/form.php';
    $config_file = 'forms/'.$formName.'/config.ini';

    $config = parse_ini_file($config_file, true);
    $form = new AutoForm($formName, $template, $config);
    if ($form->checkValid()) {
        $form->onValidAction();
    } else {
        $form->render();
    }
}

function displayConfirmation($formName) {

    if (!formExists($formName)) {
        to404();
        return false;
    }

    if (isset($_SESSION[$formName.SECURE_KEY])) {
        $formData = $_SESSION[$formName.SECURE_KEY];
    } else {
        to404();
        return false;
    }
    $confirm_template = "forms/".$formName."/confirmation.php";
    $confirm_dom = DOMUtils::generateDOMfromFile($confirm_template);
    $elements = DOMUtils::getElementsByHasAttributes($confirm_dom, array("data-kakunin"));
    foreach ($elements as $element) {
        $name = $element->getAttribute("data-kakunin");
        if (isset($formData[$name])) {
            $text = new DOMText($formData[$name]);
            $element->appendChild($text);
        } else {
            $text = new DOMText("N/A");
            $element->appendChild($text);
        }
    }
    echo $confirm_dom->saveHTML();
    return true;
}

function formToMail($formName) {

    if (!formExists($formName)) {
        to404();
        return false;
    }

    $config_file = "config/mail.ini";
    $config = parse_ini_file($config_file, true);
    $mail_data = $_SESSION[$formName.SECURE_KEY];

    $input = '';
    foreach ($mail_data as $name => $value) {
        $input .= ucfirst($name). ": ". $value ."\r\n";
    }

    $parsed = implode("\r\n" ,$config["format"]);
    $formated = str_replace("{data}", $input, $parsed);
    
    foreach ($mail_data as $name => $value) {
        $search = "{".$name."}";
        $formated = str_replace($search, $value, $formated);
    }

    $data = array(
        'to' => $config[$mail_data[$config["emailInputName"]]],
        'from' => $mail_data[$config["customerMailInputName"]],
        'CC' => $mail_data["CC"],
        'Bcc' => $config["Bcc"],
        'message' => $formated,
        'subject' => $mail_data['subject'],
    );

    $mail = new Mail($data);
    $sent = $mail->send();

    if ($sent){
        session_destroy();
        echo "Mail Sent";
        die();
    } else {
        echo "Mail Not Sent";
        die();
    }
}

function getNameConfirmFromURL($url) {
    $sections = explode("/", $url);
    $last = array_pop($sections);
    $data = array(
        'name' => '',
        'confirmation' => false,
        'mail' => false,
    );

    if ($last == '') {
        $last = array_pop($sections);
    }

    if ($last === CONFIRM_URI) {
        $data['confirmation'] = true;
        $name = array_pop($sections);
        $data['name'] = $name;
    } elseif ($last == MAIL_URI) {
        $data['mail'] = true;
        $name = array_pop($sections);
        $data['name'] = $name;
    } else {
        $data['name'] = $last;
    }

    return $data;
}

function formExists($name) {
    if (in_array($name, FORMS)) {
        return true;
    } else {
        return false;
    }
}

function to404() {
    header('Location: ' . URI_404 );
}

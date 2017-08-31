<?php

include_once $_SERVER['DOCUMENT_ROOT']."/domLib/dom.utils.php";
include_once "form.classes.php";
include_once "form.auto.php";

function displayAutoForm($name) {
    $template = "./".$name."/form.php";
    $config_file = "./".$name."/config.ini";

    $config = parse_ini_file($config_file, true);
    $form = new AutoForm($name, $template, $config);
    if ($form->checkValid()) {
        $form->onValidAction();
    }

    return $form;
}

function displayConfirmation() {
    $formName = $_GET["form"];
    if (isset($_SESSION[$formName])) {
        $formData = $_SESSION[$formName];
    } else {
        header("Location: /");
        die();
    }
    $confirm_template = "./".$formName."/confirmation.php";
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
}
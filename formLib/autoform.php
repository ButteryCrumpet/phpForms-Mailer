<?php

include "dom.utils.php";
include "form.classes.php";
include "form.auto.php";

function displayAutoForm($name) {
    $template = "./".$name."/form.php";
    $config_file = "./".$name."/config.ini";

    $config = parse_ini_file($config_file, true);
    $form = new AutoForm($name, $template, $config);
    if ($form->checkValid()) {
        $form->onValidAction();
    } else {
        $form->render();
    }
}

function displayConfirmation() {
    $formName = $_GET["form"];
    if (isset($_SESSION[$formName])) {
        $formData = $_SESSION[$formName];
    } else {
        echo "<h2>There was an error processing this request</h2>";
        return false;
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
    return true;
}
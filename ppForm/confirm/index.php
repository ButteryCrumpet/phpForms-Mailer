<?php
session_start();
include '../formLib/dom.utils.php';

function displayConfirmation() {
    $formName = $_GET["form"];
    if (isset($_SESSION[$formName])) {
        $formData = $_SESSION[$formName];
    } else {
        if (!isset($_SESSION)) echo "Nooooo";
        print_r($_SESSION);
        echo "<h2>There was an error processing this request</h2>";
        return false;
    }
    $confirm_template = "../templates/confirmation.php";
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

displayConfirmation();

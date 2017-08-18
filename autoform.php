<?php

include_once "./domLib/dom.utils.php";
include_once "./formLib/form.classes.php";
include_once "./formLib/form.utils.php";
include_once "./autoform-functions.php";

libxml_use_internal_errors(true);

$config_vars = parse_ini_file('config.ini', true);
$attr_config = $config_vars["attributes"];
$em_config = $config_vars["error-message"];

$dom = DOMUtils::generateDOMfromFile("./tests/randomForm.html");
$form_elements = DOMUtils::getElementsByHasAttributes($dom, array($attr_config["ppForm"]));
$error_elements = DOMUtils::getElementsByHasAttributes($dom, array($em_config["attribute"]));

if($_SERVER['REQUEST_METHOD'] == 'GET') {
    foreach ($error_elements as $element) {
        DOMUtils::deleteElement($element);
    }
}

//this needs to be cleaned and config table implemented
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form = buildAutoForm("testForm", $form_elements, $attr_config['validator-type']);
    $form->process();

    foreach ($form->fields as $field) {
        
    }
}

echo $dom->saveHTML();

$end_time = microtime(TRUE);

exit();
<?php
include_once "./templator/templator-classes.php";
include_once "./formLib/auto-form.php";

libxml_use_internal_errors(true);
$template = new Template("mailer.php");
$html = mb_convert_encoding($template->render(), 'HTML-ENTITIES', 'UTF-8');

$dom = new domDocument;
$dom->loadHTML($html);
$dom->preserveWhiteSpace = false;
$inputs = $dom->getElementsByTagName('input');
$fields = array();

foreach ($inputs as $input) {
    $name = $input->getAttribute("name");
    $required = $input->hasAttribute("data-required");
    if ($input->hasAttribute("data-valid")) {
        $validation = $input->getAttribute("data-valid");
    } else {
        $validation = "generic";
    }

    $field = array(
        "name" => $name,
        "required" => $required,
        "validation" => $validation
    );

    $fields[] = $field;    
}

$form = new AutoForm($fields);

echo $dom->saveHTML();

exit();
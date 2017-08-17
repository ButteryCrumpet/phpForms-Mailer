<?php
include_once "./templateLib/template.classes.php";
include_once "./formLib/form.classes.php";
include_once "./formLib/form.utils.php";

//libxml_use_internal_errors(true);

$config_vars = parse_ini_file('config.ini', true);

$template = new Template("mailer.php");
$dom = $template->createDOM();

//selects and textareas also
$elements = $dom->getElementsByTagName('input');
$serializable = array();

foreach ($elements as $element) {
    $field = FormUtils::serializableFromHTML($element);

    if ($field["validation"] == 'keyval') {
        if(!isset($config_vars[$field['name']])) {
            throw new Exception("missing config vars for ". $name);
        } else {
            $field['keyvars'] = $config_vars[$name];
        }
    }
    $serializable[] = $field;
}

$fields = FormUtils::makefields($serializable);
$form = new Form('contact', $fields);
$form->process();
//if error addClass(.error) + append sibling containing error
//error HTML from config?

print_r($form->theErrors);
echo $dom->saveHTML();

exit();
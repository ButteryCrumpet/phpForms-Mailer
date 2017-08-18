<?php

function buildAutoForm($formName, $elements, $valLabel) {
    $form = new Form($formName);
    foreach ($elements as $element) {    
        $field = buildField($element, $valLabel);
        $form->addField($field);
    }
    return $form;
}

function buildField($element, $valLabel) {
    $attrs = DOMUtils::getAttributesAsArray($element);
    $name = $attrs['name'];
    $required = array_key_exists("data-required", $attrs);
    if(array_key_exists($valLabel, $attrs)) {
        $validation = $attrs[$valLabel];
    } else {
        $validation = "generic";
    }
    $args = $attrs;

    if ($validation == "kayval") {
        if(!isset($config_vars[$field->name])) {
            throw new Exception("missing config vars for ". $name);
        } else {
            $args['keyvals'] = $config_vars[$name];
        }
    }
    $field = FormUtils::makeField($name, $validation, $required, $args);
    return $field;
}
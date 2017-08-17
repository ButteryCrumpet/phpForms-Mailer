<?php
include_once "form-classes.php";
//turn into collections of static utilities for forms
class FormUtils {

    public static function serializableFromHTML($element) {
        $field = array();
        
        $field["name"] = $element->getAttribute("name");
        $field["required"] = $element->hasAttribute("data-required");
        if ($element->hasAttribute("data-valid")) {
            $field["validation"] = $element->getAttribute("data-valid");
        } else {
            $field["validation"] = "generic";
        }

        return $field;
    }

    public static function makefields($serializables){
        $fields = array();
        foreach ($serializables as $unbuiltfield) {
            $field = self::makefield($unbuiltfield);
            $fields[] = $field;
        }
        return $fields;
    }
    //will eventually need rewriting for extensibility
    public static function makefield($args) {
        $fieldClass;

        $name = $args['name'];
        $required = $args['required'];
        $type = $args['validation'];

        switch($type) {
            case "generic":
                $fieldClass = new GenericField($name, $required);
                break;
            case "email":
                $fieldClass = new EmailField($name, $required);
                break;
            case "kana":
                $fieldClass = new KanaField($name, $required);
                break;
            case "phone":
                $fieldClass = new PhoneNoField($name, $required);
                break;
            case "url":
                $fieldClass = new URLField($name, $required);
                break;
            case "keyval":
                $keyvals = $args['keyvals'];
                $fieldClass = new KeyValueField($name, $required, $keyvals);
                break;
        }

        return $fieldClass;
    }
}

?>
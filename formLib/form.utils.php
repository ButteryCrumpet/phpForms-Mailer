<?php

class FormUtils {

    public static function serializableFromHTML($element) {
        $field = array();
        
        $field["name"] = $element->getAttribute("name");
        $field["required"] = $element->hasAttribute("data-required");
        if ($element->hasAttribute("data-valid")) {
            $field["validation"] = $element->getAttribute("data-valid");
            echo $field["validation"];
        } else {
            $field["validation"] = "generic";
        }

        return $field;
    }

    public static function makeFields($serializables){
        $fields = array();
        foreach ($serializables as $unbuiltfield) {
            $field = self::makeField($unbuiltfield);
            $fields[] = $field;
        }
        return $fields;
    }
    //will eventually need rewriting for extensibility
    public static function makeField($name, $validation, $required, $args) {
        $fieldClass;
        $type = $validation;
        $required = $required;

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
                $keyvals = $args['args'];
                $fieldClass = new KeyValueField($name, $required);
                break;
            case "zip":
                $fieldClass = new JapanZipField($name, $required);
                break;
            default:
                throw new Exception("Validation type:". $type ."does not exist");
                return 0;
                break;
        }

        return $fieldClass;
    }
}

?>
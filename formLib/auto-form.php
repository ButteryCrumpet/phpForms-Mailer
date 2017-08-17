<?php
include_once "form-classes.php";
//rewrite for DOM
class AutoForm extends Form {
    //$fields
    private $template;
    private $unbuiltFields;
    
    function __construct($fields){
        $this->unbuiltFields = $fields;
        $this->build_fields();
    }
    
    private function build_fields(){
        foreach ($this->unbuiltFields as $field) {
            $name = $field["name"];
            $required = $field["required"];
            $type = $field["generic"];

            $this->makefield($name, $required, $type);
        }
    }

    private function makefield($name, $required, $type) {
        switch($type) {
            case "generic":
                $class = new GenericField($name, $required);
                $this->fields[$name] = $class;
                break;
            case "email":
                $class = new EmailField($name, $required);
                $this->fields[$name] = $class;
                break;
            case "kana":
                $class = new KanaField($name, $required);
                $this->fields[$name] = $class;
                break;
            case "phone":
                $class = new PhoneNoField($name, $required);
                $this->fields[$name] = $class;
                break;
            case "url":
                $class = new URLField($name, $required);
                $this->fields[$name] = $class;
                break;
            case "keyval":
                if (array_key_exists($name, $this->fields)) {
                    break;
                } else {
                    $config = parse_ini_file('config.ini', true);
                    $keyvals = $config[$name];
                    $class = new KeyValueField($name, $required, $keyvals);
                    $this->fields[$name] = $class;
                }
                break;
        }
    }
}

?>
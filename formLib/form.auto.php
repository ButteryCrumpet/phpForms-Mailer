<?php

class AutoForm extends Form {

    protected $elements;
    protected $errorElements;
    protected $config;

    //change to taking parent element and grabbing
    //child with tags/attr defined in config
    //this allows for multiple instances
    function __construct($name, $elements, $config) {
        $this->name = $name;
        $this->elements = $elements;
        $this->config = $config;

        foreach ($elements as $element) {    
            $field = $this->buildFieldFromElement($element);
            $this->addField($field);
        }
    }

    public function buildFieldFromElement($element) {
        $classTable = $this->config['validator-types'];
        $attr_config = $this->config['attributes'];
        $attrs = DOMUtils::getAttributesAsArray($element);
        $field;
    
        $name = $attrs['name'];
        $required = array_key_exists($attr_config['required'] ,$attrs);
        $validation = '';
    
        if(!array_key_exists($attr_config['validator-type'], $attrs)) {
            $field = new GenericField($name, $required);
        } else {
            $validation = $attrs['data-valid'];
            $className = $classTable[$validation];
            $field = new $className($name, $required);
        }

        //data-options="$name" $name defined in config, adds to field options
        if ($validation == "kayval") {
            if(!isset($config[$field->name])) {
                throw new Exception("missing config vars for ". $name);
            } else {
                $field->addOptions('keyvals', $config_vars[$name]);
            }
        }

        return $field;
    }

    public function addErrorElement($elements) {
        
    }
}

?>
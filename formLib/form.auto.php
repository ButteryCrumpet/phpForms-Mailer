<?php

include_once "./domLib/dom.utils.php";
include_once "form.classes.php";

class AutoForm extends Form {

    protected $name;
    protected $action;
    protected $elements;
    protected $errorElements;
    protected $config;
    protected $DOM;

    //change to taking parent element and grabbing
    //child with tags/attr defined in config
    //this allows for multiple instances
    function __construct($name, $file, $action, $config, $confirm_template = "NONE") {
        $this->DOM = DOMUtils::generateDOMfromFile($file);
        $this->config = $config;
        $this->name = $name;
        $this->action = $_SERVER['DOCUMENT_ROOT']."/".$action;
        $this->confirmation_template = $_SERVER['DOCUMENT_ROOT']."/".$confirm_template;
        echo $this->confirmtion_template;

        $this->elements = DOMUtils::getElementsByHasAttributes($this->DOM, array($this->config["attributes"]["ppForm"]));

        foreach ($this->elements as $element) {    
            $field = $this->buildFieldFromElement($element);
            $this->addField($field);
        }

        $this->findErrorElements();
    }

    protected function buildFieldFromElement($element) {
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

        $field->addMainElement($element);

        return $field;
    }

    public function findErrorElements() {
        $elements = DOMUtils::getElementsByHasAttributes($this->DOM, array($this->config["error-message"]["attribute"]));
        foreach ($elements as $element) {
            $this->errorElements[] = $element;
            $config_vars = $this->config['error-message'];
            $attr = $element->getAttribute($config_vars['attribute']);
            $values = explode('|', $attr);
            $type = $values[0];
            $name = $values[1];
            $field = $this->fields[$name];
            $field->addErrorElement($element, $type);
        }
    }

    public function handleErrors($hideEMs = true, $retainData = true) {
        if (!$this->valid) {
            $this->addErrorClass();
            if ($hideEMs) {
                $this->hideErrorMessages();
            }
            if ($retainData) {
                $this->retainValues();
            }
        } 

        return $this->theErrors;
    }

    protected function addErrorClass() {
        $errorClass = $this->config["attributes"]["error-class"];
        foreach ($this->errorFields as $field) {
            DOMUtils::addClass($field->mainElement, "hasError");
        }
    }

    protected function hideErrorMessages() {
        foreach ($this->fields as $field) {
            $errorType = $field->error;
    
            foreach ($field->errorElements as $type => $element) {
                if ($type != $errorType) {
                    DOMUtils::deleteElement($element);
                }
            } 
        }
    }

    protected function retainValues() {
        foreach ($this->fields as $field) {
            $tag = $field->mainElement->tagName;
            $type = $field->mainElement->getAttribute("type");

            if($type == "text"){
                $val = ($field->valid) ? $field->value : $field->predata;
                $field->mainElement->setAttribute("value", $val);
                continue;
            } elseif ($tag == "textarea") {
                $text = ($field->valid) ? $field->value : $field->predata;
                $content = new DOMText($text);
                $field->mainElement->appendChild($content);
                continue;
            } elseif ($type == "radio") {
                $val = $field->predata;
                $r_elements = DOMUtils::filterByAttributeValues($this->elements, array("value" => $val));
                $r_elements[0]->setAttribute("checked", "checked");
                continue;
            } elseif ($type = "checkbox" && $tag != "select") {
                $ch_elements = DOMUtils::filterByAttributeValues($this->elements, array("name" => $field->name."[]"));
                $values = ($field->valid) ? $field->value : $field->predata;
                $values = explode(" ", $values);
  
                foreach ($ch_elements as $ch_element) {
                    $ch_element->removeAttribute("checked");
                    foreach($values as $value) {
                        if ($ch_element->getAttribute("value") == $value) {
                            $ch_element->setAttribute("checked", "checked");
                        }
                    }             
                }
                continue;
            } elseif ($tag == "select") {
                continue;
            }
        }
    }

    protected function renderConfirmation() {
        $confirm_dom = DOMUtils::generateDOMfromFile($this->confirmation_template);
        $elements = DOMUtils::getElementsByHasAttributes($confirm_dom, array("data-kakunin"));
        foreach ($elements as $element) {
            $name = $element->getAttribute("data-kakunin");
            if (isset($this->theData[$name])) {
                $text = new DOMText($this->theData[$name]);
                $element->appendChild($text);
            } else {
                $text = new DOMText("N/A");
                $element->appendChild($text);
            }
        }
        echo $confirm_dom->saveHTML();
    }

    protected function doAction() {
        $act = $this->action;
        echo "<script>window.location = '". $act ."';</script>";
        echo '<META HTTP-EQUIV="refresh" content="0;URL='. $act .'">';
        return $act;
    }

    public function render() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //this has to move on and redirect back if errors? needs handling page?
            $this->process();
            if (!$this->valid) {
                $this->handleErrors(); //needs to render submit action button
            } else {
                $_SESSION[$this->name] = $this->theData;
                if ($this->confirmation_template == "NONE") {
                    $this->doAction();
                } else {
                    $this->renderConfirmation();           
                }
                
                return $this->theData;
            }
            
            return null;

        } elseif ($_SERVER['REQUEST_METHOD'] == 'GET'){
            foreach ($this->errorElements as $element) {
                DOMUtils::deleteElement($element);
            }
        } else {
            echo "400: Bad request";
            return null;
        }
        echo $this->DOM->saveHTML();
        return true;
    }
}

?>
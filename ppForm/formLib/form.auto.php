<?php

include_once "dom.utils.php";
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
    //this allows for multiple instances???
    function __construct($name, $file, $config) {
        $this->DOM = DOMUtils::generateDOMfromFile($file);
        $this->config = $config;
        $this->name = $name;
        $this->action = $config["main"]["onValidation"];

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
            $name = $element->getAttribute($config_vars['attribute']);
            $field = $this->fields[$name];
            $field->addErrorElement($element);
        }
    }

    public function handleErrors($hideEMs = true, $retainData = true) {
        if (!$this->valid) {
            $this->addErrorClass();
            if ($hideEMs) {
                $this->setErrorMessages();
            }
            if ($retainData) {
                $this->retainValues();
            }
        } 

        return $this->theErrors;
    }

    protected function addErrorClass() {
        $errorClass = $this->config['error-message']["error-class"];
        foreach ($this->errorFields as $field) {
            DOMUtils::addClass($field->mainElement, $errorClass);
        }
    }

    protected function setErrorMessages() {
        foreach ($this->fields as $field) {
            if (count($field->errorElements) > 0) {
                foreach ($field->errorElements as $errorEle) {
                    if ($field->valid && isset($errorEle)) {
                        DOMUtils::deleteElement($errorEle);
                    } elseif (isset($errorEle)) {
                        $errorType = $field->error;
                        $fieldName = $field->name;
                        if ($errorType == 'required') {
                            $message = $fieldName . $this->config['error-message']['require-message'];
                        } else {
                            $message = $fieldName . $this->config['error-message']['invalid-message'];
                        }
                        $messageNode = new DOMText($message);
                        $errorEle->appendChild($messageNode);
                    }
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
                $val = ($field->valid) ? $field->value : $field->predata;
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
                $value = ($field->valid) ? $field->value : $field->predata;
                $children = $field->mainElement->childNodes;
                foreach($children as $child) {
                    foreach($child->childNodes as $gc) {
                        if (is_a($gc, 'DOMElement')) {
                            if ($gc->getAttribute("value") == $value) {
                                $gc->setAttribute("selected", "selected");
                            }
                        }
                    }
                }
                continue;
            }
        }
    }

    public function checkValid() {
        $this->process();
        if (!$this->valid) {
            return false;
        } else {
            $_SESSION[$this->name.SECURE_KEY] = $this->theData;        
            return true;
        }
    }

    public function onValidAction() {
        $act = $this->action;
        echo "redirecting... if not click here: Insert Link";
        echo '<script>window.location = "'. $act .'";</script>';
        echo '<META HTTP-EQUIV="refresh" content="0;URL="'. $act .'">';
        return $act;
    }
 
    public function render() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!$this->valid) {
                $this->handleErrors();
                echo $this->DOM->saveHTML();
                return true;
            }
            return "Valid but not redirected";

        } elseif ($_SERVER['REQUEST_METHOD'] == 'GET'){
            if ($this->config["main"]["JavaScriptErrors"] != "true"){
                if (count($this->errorElements) > 0)
                foreach ($this->errorElements as $element) {
                    DOMUtils::deleteElement($element);
                }
            }
            echo $this->DOM->saveHTML();
            return true;
        } else {
            echo "400: Bad request";
            return null;
        }
        return false;
    }
}
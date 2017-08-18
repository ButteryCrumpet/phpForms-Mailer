<?php
//move validators to a ?static? class for easy extension?
//register validator -> add to class? euughh how do others do it?
//needs post code validation
//!!!!make validators just return true/false!!!!
abstract class Field {

    protected $name;
    protected $isRequired;
    protected $error;
    protected $valid;
    protected $value;
    protected $predata;
    protected $extraOptions;
    protected $elements;

    function __construct($name, $required ,$args = null) {
        $this->name = $name;
        $this->isRequired = $required;
        $this->extraOptions = $args;
    }

    //turn into getters
    public function __get($name)
    {
        return $this->$name;
    }

    public function process() {
        $data = $this->getRawData();

        if (!$this->error && $data) {
            $this->predata = $this->sanitize($data);
            $data = $this->validate($data);
            if (!$this->error) {
                $this->value = $data;
                $this->valid = true;
            }
        } elseif (!$this->error) {
            $this->value = '';
            $this->valid = true;
        }
    }

    protected function throwError($error) {
        $this->error = $error;
    }

    protected function getRawData() {
        if (empty($_POST[$this->name]) && $this->isRequired) {
            $this->throwError('required');
        } else {
            return $_POST[$this->name];
        }
    }

    abstract protected function validate($data);

    protected function sanitize($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlentities($data, ENT_NOQUOTES, "UTF-8");
        return $data;
    }

    public function associateElement($element, $type) {
        $this->elements[$type] = $element;
        return $this->elements;
    }
}

class GenericField extends Field {

    protected function validate($data) {
        return $data;
    }
}

class EmailField extends Field {

    protected function validate($data) {
        if (filter_var($data, FILTER_VALIDATE_EMAIL)) {
            return $data;
        } else {
            $this->throwError('invalid');
        }
    }
}

class KanaField extends Field {

    protected function validate($data) {
        $kanaRX = "/^([゠ァアィイゥウェエォオカガキギクグケゲコゴサザシジスズセゼソゾタダチヂッツヅテデトドナニヌネノハバパヒビピフブプヘベペホボポマミムメモャヤュユョヨラリルレロヮワヰヱヲンヴヵヶヷヸヹヺ・ーヽヾヿ]+)$/u";
        $valid = preg_match($kanaRX, $data);
        if ($valid) {
            return $data;       
        } else { 
            $this->throwError('invalid');
        }
    }
}

class PhoneNoField extends Field {

    protected function validate($data) {
        $number = str_replace("-", "", $data);
        $valid = preg_match('/^\(?\+?([0-9]{1,4})\)?[-\. ]?(\d{3})[-\. ]?([0-9]{7})$/', $number);
        if ($valid) {
            return $data;       
        } else {
            $this->throwError('invalid');
        }
    }
}

class JapanZipField extends Field {

    protected function validate($data) {
        $pattern =  "/^([0-9]){3}-?([0-9]){4}$/";
        $valid = preg_match($pattern, $data);
        if ($valid) {
            return $data;
        } else {
            $this->throwError('invalid');
        }
    }
}

class URLField extends Field {

    protected function validate($data) {
        $valid = preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $data);
        if ($valid) {
            return $data;       
        } else { 
            $this->throwError('invalid');
        }
    }
}

class KeyValueField extends Field {

    protected function validate($data) {
        $keyvals = $this->extraOptons["keyvals"];
        $valid = array_key_exists($data, $keyvals);
        if ($valid){
            return $keyvals[$data];
        } else {
            $this->throwError('invalid');
        }
    }
}

class Form {

    protected $name;
    protected $fields;
    protected $theData;
    protected $theErrors;
    protected $valid;
    protected $validFields;
    protected $errorFields;

    function __construct($name, $fields = null, $args = null) {
        $this->name = $name;
        if (isset($fields)) {
            foreach($fields as $field) {
                $this->addField($field);
            }
        }
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function addField($field) {
        $this->fields[$field->name] = $field;
    }

    public function process() {
        foreach ($this->fields as $key => $field) {
            $field->process();
            if ($field->valid) {
                $this->validFields[$field->name] = $field;
                $this->theData[$field->name] = $field->value;
            } else {
                $this->errorFields[$field->name] = $field;
                $this->theErrors[$field->name] = $field->error;
                $this->theData[$field->name] = $field->predata; //dangerous?
            }
        }

        if (!$this->errorFields) {
            $this->valid = true;
        }
    }

}

?>
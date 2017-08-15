<?php

namespace formLib;

abstract class Field {

    protected $name;
    protected $isRequired;
    protected $error;
    protected $valid;
    protected $value;

    function __construct($name, $isRequired = false, $options = null) {
        $this->name = $name;
        $this->isRequired = $isRequired;
    }

    //turn into getters
    public function __get($name)
    {
        return $this->$name;
    }

    public function process() {
        $data = $this->getRawData();

        if (!$this->error && $data) {
            $data = $this->sanitize($data);
            $data = $this->validate($data);
            if (!$this->error) {
                $this->value = $data;
                $this->valid = true;
            }
        }

        return null;
    }

    protected function throwError($error) {
        $this->error = $error;
    }

    protected function getRawData() {
        if (empty($_POST[$this->name]) && $this->isRequired) {
            echo 'req error';
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
    //make these just return true/false
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

class URLField extends Field {

    protected function validate($data) {
        $valid = !preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $data);
        if ($valid) {
            return $data;       
        } else { 
            $this->throwError('invalid');
        }
    }
}

class KeyValueField extends Field {

    protected $key_vals;

    function __construct($name, $isRequired, $KeyValuePairs) {
        $this->key_vals = $KeyValuePairs;
        parent::__construct($name, $isRequired);
    }

    protected function validate($data) {
        $valid = array_key_exists($data, $this->key_vals);
        if ($valid){
            return $this->key_vals[$data];
        } else {
            $this->throwError('invalid');
        }
    }
}

class Form {

    protected $fields;
    protected $theData;
    protected $theErrors;
    protected $valid;
    protected $validFields;
    protected $errorFields;

    function __construct($fields, $args = null) {
        foreach($fields as $field) {
            $this->fields[$field->name] = $field;
        }
    }

    public function __get($name)
    {
        return $this->$name;
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
            }
        }

        if (!$this->errorFields) {
            $this->valid = true;
        }
    }

}

?>

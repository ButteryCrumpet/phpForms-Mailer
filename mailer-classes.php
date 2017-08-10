<?php
//make validate sanitize statics?
//add default html?
abstract class Field {

    protected $name;
    protected $isRequired;
    protected $raw_data;
    protected $sanitized_data;
    protected $validated_data;
    protected $hasError;
    protected $error;

    function __construct($name, $isRequired) {
        $this->name = $name;
        $this->isRequired = $isRequired;
        $this->getRawData();
        if (!$this->hasError) {
            $this->sanitize();
            $this->validate();
        }
    }

    public function theData() {
        return $this->validated_data;
    }

    public function error() {
        if ($this->hasError) {
            return $this->error;
        } else {
            return;
        }
    }

    protected function getRawData() {
        if (empty($_POST[$this->name]) && $this->isRequired) {
            $this->hasError = true;
            $this->error = 'Err: required';
        } else {
            $this->raw_data = $_POST[$this->name];
        }
    }

    abstract protected function validate();

    protected function sanitize() {
        $data = $this->raw_data;
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlentities($data, ENT_NOQUOTES, "UTF-8");
        $this->sanitized_data = $data;
    }
}

class GenericField extends Field {

    protected function validate() {
        $this->validated_data = $this->sanitized_data;
    }
}

class EmailField extends Field {

    protected function validate() {
        if (filter_var($this->sanitized_data, FILTER_VALIDATE_EMAIL)) {
            $this->validated_data = $this->sanitized_data;
        } else {
            $this->hasError = true;
            $this->error = 'invalid email';
        }
    }
}

class PhoneNoField extends Field {

    protected function validate() {
        $number = str_replace("-", "", $this->sanitized_data);
        $valid = preg_match('/^\(?\+?([0-9]{1,4})\)?[-\. ]?(\d{3})[-\. ]?([0-9]{7})$/', $number);
        if ($valid) {
            $this->validated_data = $number;       
        } else { 
            $this->hasError = true;
            $this->error = 'invalid phone number';
        }
    }
}

class URLField extends Field {

    protected function validate() {
        $valid = !preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $this->sanitized_data);
        if ($valid) {
            $this->validated_data = $number;       
        } else { 
            $this->hasError = true;
            $this->error = 'invalid URL';
        }
    }
}

class KeyValueField extends Field {

    protected $key_vals;

    function __construct($name, $isRequired, $KeyValuePairs) {
        $this->key_vals = $KeyValuePairs;
        parent::__construct($name, $isRequired);
    }

    protected function validate() {
        $valid = array_key_exists($this->sanitized_data, $this->key_vals);
        if ($valid){
            $this->validated_data = $this->key_vals[$this->sanitized_data];
        } else {
            $this->hasError = true;
            $this->error = 'invalid Key';
        }
    }
}

class Form {

    protected $fields;

    function __construct($fields) {
        $this->fields = $fields;
    }
}
?>

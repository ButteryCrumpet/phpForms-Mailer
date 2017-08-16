<?php

//ob_start stuff see link
//https://stackoverflow.com/questions/2061032/php-file-get-contents-with-php-intact
class Template {
    protected $file;
    protected $values;

    function __construct($template, $values) {
        $this->file = $template;
        $this->values = $values;
    }

    public function render() {
        $output = file_get_contents($this->file);

        foreach ($this->values as $key => $value) {
            $toReplace = "[@".$key."]";
            $output = str_replace($toReplace, $value, $output);
        }

        return $output;

    }
}

?>
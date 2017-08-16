<?php

//ob_start stuff see link
//https://stackoverflow.com/questions/2061032/php-file-get-contents-with-php-intact
class Template {
    protected $file;
    protected $values;
    protected $parsed;

    function __construct($template, $values) {
        $this->parsed = $this->parseTemplate($template);
        $this->values = $values;
    }

    public function render() {
        //abstract to replace,extract,etc functions
        foreach ($this->values as $key => $value) {
            $toReplace = "[@".$key."]";
            $output= str_replace($toReplace, $value, $this->parsed);
        }
        return $output;
    }

    protected function parseTemplate($file){
        ob_start();
        include $file;
        $parsed = ob_get_contents();
        ob_end_clean();
        return $parsed;
    }
}

?>
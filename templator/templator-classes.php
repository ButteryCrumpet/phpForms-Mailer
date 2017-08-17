<?php

//to the dom?
class Template {
    protected $file;
    protected $newOutput;
    protected $parsed;

    function __construct($template) {
        if (!file_exists($template)) {
            throw new Exception("Template file does not exist");
        } else {
            $this->parsed = $this->parseTemplate($template);
        }
    }

    public function render($echo = false) {
        if (!$newOutput) {
            if ($echo) {
                echo $this->parsed;
            }
            return $this->parsed;
        } else {
            if ($echo) {
                echo $this->newOutput;
            }
            return $this->newOutput;       
        }
    }

    public function get($pattern) {
        $matches;
        preg_match_all($pattern, $this->parsed, $matches);
        return $matches[0];
    }
    
    public function replace($values) { 
        $keys = array_keys($values);
        $vals = array_values($values);
        $this->newOutput = str_replace($keys, $vals, $this->parsed);
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
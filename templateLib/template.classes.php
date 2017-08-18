<?php

//rename and rewrite for common DOM manipulations
class Template {
    protected $file;
    public $DOM;
    protected $html;

    function __construct($template) {
        if (!file_exists($template)) {
            throw new Exception("Template file does not exist");
        } else {
            $this->html = $this->parseTemplate($template);
        }
    }

    public function render($echo = false) {
        if ($echo) {
            echo $this->html;
        }
        return $this->html;     
    }

    public function createDOM($whitespace = false) {
        $this->DOM = new domDocument();
        $this->DOM->loadHTML(mb_convert_encoding($this->html, 'HTML-ENTITIES', 'UTF-8'));
        if (!$whitespace) {
            $this->DOM->preserveWhiteSpace = false;
        }
        return $this->DOM;
    }

    public function get($pattern) {
        $matches;
        preg_match_all($pattern, $this->html, $matches);
        return $matches[0];
    }
    
    public function replace($values) { 
        $keys = array_keys($values);
        $vals = array_values($values);
        $this->newOutput = str_replace($keys, $vals, $this->html);
    }

    protected function parseTemplate($file){
        ob_start();
        include $file;
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }
}

?>
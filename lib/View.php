<?php
class View {
    
    private $data = array();

    function __construct() {
        ;
    }
    
    public function render($name) {
        require 'view/' . $name . '.php';
    }
    
    public function data($data) {
        $this->data = $data;
    }

}
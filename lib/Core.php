<?php
class Core {

    function __construct() {
        $session = new Session();
        $this->initSiteUrl();
    }
    
    private function initSiteUrl() {
        $f = $_SERVER["HTTP_HOST"] == 'localhost' || preg_match("/\d{3}\.\d{1}\.\d{1}\.\d{1}/i", $_SERVER["HTTP_HOST"]);
        if($f){
            $cfg = explode('/', $_SERVER["PHP_SELF"]);
            unset($cfg[count($cfg)-1]);
            $cfg = implode('/', $cfg);
        }
        define('URL', 'http://' . $_SERVER['HTTP_HOST'] . ($f ? $cfg : '') . '/');
    }

}
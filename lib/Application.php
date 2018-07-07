<?php
require 'core.php';
class Application extends Core {

    function __construct() {
        parent::__construct();
        $url = isset($_GET['p'])?$_GET['p']:null;
        $url = rtrim($url, '/');
        $url = explode('/', $url);
        if(empty($url[0])){
            require 'controller/index.php';
            $controller = new IndexController();
            $controller->index();
            return false;
        }
        $file = 'controller/' . $url[0] . '.php';
        if(file_exists($file)){
            require $file;
        } else{
            return $this->error();
        }
        $c = ucfirst($url[0]).'Controller';
        $controller = new $c();
        
        $isUrlMethodName = isset($url[1]);
        if($isUrlMethodName){
            $isMethod = method_exists($controller, $url[1]);
            $isParam = isset($url[2]);
            if($isParam && $isMethod){
                $controller->{$url[1]}($url[2]);
            } elseif($isMethod){
                $controller->{$url[1]}();
            } else{
                return $this->error();
            }
        } else {
            $controller->index();
        }
    }
    
    private function error() {
        require 'controller/error.php';
        $controller = new ErrorController();
        $controller->index();
        return false;
    }
}
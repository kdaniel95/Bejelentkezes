<?php
class Controller {
    
    protected $view;
    protected $model;

    function __construct() {
        $this->view = new View();
    }
    
    public function loadModel($name) {
        $path = 'model/' . $name . '.php';
        if(file_exists($path)){
            require $path;
            $modelName = $name . 'Model';
            $this->model = new $modelName();
        }
    }

}
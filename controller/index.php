<?php
class IndexController extends Controller {

    function __construct() {
        parent::__construct();
    }   
    public function index() {
        if(!isset($_SESSION['loggedin'])){
        $this->view->render('index/index');
        }else{
            $this -> view -> render('felulet/index');
        }
    }
}